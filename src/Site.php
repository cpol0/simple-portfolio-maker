<?php

namespace App;

use Timber\Site as TimberSite;
use Twig\Environment;

class Site extends TimberSite
{
    public function __construct($site_name_or_id = null)
    {
        add_action('wp_enqueue_scripts', [$this, 'registerAssets']);
        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_style('admin_portfolio', get_template_directory_uri() . '/assets/admin.css');
        });
        add_action('wp_head', function () {
            echo '<link rel="icon" type="image/svg" href="../app/themes/portfolio/assets/img/code.svg"/>';
        });
        add_action('after_setup_theme', function () {
            add_theme_support('title-tag');
            add_theme_support('menus');
            add_theme_support('html5');
            add_theme_support('post-thumbnails');
        });
        add_action('init', [$this, 'disable_emojis']);
        parent::__construct($site_name_or_id);
    }

    public function registerAssets()
    {
        wp_register_style('icons', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css", []);
        wp_register_style('font_inconsolata', "https://fonts.googleapis.com/css2?family=Inconsolata&display=swap", []);
        wp_register_style('main', /* get_stylesheet_directory() . */ '/../app/themes/portfolio/assets/app.css', []);
        wp_register_script('main', /* get_stylesheet_directory(). */ '/../app/themes/portfolio/assets/app.js', [], false, true);
        wp_enqueue_style('main');
        wp_enqueue_style('font_inconsolata');
        wp_enqueue_style('icons');
        wp_enqueue_script('main');
    }

    /**
     * Disable the emoji's
     */
    public function disable_emojis()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

        // Remove from TinyMCE
        add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    }


    /**
     * Filter out the tinymce emoji plugin.
     */
    public function disable_emojis_tinymce($plugins)
    {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        } else {
            return array();
        }
    }
}
