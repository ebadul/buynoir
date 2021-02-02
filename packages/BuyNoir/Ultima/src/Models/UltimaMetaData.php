<?php

namespace BuyNoir\Ultima\Models;

use Illuminate\Database\Eloquent\Model;
use BuyNoir\Ultima\Contracts\UltimaMetaData as UltimaMetaDataContract;

class UltimaMetaData extends Model implements UltimaMetaDataContract
{
    protected $guarded = [];
    protected $table = 'ultima_meta_data';
}