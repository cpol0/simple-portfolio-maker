<?php

namespace Portfolio\ACFfields\CustomFields;

use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\ButtonGroup;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Wysiwyg;

class Block
{
    public static function make(?int $index = 0):array
    {
        $prevIndex = $index-1;
        $prevIndex = ($prevIndex < 0)? '' : $prevIndex;

        $blockInstructions=__("All texts must be between \"p\" markers. Don't forget to justify them (alt+ctrl+j). For blocks with image, simply add the picture after the text", 'portfolio');

        return [ButtonGroup::make(sprintf(__('Block %d type', 'portfolio'), $index), 'type'.$index)
                    ->instructions(__('Select the block type you want', 'portfolio'))
                    ->choices([
                        'none' => __('None', 'portfolio'),
                        'fulltext' => __('Full text', 'portfolio'),
                        '2textcolumns' => __('2 text columns', 'portfolio'),
                        'blocktextright' => __('Block text right', 'portfolio'),
                        'blocktextleft' => __('Block text left', 'portfolio'),
                    ])
                    ->defaultValue('none')
                    ->returnFormat('value') // array, label or value (default)
                    //TODO: it could be nice to show the blocks only if the previous is set
                    //->conditionalLogic([
                    //    ConditionalLogic::if('type'.$prevIndex)->notEquals('none')
                    //
                    //])
                    ,
                Text::make(sprintf(__('Title %d', 'portfolio'), $index), 'title'.$index)
                    ->instructions(__('Add the block title.', 'portfolio'))
                    ->characterLimit(100)
                    ->conditionalLogic([
                            ConditionalLogic::if('type' . $index)->notEquals('none')
                        ])
                        ,
                Wysiwyg::make(sprintf(__('Block %d body', 'portfolio'), $index), 'block'.$index)
                    ->instructions($blockInstructions) 
                    ->tabs('visual')
                    ->toolbar('simple')
                    ->required()
                    ->conditionalLogic([
                        ConditionalLogic::if('type'.$index)->notEquals('none')
                    ]),
                Wysiwyg::make(sprintf(__('Block %d - 2nd column body', 'portfolio'), $index), 'block' . $index.'-secondtextcolumn')
                    ->instructions($blockInstructions)
                    ->tabs('visual')
                    ->toolbar('simple')
                    ->required()
                    ->conditionalLogic([
                        ConditionalLogic::if('type' . $index)->Equals('2textcolumns')
                    ]),
                ];
    }
}