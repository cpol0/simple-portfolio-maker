<?php

namespace Portfolio\ACFfields;

use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Location;

class Contact
{
    public static function buildPageFields(): void
    {
        $pageId = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'contact.php'
        ))[0]->ID;
        
        $fields = [
            Text::make(__('Subtitle', 'portfolio'), 'subtitle')
            ->required(),
        ];

        register_extended_field_group([
            'title' => 'Contact',
            'fields' => array_merge(
                $fields,
            ),
            'location' => [
                Location::if('page', "$pageId"),
            ],
        ]);
    }
}