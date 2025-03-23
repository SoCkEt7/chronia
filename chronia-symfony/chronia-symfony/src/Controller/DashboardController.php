<?php

namespace App\Controller;

use App\Service\CrontabManager\CrontabManagerInterface;
use App\Service\Platform\PlatformHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private CrontabManagerInterface $crontabManager;
    private PlatformHandlerInterface $platformHandler;
    
    public function __construct(
        CrontabManagerInterface $crontabManager,
        PlatformHandlerInterface $platformHandler
    ) {
        $this->crontabManager = $crontabManager;
        $this->platformHandler = $platformHandler;
    }
    
    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {
        $entries = $this->crontabManager->getEntries();
        
        // Count active jobs
        $activeCount = count(array_filter($entries, function($entry) {
            return $entry['active'];
        }));
        
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
        
        // System status
        $systemStatus = [
            'cron_service' => $this->platformHandler->getCronServiceName(),
            'cron_running' => $this->platformHandler->isCronServiceRunning(),
            'platform' => $this->platformHandler->getPlatformInfo(),
            'environment' => $this->getParameter('kernel.environment'),
        ];
        
        return $this->render('dashboard/index.html.twig', [
            'active_count' => $activeCount,
            'total_count' => count($entries),
            'upcoming_jobs' => array_slice($upcomingJobs, 0, 5), // Show only the next 5
            'system_status' => $systemStatus,
        ]);
    }
}