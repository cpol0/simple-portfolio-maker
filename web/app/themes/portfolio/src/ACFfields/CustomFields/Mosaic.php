<?php

namespace Portfolio\ACFfields\CustomFields;

use WordPlate\Acf\Fields\Image;

class Mosaic
{

    public static function make(): array
    {
        return [
            Image::make('Mosaic Image large')
                ->instructions('Add an image in at least 12000x100px and only in the formats <strong>jpg</strong>, <strong>jpeg</strong> or <strong>png</strong>.')
                ->mimeTypes(['jpg', 'jpeg', 'png'])
                ->returnFormat('url') // id, url or array (default)
                ->previewSize('medium')
                ->required(),
            Image::make('Mosaic Image small 1')
                ->instructions('Add an image in at least 12000x100px and only in the formats <strong>jpg</strong>, <strong>jpeg</strong> or <strong>png</strong>.')
                ->mimeTypes(['jpg', 'jpeg', 'png'])
                ->returnFormat('url') // id, url or array (default)
                ->previewSize('medium') // thumbnail, medium or large
                ->required(),
            Image::make('Mosaic Image small 2')
                ->instructions('Add an image in at least 12000x100px and only in the formats <strong>jpg</strong>, <strong>jpeg</strong> or <strong>png</strong>.')
                ->mimeTypes(['jpg', 'jpeg', 'png'])
                ->returnFormat('url') // id, url or array (default)
                ->previewSize('medium') // thumbnail, medium or large
                ->required(),
        ];
    }
}
