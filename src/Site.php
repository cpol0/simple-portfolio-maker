<?php

namespace App;

use Timber\Site as TimberSite;

class Site extends TimberSite
{
    public function __construct($site_name_or_id = null)
    {
        add_action('wp_enqueue_scripts', [$this, 'registerAssets']);
        parent::__construct($site_name_or_id);
    }

    public function registerAssets()
    {
        wp_register_style('main', /* get_stylesheet_directory() . */ '/../app/themes/portfolio/assets/app.css', []);
        wp_register_script('main', /* get_stylesheet_directory(). */'/../app/themes/portfolio/assets/app.js', [], false, true);
        wp_enqueue_style('main');
        wp_enqueue_script('main');
    }
}
