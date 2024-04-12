<?php

declare(strict_types=1);

namespace Mvenghaus\ScriptBootstrap\Contracts;

interface ScriptInterface
{
    public function run(): void;
}