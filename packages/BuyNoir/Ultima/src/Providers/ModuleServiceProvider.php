<?php

namespace BuyNoir\Ultima\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \BuyNoir\Ultima\Models\UltimaMetaData::class
    ];
}