<?php

namespace App\Command;

use App\Service\CrontabManager\CrontabManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:cron:list',
    description: 'List all cron jobs',
)]
class ListJobsCommand extends Command
{
    private CrontabManagerInterface $crontabManager;
    
    public function __construct(CrontabManagerInterface $crontabManager)
    {
        parent::__construct();
        $this->crontabManager = $crontabManager;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Cron Jobs');
        
        $entries = $this->crontabManager->getEntries();
        
        if (empty($entries)) {
            $io->warning('No cron jobs found.');
            return Command::SUCCESS;
        }
        
        $table = new Table($output);
        $table->setHeaders(['ID', 'Schedule', 'Command', 'Status', 'Last Run']);
        
        foreach ($entries as $entry) {
            $status = $entry['active'] ? '<info>Active</info>' : '<comment>Inactive</comment>';
            
            $lastRun = 'Never run';
            if ($entry['last_run']['time']) {
                $lastRunStatus = $entry['last_run']['status'] ? '<info>Success</info>' : '<error>Failed</error>';
                $lastRun = $entry['last_run']['time'] . ' ' . $lastRunStatus;
            }
            
            $table->addRow([
                $entry['id'],
                $entry['schedule'],
                $entry['command'],
                $status,
                $lastRun,
            ]);
        }
        
        $table->render();
        
        return Command::SUCCESS;
    }
}