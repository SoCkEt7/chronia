<?php

namespace App\Service\CrontabManager;

use App\Service\Platform\PlatformHandlerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class CrontabManagerFactory
{
    public function __construct(
        private PlatformHandlerInterface $platformHandler,
        private LoggerInterface $logger,
        private Filesystem $filesystem,
        private string $dataPath,
        private string $logPath,
        private string $tempDir,
        private array $allowedCommands,
        private string $environment,
        private ?string $defaultCrontabUser = null
    ) {}
    
    public function createManager(): CrontabManagerInterface
    {
        if ($this->environment === 'dev') {
            return new DevCrontabManager(
                $this->dataPath,
                $this->logPath,
                $this->filesystem
            );
        } else {
            return new ProdCrontabManager(
                $this->tempDir,
                $this->platformHandler,
                $this->logger,
                $this->allowedCommands,
                $this->defaultCrontabUser
            );
        }
    }
}