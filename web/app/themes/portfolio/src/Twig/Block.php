<?php


namespace Portfolio\Twig;

/**
 * Block
 * Twig filters & functions to easily deal with blocks
 */
class Block 
{    
    /**
     * colClass
     * Add a 'col' class
     *
     * @param  mixed $string
     * @param  mixed $type
     * @return string
     */
    public static function colClass($string, $type): string
    {
        if(($type === 'none') || ($type === 'fulltext')){
            return $string;
        } else{
            return $string.' col';
        }
    }
    
    /**
     * revealClass
     * Add 'reveal' class
     *
     * @param  mixed $string
     * @param  mixed $i
     * @return string
     */
    public static function revealClass($string, $i): string
    {
        $time = $i+2;/* reveal-1 is alreay used for the title */

        $class = ($time>3)? '' : 'reveal-'.$time;

        return $string .' '.$class;
    }
    
    /**
     * ish2
     * Insert <h2></h2> only if title is set
     *
     * @param  mixed $title
     * @return string
     */
    public static function ish2($title): ?string
    {
        if(!empty($title)){
            return "<h2>$title</h2>";
        }
        return null;
    }
    
    /**
     * cutOffBody
     * Split a block in 2 parts: return the url of the image and the text of the block
     *
     * @param  mixed $blockTxtImg
     * @return array
     */
    public static function cutOffBody(string $blockTxtImg): array
    {
        $imageFound = preg_match('/<img.*src="(.*?)".*>/', $blockTxtImg, $results);
        if($imageFound){
            $src = $results[1];
            $text = str_replace($results[0], '', $blockTxtImg);
        } else {
            $text = $blockTxtImg;
            $src = '';
        }

        return ['text' => $text, 'img' => $src];
    }
    
    /**
     * trimExtraBR
     * Wordpress wysiwyg add unwanted \r\n, which leads to extra <br> when nl2br filter is called. 
     *
     * @param  mixed $text
     * @return void
     */
    public static function trimExtraBR (?string $text=null): ?string
    {
        if($text==null){
            return null;
        }

        $text = preg_replace('/(\s*)(?=<ul>)/', '', $text); /* Remove \r\n before <ul> */
        $text = preg_replace('/(\s*)(?=<p)/', '', $text); /* Remove \r\n before <p */
        return preg_replace('/(?<=<ul>|<\/li>)(\s*)(?=<\/ul>|<li>)/', '', $text); /* Remove \r\n in lists */
          
    }
    
    /**
     * technoTags
     * Add classes to fit the CSS
     *
     * @param  mixed $list
     * @return string
     */
    public static function technoTags(string $list): string
    {
        $list = str_replace('<ul>', '<ul class="tags">', $list);
        return str_replace('<a', '<a class="tag"', $list);
    }

    /**
     * skillsTags
     * Add classes to fit the CSS
     *
     * @param  mixed $list
     * @return string|null
     */
    public static function skillsTags(?string $list=null): ?string
    {
        if($list === null){
            return null;
        }
        $list = str_replace('<ul>', '<ul class="skills">', $list);
        return str_replace('<a', '<a class="skill"', $list);
    }
}