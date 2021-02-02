<?php

namespace BuyNoir\Ultima\Repositories;

use Webkul\Core\Eloquent\Repository;

class UltimaMetadataRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'BuyNoir\Ultima\Contracts\UltimaMetaData';
    }
}