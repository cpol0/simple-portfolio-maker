<?php


namespace Portfolio\Twig;

use Twig\TwigFilter;

class Block 
{
    public static function colClass($string, $type): string
    {
        if(($type === 'none') || ($type === 'fulltext')){
            return $string;
        } else{
            return $string.' col';
        }
    }

    public static function revealClass($string, $i): string
    {
        $time = $i+2;/* reveal-1 is alreay used for the title */

        $class = ($time>3)? '' : 'reveal-'.$time;

        return $string .' '.$class;
    }

    public static function ish2($title): ?string
    {
        if(!empty($title)){
            return "<h2>$title</h2>";
        }
        return null;
    }

    public static function cutOffBody(string $blockTxtImg)//: array
    {
        //preg_split ("/<img (.*?)>/" , $blockTxtImg, -1, PREG_SPLIT_DELIM_CAPTURE);
        //$text = preg_split("/<img (.*?)>/", $blockTxtImg);
        $imageFound = preg_match('/<img.*src="(.*?)".*>/', $blockTxtImg, $results);
        if($imageFound){
            $src = $results[1];
        }
        $text = str_replace($results[0], '', $blockTxtImg);

        return ['text' => $text, 'img' => $src];
    }

    public static function trimExtraBR (string $text)
    {
        $text = preg_replace('/(\s*)(?=<ul>)/', '', $text); /* Remove \r\n before <ul> */
        $text = preg_replace('/(\s*)(?=<p)/', '', $text); /* Remove \r\n before <p */
        return preg_replace('/(?<=<ul>|<\/li>)(\s*)(?=<\/ul>|<li>)/', '', $text); /* Remove \r\n in lists */
          
    }

    public static function technoTags(string $list)
    {
        $list = str_replace('<ul>', '<ul class="tags">', $list);
        return str_replace('<a', '<a class="tag"', $list);
    }

    public static function writeBlock(string $blockType, $title, $body): ?string
    {
        $str = null;

        switch($blockType){
            case 'fulltext':
                if(empty($title)){
                    $str = <<<EOT
<p>$body</p>
EOT;
                } else {
                    $str = <<<EOT
<h2>$title</h2>
<p>$body</p>
EOT;
                }
                break;
                case 'blocktextright':
                    default:
                    break;
        }
       
        return $str;
    }

}