<?php

namespace Portfolio\ACFfields;

use Portfolio\ACFfields\CustomFields\Block;
use Portfolio\ACFfields\CustomFields\Mosaic;
use Portfolio\ACFfields\CustomFields\Repeater;
use WordPlate\Acf\Fields\ButtonGroup;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Wysiwyg;
use WordPlate\Acf\Location;

class Work
{
    CONST MAX_BLOCK_ALLOWED = 5;

    public static function buildWorkPageFields(): void
    {

        $titles = [
            Text::make('Subtitle')
            ->instructions('Add the subtitle.')
            ->characterLimit(100)
            ->required(),
        ];

        $tags = [
            Wysiwyg::make('tags')
            ->instructions('Add the tags with a list of links')
            ->mediaUpload(false)
            ->tabs('visual')
            ->toolbar('simple')
            ->required()
        ];

        $mainTechno = [
            Text::make('Techno')
            ->instructions('Add the main techno used. ex: <i class="fab fa-symfony"></i>Symfony')
            ->characterLimit(100)
            ->required(),
        ];

        $back = [
            Link::make('Work-index')
            ->instructions('Please select work index page')
            ->required(),
        ];

        register_extended_field_group([
            'title' => 'Composition',
            'fields' => array_merge($titles, 
                Repeater::make(Block::class, self::MAX_BLOCK_ALLOWED), 
                Mosaic::make(), 
                $tags,
                $mainTechno,
                $back),
            'location' => [
                Location::if('post_type', "work"),
            ],
        ]);

    }
}