<?php

namespace Portfolio\Migrations;

use Exception;
use WP_Post;

class DefaultsMenus
{
    public function __construct()
    {
        $this->registerMenus();
    }

    public function registerMenus()
    {

        $homePages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => DefaultsPages::HOME_TEMPLATE
        ));
        $contactPages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => DefaultsPages::CONTACT_TEMPLATE
        ));
        $casesStudiesIndexPages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => DefaultsPages::CASESSTUDIESINDEX_TEMPLATE
        ));

        if(!empty($homePages) && !empty($contactPages) && !empty($casesStudiesIndexPages)){
            $homePage = $homePages[0];
            $contactPage = $contactPages[0];
            $casesStudiesIndexPage = $casesStudiesIndexPages[0];
        } else{
            throw new Exception('Default pages does not exists');
        }

        $menus = [
            __('Main menu', 'portfolio') => [
                'id' => 'header',
                'menu_items' => [
                    'index' => $casesStudiesIndexPage,
                    'about' => [
                        'url' => 'http://localhost:8000/#about', /* TODO: voir ce qui cloche avec site_url() */
                        'navigationTitle' => 'About',
                        'css' => '',
                    ],
                    'contact' => $contactPage,
                ],
            ],
            __('Logo','portfolio') => [
                'id' => 'logo',
                'menu_items' => [
                    'home' => [
                        'url' => 'http://localhost:8000', /* TODO: voir ce qui cloche avec site_url() */
                        'navigationTitle' => '<i class="fas fa-genderless"></i>',
                        'css' => '',
                    ],
                ],
            ],
            __('Social Medias','portfolio') => [
                'id' => 'footer',
                'menu_items' => [
                    'linkedin' => [
                        'url' => 'https://linkedin.fr', 
                        'navigationTitle' => '<i class="fab fa-linkedin"></i>',
                        'css' => 'social-icon',
                    ],
                    'github' => [
                        'url' => 'https://github.com',
                        'navigationTitle' => '<i class="fab fa-github"></i>',
                        'css' => 'social-icon',
                    ],
                ],
            ],
        ];


        foreach ($menus as $menu_title => $menu_var) {
            register_nav_menu($menu_var['id'], $menu_title);
            if (!is_nav_menu($menu_title)) {
                $menu_id = wp_create_nav_menu($menu_title);
                foreach ($menu_var['menu_items'] as $menu_item_name => $menu_item) {
                    if($menu_item instanceof WP_Post ){
                        $item = [
                            'menu-item-title' => $menu_item->post_title,
                            'menu-item-object-id' => $menu_item->ID,
                            'menu-item-object' => 'page',
                            'menu-item-status' => 'publish',
                            'menu-item-type' => 'post_type',
                            'menu-item-classes' => ($menu_item === $contactPage)? 'menu-button' : '',
                        ];
                    } else{ /* Assume this is a custom link */
                        $item = ['menu-item-type' => 'custom',
                                'menu-item-status' => 'publish',
                                'menu-item-title' => $menu_item['navigationTitle'],
                                'menu-item-url' => $menu_item['url'],
                                'menu-item-classes' => $menu_item['css'],
                            ];
                    }
                    wp_update_nav_menu_item($menu_id, 0, $item);

                    //Get all menu locations (including the one we just created above)
                    $locations = get_theme_mod('nav_menu_locations');
                    //set the menu to the new location and save into database
                    $locations[$menu_var['id']] = $menu_id;
                    set_theme_mod('nav_menu_locations', $locations);
                }
            }
        }
    }
}
