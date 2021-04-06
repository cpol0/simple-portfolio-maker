<?php

namespace Portfolio\Migrations;

use Exception;
use WP_Post;

class DefaultsPages
{
    const HOME_TEMPLATE = 'home.php';
    const CONTACT_TEMPLATE = 'contact.php';
    const CASESSTUDIESINDEX_TEMPLATE = 'archive-casestudy.php';

    public function __construct()
    {
        $this->make();
    }

    public function make(): void
    {
        if(!$this->pageExist(self::HOME_TEMPLATE)){
            $title = __('Home page', 'portfolio');
            $this->makePage([
                'post_title'     => $title,
                'post_name'      => sanitize_text_field($title),
                'post_content'   => 'This is the home page. Feel free to edit this page.',
                'meta_input'    => ['_wp_page_template' => self::HOME_TEMPLATE]
            ]);
        }

        if(!$this->pageExist(self::CONTACT_TEMPLATE)){
            $title = __('Contact me', 'portfolio');
            $this->makePage([
                'post_title'     => $title,
                'post_name'      => sanitize_text_field($title),
                'post_content'   => 'This is the contact page. Feel free to edit this page.',
                'meta_input'    => ['_wp_page_template' => self::CONTACT_TEMPLATE]
            ]);
        }

        if (!$this->pageExist(self::CASESSTUDIESINDEX_TEMPLATE)) {
            $title = __('My cases studies', 'portfolio');
            $this->makePage([
                'post_title'     => $title,
                'post_name'      => sanitize_text_field($title),
                'post_content'   => 'This is the cases studies index page. Feel free to edit this page.',
                'meta_input'    => ['_wp_page_template' => self::CASESSTUDIESINDEX_TEMPLATE]
            ]);
        }
    }

    public function pageExist(string $template): bool
    {
        $page = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $template
        ));
        return !empty($page);
    }

    public function makePage(array $customParams): int
    {
        $params = [
            'post_status'    => 'publish',
            'post_author'    => '1', // or "1" (super-admin?)
            'post_type'      => 'page',
            'comment_status' => 'closed',
            'ping_status'    => 'closed',    
        ];

        foreach($customParams as $key => $value){
            $params[$key] = $value;
        }

        try{
            return $page_id = wp_insert_post($params); 
        } catch(Exception $e){
            echo 'can\'t create default page: ',  $e->getMessage(), "\n";
        }
    }

    public static function getPages(?array $selection=null): array
    {
        $homePages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => self::HOME_TEMPLATE
        ));
        $contactPages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => self::CONTACT_TEMPLATE
        ));
        $casesStudiesIndexPages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => self::CASESSTUDIESINDEX_TEMPLATE
        ));

        if (empty($homePages) || empty($contactPages) || empty($casesStudiesIndexPages)) {
            throw new Exception('Default pages does not exists');
        }

        return [
            'home' => $homePages[0],
            'contact' => $contactPages[0],
            'casesstudies' => $casesStudiesIndexPages[0],
        ];
    }

    public static function getPage(string $template): WP_Post
    {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $template
        ));

        if (empty($pages)){
            throw new Exception("page with template $template does not exists");
        }

        return  $pages[0];
    }
}