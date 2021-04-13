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
        $pages = DefaultsPages::getPages();
        $homePage = $pages['home'];
        $contactPage = $pages['contact'];
        $casesStudiesIndexPage = $pages['casesstudies'];

        $menus = [
            __('Main menu', 'portfolio') => [
                'id' => 'header',
                'menu_items' => [
                    'index' => $casesStudiesIndexPage,
                    'about' => [
                        'url' => get_home_url().'/#about',
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
                        'url' => get_home_url(),
                        'navigationTitle' => '<i class="fas fa-genderless"></i>',
                        'css' => '',
                    ],
                ],
            ],
            __('Social Medias','portfolio') => [
                'id' => 'footer',
                'menu_items' => [
                    'linkedin' => [
                        'url' => 'https://www.linkedin.com/in/pol-carr%C3%A9/', 
                        'navigationTitle' => '<i class="fab fa-linkedin"></i>',
                        'css' => 'social-icon',
                    ],
                    'github' => [
                        'url' => 'https://github.com/cpol0',
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
