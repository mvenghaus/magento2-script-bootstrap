<?php

declare(strict_types=1);

namespace Mvenghaus\ScriptBootstrap;

use Magento\Framework\App\Bootstrap as MagentoBootstrap;

class Bootstrap
{
    public static function run(string $scriptFQCN): void
    {
        $bootstrap = MagentoBootstrap::create(BP, $_SERVER);

        /** @var App $app */
        $app = $bootstrap
            ->createApplication(App::class)
            ->setScriptFQCN($scriptFQCN);

        $bootstrap->run($app);
    }
}