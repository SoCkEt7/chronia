<?php

namespace App\Controller;

use App\Form\CronJobType;
use App\Service\CrontabManager\CrontabManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jobs')]
class CronJobController extends AbstractController
{
    private CrontabManagerInterface $crontabManager;
    
    public function __construct(CrontabManagerInterface $crontabManager)
    {
        $this->crontabManager = $crontabManager;
    }
    
    #[Route('/', name: 'app_job_index', methods: ['GET'])]
    public function index(): Response
    {
        $entries = $this->crontabManager->getEntries();
        
        return $this->render('job/index.html.twig', [
            'entries' => $entries,
        ]);
    }
    
    #[Route('/new', name: 'app_job_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $form = $this->createForm(CronJobType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $schedule = $data['schedule'];
            $command = $data['command'];
            
            $success = $this->crontabManager->addEntry($schedule, $command);
            
            if ($success) {
                $this->addFlash('success', 'Job added successfully');
                return $this->redirectToRoute('app_job_index');
            } else {
                $this->addFlash('error', 'Failed to add job');
            }
        }
        
        return $this->render('job/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_job_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $entries = $this->crontabManager->getEntries();
        $entry = null;
        
        foreach ($entries as $e) {
            if ($e['id'] == $id) {
                $entry = $e;
                break;
            }
        }
        
        if ($entry === null) {
            throw $this->createNotFoundException('The job does not exist');
        }
        
        $form = $this->createForm(CronJobType::class, [
            'schedule' => $entry['schedule'],
            'command' => $entry['command'],
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $schedule = $data['schedule'];
            $command = $data['command'];
            
            $success = $this->crontabManager->updateEntry($id, $schedule, $command);
            
            if ($success) {
                $this->addFlash('success', 'Job updated successfully');
                return $this->redirectToRoute('app_job_index');
            } else {
                $this->addFlash('error', 'Failed to update job');
            }
        }
        
        return $this->render('job/edit.html.twig', [
            'entry' => $entry,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}/test', name: 'app_job_test', methods: ['GET'])]
    public function test(int $id): Response
    {
        $result = $this->crontabManager->testRun($id);
        
        if ($result === false) {
            throw $this->createNotFoundException('The job does not exist');
        }
        
        return $this->render('job/test.html.twig', [
            'id' => $id,
            'result' => $result,
        ]);
    }
    
    #[Route('/{id}/toggle/{active}', name: 'app_job_toggle', methods: ['GET'])]
    public function toggle(int $id, bool $active): Response
    {
        $success = $this->crontabManager->toggleEntryActive($id, $active);
        
        if ($success) {
            $this->addFlash('success', $active ? 'Job activated' : 'Job deactivated');
        } else {
            $this->addFlash('error', 'Failed to update job');
        }
        
        return $this->redirectToRoute('app_job_index');
    }
    
    #[Route('/{id}/delete', name: 'app_job_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $success = $this->crontabManager->deleteEntry($id);
            
            if ($success) {
                $this->addFlash('success', 'Job deleted successfully');
            } else {
                $this->addFlash('error', 'Failed to delete job');
            }
        }
        
        return $this->redirectToRoute('app_job_index');
    }
}