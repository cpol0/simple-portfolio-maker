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

        $blockInstructions="All texts must be between \"p\" markers. Don't forget to justify them (alt+ctrl+j). For blocks with image, simply add the picture after the text";

        return [ButtonGroup::make('Type'.$index)
                    ->instructions('Select the block type you want')
                    ->choices([
                        'none' => 'None',
                        'fulltext' => 'Full text',
                        '2textcolumns' => '2 text columns',
                        'blocktextright' => 'Block text right',
                        'blocktextleft' => 'Block text left',
                    ])
                    ->defaultValue('short')
                    ->returnFormat('value') // array, label or value (default)
                    //->required()
                    //TODO: essayer de n'afficher le block1 que si le 0 est différent de none
                    //->conditionalLogic([
                    //    //ConditionalLogic::if('type'.$prevIndex)->notEquals('none')
            //
                    //])
                    ,
                Text::make('Title'.$index)
                    ->instructions('Add the title.')
                    ->characterLimit(100)
                    ->conditionalLogic([
                            ConditionalLogic::if('type' . $index)->notEquals('none')
                        ])
                        ,
                Wysiwyg::make('Block'.$index)
                    ->instructions($blockInstructions) 
                    //->mediaUpload(false)
                    ->tabs('visual')
                    ->toolbar('simple')
                    ->required()
                    ->conditionalLogic([
                        ConditionalLogic::if('type'.$index)->notEquals('none')
                    ]),
                Wysiwyg::make('Block' . $index.'-secondTextColumn')
                    ->instructions($blockInstructions)
                    //->mediaUpload(false)
                    ->tabs('visual')
                    ->toolbar('simple')
                    ->required()
                    ->conditionalLogic([
                        ConditionalLogic::if('type' . $index)->Equals('2textcolumns')
                    ]),
                ];
    }
}