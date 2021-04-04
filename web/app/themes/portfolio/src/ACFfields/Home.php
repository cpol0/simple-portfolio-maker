<?php

namespace Portfolio\ACFfields;

use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Wysiwyg;
use WordPlate\Acf\Location;

class Home
{
    public static function builPageFields(): void
    {
        $homePageId = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'home.php'
        ))[0]->ID;
        
        $welcomeFields = [
            Text::make(__('Welcome section title', 'portfolio'), 'welcome-title')
            ->instructions(__('Add your name', 'portfolio'))
            ->required(),
            Text::make(__('Welcome section subtitle', 'portfolio'), 'welcome-subtitle')
            ->instructions(__( 'Add your job', 'portfolio'))
            ->required(),
        ];

        $skillsFields = [
            Text::make(__('Skills section title', 'portfolio'), 'skills-title')
            ->required(),
            Text::make(__('Skills section subtitle', 'portfolio'), 'skills-subtitle')
            ->required(),
            Wysiwyg::make(__('Skills description', 'portfolio'), 'skills-text')
            ->instructions('Describe your skills')
            ->mediaUpload(false)
            ->tabs('visual')
            ->toolbar('simple')
            ->required(),
        ];
        $works = [
            Text::make(__('Cases studies section title', 'portfolio'), 'works-title')
            ->required(),
            Text::make(__('Cases studies section subtitle', 'portfolio'), 'works-subtitle')
            ->required(),
        ];

        $about = [
            Text::make(__('About section title', 'portfolio'), 'about-title')
            ->required(),
            Text::make(__('About section subtitle', 'portfolio'), 'about-subtitle')
            ->required(),
            Wysiwyg::make(__('About section body', 'portfolio'), 'about-text')
            ->instructions(__('Describe yourself', 'portfolio'))
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