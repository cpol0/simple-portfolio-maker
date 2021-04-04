<?php

namespace Portfolio\ACFfields\CustomFields;

use WordPlate\Acf\Fields\Image;

class Mosaic
{

    public static function make(): array
    {
        return [
            Image::make(__('Large mosaic image', 'portfolio')   , 'mosaic-image-large')
                ->instructions(__('Add an image in at least 500x600px and only in the formats', 'portfolio').'<strong>jpg</strong>, <strong>jpeg</strong> or <strong>png</strong>.')
                ->mimeTypes(['jpg', 'jpeg', 'png'])
                ->returnFormat('url') // id, url or array (default)
                ->previewSize('medium')
                ->required(),
            Image::make(__('Small mosaic image 1', 'portfolio'), 'mosaic-image-small-1')
                ->instructions(__('Add an image in at least 500x288px and only in the formats', 'portfolio') . ' <strong>jpg</strong>, <strong>jpeg</strong> or <strong>png</strong>.')
                ->mimeTypes(['jpg', 'jpeg', 'png'])
                ->returnFormat('url') // id, url or array (default)
                ->previewSize('medium') // thumbnail, medium or large
                ->required(),
            Image::make(__('Small mosaic image 2', 'portfolio'), 'mosaic-image-small-2')
                ->instructions(__('Add an image in at least 500x288px and only in the formats', 'portfolio') . ' <strong>jpg</strong>, <strong>jpeg</strong> or <strong>png</strong>.')
                ->mimeTypes(['jpg', 'jpeg', 'png'])
                ->returnFormat('url') // id, url or array (default)
                ->previewSize('medium') // thumbnail, medium or large
                ->required(),
        ];
    }
}
