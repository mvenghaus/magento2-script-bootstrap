<?php

declare(strict_types=1);

namespace Mvenghaus\ScriptBootstrap;

use Exception;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\AppInterface;

class App implements AppInterface
{
    private string $scriptFQCN;

    public function setScriptFQCN(string $scriptFQCN): self
    {
        $this->scriptFQCN = $scriptFQCN;

        return $this;
    }

    public function launch()
    {
        $objectManager = ObjectManager::getInstance();

        $objectManager->get($this->scriptFQCN)->run();

        return $objectManager->get(ResponseInterface::class);
    }

    public function catchException(Bootstrap $bootstrap, Exception $exception)
    {
        throw $exception;
    }
}
