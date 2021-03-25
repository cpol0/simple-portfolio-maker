<?php

namespace Portfolio\ACFfields\CustomFields;

class Repeater
{
    public static function make(string $className, int $nb)
    {
        $fields = [];
        for($i=0; $i < $nb; $i++){
            $fields = array_merge($fields, $className::make($i));
        }
        return $fields;
    }
}