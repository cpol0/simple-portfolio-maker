<?php

namespace Portfolio\ACFfields;

use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Wysiwyg;
use WordPlate\Acf\Location;

class Home
{
    public static function builHomePageFields(): void
    {
        $homePageId = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'home.php'
        ))[0]->ID;
        
        $welcomeFields = [
            Text::make('Welcome Title')
            ->instructions('Add your name')
            ->required(),
            Text::make('Welcome Subtitle')
            ->instructions('Add your job')
            ->required(),
        ];

        $skillsFields = [
            Text::make('Skills Title')
            ->required(),
            Text::make('Skills Subtitle')
            ->required(),
            Wysiwyg::make('Skills Text')
            ->instructions('Describe your skills')
            ->mediaUpload(false)
                ->tabs('visual')
                ->toolbar('simple')
                ->required(),
        ];
        $works = [
            Text::make('Works Title')
            ->required(),
            Text::make('Works Subtitle')
            ->required(),
        ];

        $about = [
            Text::make('About Title')
            ->required(),
            Text::make('About Subtitle')
            ->required(),
            Wysiwyg::make('About Text')
            ->instructions('Describe yourself')
            ->mediaUpload(false)
                ->tabs('visual')
                ->toolbar('simple')
                ->required(),
        ];

        register_extended_field_group([
            'title' => 'Welcome',
            'fields' => array_merge(
                $welcomeFields,
                $skillsFields,
                $works,
                $about,
            ),
            'location' => [
                Location::if('page', "$homePageId"),
            ],
        ]);
    }
}