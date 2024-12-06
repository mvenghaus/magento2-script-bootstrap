<?php

declare(strict_types=1);

namespace Mvenghaus\ScriptBootstrap\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class SetArea
{
    public string $areaCode;

    public function __construct(string $areaCode)
    {
        $this->areaCode = $areaCode;
    }
}