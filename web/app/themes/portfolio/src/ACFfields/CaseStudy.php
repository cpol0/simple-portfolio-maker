<?php

namespace Portfolio\ACFfields;

use Portfolio\ACFfields\CustomFields\Block;
use Portfolio\ACFfields\CustomFields\Mosaic;
use Portfolio\ACFfields\CustomFields\Repeater;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Wysiwyg;
use WordPlate\Acf\Location;

class CaseStudy
{
    CONST MAX_BLOCK_ALLOWED = 5;

    const SUBTITLE = 'subtitle';
    const TAGS_TITLE = 'tags-title';
    const TAGS = 'tags';
    const TECHNO = 'techno';
    const WORK_INDEX = 'work-index';

    public static function buildPageFields(): void
    {

        $titles = [
            Text::make(__('Subtitle', 'portfolio'), self::SUBTITLE)
            ->instructions(__('Add the subtitle.', 'portfolio'))
            ->characterLimit(100)
            ->required(),
        ];

        $tags = [
            Text::make(__('Tags title', 'portfolio'), self::TAGS_TITLE)
            ->instructions(__('Add the title.', 'portfolio'))
            ->characterLimit(100)
            ->required(),
            Wysiwyg::make(__('Tags', 'portfolio'), self::TAGS)
            ->instructions(__('Add the tags with a list of links', 'portfolio'))
            ->mediaUpload(false)
            ->tabs('visual')
            ->toolbar('simple')
            ->required()
        ];

        $mainTechno = [
            Text::make(__('Main technology', 'portfolio'), self::TECHNO)
            ->instructions(__('Add the main techno used.', 'portfolio') . ' ex: <i class="fab fa-symfony"></i>Symfony')
            ->characterLimit(100)
            ->required(),
        ];

        $back = [
            Link::make(__('Cases studies index page', 'portfolio'), self::WORK_INDEX)
            ->instructions(__('Please select work index page', 'portfolio'))
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
                Location::if('post_type', "casestudy"),
            ],
        ]);

    }
}