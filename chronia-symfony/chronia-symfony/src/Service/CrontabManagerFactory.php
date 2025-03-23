<?php

namespace App\Service;

use App\Service\CrontabManager\CrontabManagerInterface;
use App\Service\CrontabManager\DevCrontabManager;
use App\Service\CrontabManager\ProdCrontabManager;
use App\Service\Platform\PlatformHandlerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class CrontabManagerFactory
{
    private string $dataPath;
    private string $logPath;
    private string $crontabUser;
    private string $tempDir;
    private PlatformHandlerInterface $platformHandler;
    private LoggerInterface $logger;
    private Filesystem $filesystem;
    private array $allowedCommands;
    
    public function __construct(
        string $dataPath,
        string $logPath,
        string $crontabUser,
        PlatformHandlerInterface $platformHandler,
        LoggerInterface $logger,
        Filesystem $filesystem,
        array $allowedCommands
    ) {
        $this->dataPath = $dataPath;
        $this->logPath = $logPath;
        $this->crontabUser = $crontabUser;
        $this->tempDir = sys_get_temp_dir();
        $this->platformHandler = $platformHandler;
        $this->logger = $logger;
        $this->filesystem = $filesystem;
        $this->allowedCommands = $allowedCommands;
    }
    
    /**
     * Create the appropriate CrontabManager based on the environment
     */
    public function __invoke(string $environment): CrontabManagerInterface
    {
        if ($environment === 'dev') {
            return new DevCrontabManager(
                $this->dataPath,
                $this->logPath,
                $this->filesystem
            );
        } else {
            return new ProdCrontabManager(
                $this->crontabUser,
                $this->tempDir,
                $this->platformHandler,
                $this->logger,
                $this->allowedCommands
            );
        }
    }
}