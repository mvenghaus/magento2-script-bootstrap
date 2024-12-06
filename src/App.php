<?php

declare(strict_types=1);

namespace Mvenghaus\ScriptBootstrap;

use Exception;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\State;
use Magento\Framework\AppInterface;
use Magento\Framework\Registry;
use Mvenghaus\ScriptBootstrap\Attributes\SetArea;
use Mvenghaus\ScriptBootstrap\Attributes\SetSecureArea;
use ReflectionClass;

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

        $this->handleAttributes($this->scriptFQCN);

        $objectManager->get($this->scriptFQCN)->run();

        return $objectManager->get(ResponseInterface::class);
    }

    public function catchException(Bootstrap $bootstrap, Exception $exception)
    {
        throw $exception;
    }

    private function handleAttributes(string $scriptFQCN): void
    {
        $reflectionClass = new ReflectionClass($scriptFQCN);

        foreach ($reflectionClass->getMethods() as $method) {
            if ($method->getName() !== 'run') {
                continue;
            }

            foreach ($method->getAttributes() as $attribute) {
                match ($attribute->getName()) {
                    SetArea::class => $this->handleAttributeSetArea($attribute->getArguments()),
                    SetSecureArea::class => $this->handleAttributeSetSecureArea(),
                };
            }
        }
    }

    private function handleAttributeSetArea(array $arguments): void
    {
        ObjectManager::getInstance()->get(State::class)
            ->setAreaCode(current($arguments));
    }

    private function handleAttributeSetSecureArea(): void
    {
        ObjectManager::getInstance()->get(Registry::class)
            ->register('isSecureArea', true);
    }
}
