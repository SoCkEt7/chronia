<?php
/**
 * Controller.php - Main controller for handling web requests
 */

namespace Chrona;

class Controller {
    private $crontabManager;
    private $view;
    
    /**
     * Constructor
     */
    public function __construct() {
        // Use DevCrontabManager in development mode
        if (defined('CHRONA_DEV_MODE') && CHRONA_DEV_MODE) {
            $this->crontabManager = new DevCrontabManager();
        } else {
            $this->crontabManager = new CrontabManager();
        }
        
        $this->view = new View();
    }
    
    /**
     * Show the dashboard
     */
    public function dashboard() {
        $entries = $this->crontabManager->getEntries();
        
        // Get upcoming scheduled jobs
        $upcomingJobs = [];
        foreach ($entries as $entry) {
            if ($entry['active']) {
                $nextRun = $this->crontabManager->getNextRunTimes($entry['schedule'], 1);
                if (!empty($nextRun)) {
                    $upcomingJobs[] = [
                        'id' => $entry['id'],
                        'command' => $entry['command'],
                        'next_run' => $nextRun[0]
                    ];
                }
            }
        }
        
        // Sort by next run time
        usort($upcomingJobs, function($a, $b) {
            return strtotime($a['next_run']) - strtotime($b['next_run']);
        });
        
        $this->view->render('dashboard', [
            'active_count' => count(array_filter($entries, function($entry) { return $entry['active']; })),
            'total_count' => count($entries),
            'upcoming_jobs' => array_slice($upcomingJobs, 0, 5) // Show only the next 5
        ]);
    }
    
    /**
     * List all cron jobs
     */
    public function listJobs() {
        $entries = $this->crontabManager->getEntries();
        
        $this->view->render('list', [
            'entries' => $entries
        ]);
    }
    
    /**
     * Show the edit job form
     */
    public function editJob() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect('list');
            return;
        }
        
        $entries = $this->crontabManager->getEntries();
        $entry = null;
        
        foreach ($entries as $e) {
            if ($e['id'] == $id) {
                $entry = $e;
                break;
            }
        }
        
        if ($entry === null) {
            $this->notFound();
            return;
        }
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $schedule = $_POST['schedule'] ?? '';
            $command = $_POST['command'] ?? '';
            
            if (!empty($schedule) && !empty($command)) {
                if ($this->crontabManager->updateEntry($id, $schedule, $command)) {
                    $this->redirect('list', ['success' => 'Job updated successfully']);
                } else {
                    $this->view->render('edit', [
                        'entry' => $entry,
                        'error' => 'Failed to update job'
                    ]);
                }
            } else {
                $this->view->render('edit', [
                    'entry' => $entry,
                    'error' => 'Schedule and command are required'
                ]);
            }
        } else {
            $this->view->render('edit', [
                'entry' => $entry
            ]);
        }
    }
    
    /**
     * Show the add job form
     */
    public function addJob() {
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $schedule = $_POST['schedule'] ?? '';
            $command = $_POST['command'] ?? '';
            
            if (!empty($schedule) && !empty($command)) {
                if ($this->crontabManager->addEntry($schedule, $command)) {
                    $this->redirect('list', ['success' => 'Job added successfully']);
                } else {
                    $this->view->render('add', [
                        'error' => 'Failed to add job',
                        'schedule' => $schedule,
                        'command' => $command
                    ]);
                }
            } else {
                $this->view->render('add', [
                    'error' => 'Schedule and command are required',
                    'schedule' => $schedule,
                    'command' => $command
                ]);
            }
        } else {
            $this->view->render('add');
        }
    }
    
    /**
     * Test run a job
     */
    public function testJob() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect('list');
            return;
        }
        
        $result = $this->crontabManager->testRun($id);
        
        if ($result === false) {
            $this->notFound();
            return;
        }
        
        $this->view->render('test', [
            'id' => $id,
            'result' => $result
        ]);
    }
    
    /**
     * Toggle a job's active state
     */
    public function toggleJob() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $active = isset($_GET['active']) ? (bool)$_GET['active'] : false;
        
        if ($id <= 0) {
            $this->redirect('list');
            return;
        }
        
        if ($this->crontabManager->toggleEntryActive($id, $active)) {
            $this->redirect('list', ['success' => $active ? 'Job activated' : 'Job deactivated']);
        } else {
            $this->redirect('list', ['error' => 'Failed to update job']);
        }
    }
    
    /**
     * Delete a job
     */
    public function deleteJob() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect('list');
            return;
        }
        
        if ($this->crontabManager->deleteEntry($id)) {
            $this->redirect('list', ['success' => 'Job deleted successfully']);
        } else {
            $this->redirect('list', ['error' => 'Failed to delete job']);
        }
    }
    
    /**
     * Handle API requests
     */
    public function handleApi() {
        header('Content-Type: application/json');
        
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        
        switch ($action) {
            case 'list':
                echo json_encode([
                    'success' => true,
                    'entries' => $this->crontabManager->getEntries()
                ]);
                break;
            
            case 'next_runs':
                $schedule = isset($_GET['schedule']) ? $_GET['schedule'] : '';
                $count = isset($_GET['count']) ? (int)$_GET['count'] : 5;
                
                echo json_encode([
                    'success' => true,
                    'next_runs' => $this->crontabManager->getNextRunTimes($schedule, $count)
                ]);
                break;
            
            default:
                echo json_encode([
                    'success' => false,
                    'error' => 'Unknown action'
                ]);
        }
    }
    
    /**
     * Show 404 not found page
     */
    public function notFound() {
        header('HTTP/1.0 404 Not Found');
        $this->view->render('404');
    }
    
    /**
     * Redirect to another page
     */
    private function redirect($page, $params = []) {
        $url = 'index.php?page=' . urlencode($page);
        
        foreach ($params as $key => $value) {
            $url .= '&' . urlencode($key) . '=' . urlencode($value);
        }
        
        header('Location: ' . $url);
        exit;
    }
}