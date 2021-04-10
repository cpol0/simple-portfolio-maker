<?php


namespace Portfolio\Twig;


/**
 * CF7
 * Remove CF7 assets if needed.
 * Credits: https://cfxdesign.com/load-the-contact-form-7-stylesheet-and-javascript-only-when-necessary/
 */
class CF7
{
    public static function removeAssets()
    {
        if (is_page_template('contact.php')) {
            return;
        }
        add_filter('wpcf7_load_js', '__return_false');
        add_filter('wpcf7_load_css', '__return_false');
    }
}