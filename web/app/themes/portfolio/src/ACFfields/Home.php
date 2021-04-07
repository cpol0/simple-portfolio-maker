<?php

namespace Portfolio\ACFfields;

use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;
use WordPlate\Acf\Fields\Wysiwyg;
use WordPlate\Acf\Location;

class Home
{
    const WELCOME_TITLE= 'welcome-title';
    const WELCOME_SUBTITLE = 'welcome-subtitle';
    const SKILLS_TITLE = 'skills-title';
    const SKILLS_SUBTITLE = 'skills-subtitle';
    const SKILLS_TEXT = 'skills-text';
    const SKILLS_TAGS = 'skills-tags';
    const WORKS_TITLE = 'works-title';
    const WORKS_SUBTITLE = 'works-subtitle';
    const ABOUT_TITLE = 'about-title';
    const ABOUT_SUBTITLE = 'about-subtitle';
    const ABOUT_TEXT = 'about-text';

    public static function builPageFields(): void
    {
        $homePageId = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'home.php'
        ))[0]->ID;
        
        $welcomeFields = [
            Text::make(__('Welcome section title', 'portfolio'), self::WELCOME_TITLE)
            ->instructions(__('Add your name', 'portfolio'))
            ->required(),
            Text::make(__('Welcome section subtitle', 'portfolio'), self::WELCOME_SUBTITLE)
            ->instructions(__( 'Add your job', 'portfolio'))
            ->required(),
        ];

        $skillsFields = [
            Text::make(__('Skills section title', 'portfolio'), self::SKILLS_TITLE)
            ->required(),
            Text::make(__('Skills section subtitle', 'portfolio'), self::SKILLS_SUBTITLE)
            ->required(),
            Wysiwyg::make(__('Skills description', 'portfolio'), self::SKILLS_TEXT)
            ->instructions(__('Describe your skills', 'portfolio'))
            ->mediaUpload(false)
            ->tabs('visual')
            ->toolbar('simple')
            ->required(),
            Textarea::make(__('Skills tags', 'portfolio'), self::SKILLS_TAGS)
            ->instructions(__('Describe your skills with tags with list of links', 'portfolio'))
            ->placeholder('<ul>
                                <li><a href="http://php.net"><i class="fab fa-php"></i></a></li>
                                <li><a href="http://symfony.com"><i class="fab fa-symfony"></i></a></li>
                                <li><a href="http://wordpress.com"><i class="fab fa-wordpress"></i></a></li>
                        </ul>')
           ,
        ];
        $works = [
            Text::make(__('Cases studies section title', 'portfolio'), self::WORKS_TITLE)
            ->required(),
            Text::make(__('Cases studies section subtitle', 'portfolio'), self::WORKS_SUBTITLE)
            ->required(),
        ];

        $about = [
            Text::make(__('About section title', 'portfolio'), self::ABOUT_TITLE)
            ->required(),
            Text::make(__('About section subtitle', 'portfolio'), self::ABOUT_SUBTITLE)
            ->required(),
            Wysiwyg::make(__('About section body', 'portfolio'), self::ABOUT_TEXT)
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