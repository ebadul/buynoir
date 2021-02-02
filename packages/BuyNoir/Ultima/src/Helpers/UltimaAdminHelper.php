<?php

namespace BuyNoir\Ultima\Helpers;

use Illuminate\Support\Facades\Storage;

class UltimaAdminHelper
{
    /**
     * Returns the count rating of the product
     *
     * @return array
     */
    public function getUltimaMetaData($locale = null, $channel = null, $default = true)
    {
        $ultimaMetadataRepository = app('\BuyNoir\Ultima\Repositories\UltimaMetadataRepository');

        if (! $locale) {
            $locale = request()->get('locale') ?: app()->getLocale();
        }

        if (! $channel) {
            $channel = request()->get('channel') ?: 'default';
        }

        try {
            $metaData = $ultimaMetadataRepository->findOneWhere([
                'locale' => $locale,
                'channel' => $channel
            ]);

            if (! $metaData && $default) {
                $metaData = $ultimaMetadataRepository->findOneWhere([
                    'locale' => 'en',
                    'channel' => 'default'
                ]);
            }

            return $metaData;
        } catch (\Exception $exception) {
        }
    }

}