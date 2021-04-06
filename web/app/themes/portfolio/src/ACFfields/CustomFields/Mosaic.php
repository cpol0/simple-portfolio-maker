<?php

namespace Portfolio\ACFfields\CustomFields;

use WordPlate\Acf\Fields\Image;

class Mosaic
{
    const MOSAIC_IMAGE_LARGE = 'mosaic-image-large';
    const MOSAIC_IMAGE_SMALL1 = 'mosaic-image-small-1';
    const MOSAIC_IMAGE_SMALL2 = 'mosaic-image-small-2';

    public static function make(): array
    {
        return [
            Image::make(__('Large mosaic image', 'portfolio')   , self::MOSAIC_IMAGE_LARGE)
                ->instructions(__('Add an image in at least 500x600px and only in the formats', 'portfolio').'<strong>jpg</strong>, <strong>jpeg</strong> or <strong>png</strong>.')
                ->mimeTypes(['jpg', 'jpeg', 'png'])
                ->returnFormat('url') // id, url or array (default)
                ->previewSize('medium')
                ->required(),
            Image::make(__('Small mosaic image 1', 'portfolio'), self::MOSAIC_IMAGE_SMALL1)
                ->instructions(__('Add an image in at least 500x288px and only in the formats', 'portfolio') . ' <strong>jpg</strong>, <strong>jpeg</strong> or <strong>png</strong>.')
                ->mimeTypes(['jpg', 'jpeg', 'png'])
                ->returnFormat('url') // id, url or array (default)
                ->previewSize('medium') // thumbnail, medium or large
                ->required(),
            Image::make(__('Small mosaic image 2', 'portfolio'), self::MOSAIC_IMAGE_SMALL2)
                ->instructions(__('Add an image in at least 500x288px and only in the formats', 'portfolio') . ' <strong>jpg</strong>, <strong>jpeg</strong> or <strong>png</strong>.')
                ->mimeTypes(['jpg', 'jpeg', 'png'])
                ->returnFormat('url') // id, url or array (default)
                ->previewSize('medium') // thumbnail, medium or large
                ->required(),
        ];
    }
}
