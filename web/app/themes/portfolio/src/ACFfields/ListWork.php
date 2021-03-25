<?php

namespace Portfolio\ACFfields;

use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Wysiwyg;
use WordPlate\Acf\Location;

class ListWork
{
    public static function buildWorkListPageFields(): void
    {
        $pageId = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'archive-work.php'
        ))[0]->ID;
        
        $fields = [
            Text::make('Subtitle')
            ->required(),
        ];

        register_extended_field_group([
            'title' => 'List',
            'fields' => array_merge(
                $fields,
            ),
            'location' => [
                Location::if('page', "$pageId"),
            ],
        ]);
    }
}