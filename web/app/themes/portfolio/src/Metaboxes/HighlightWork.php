<?php

namespace Portfolio\Metaboxes;

use Timber\Timber;

class HighlightWork
{
    const META_KEY = 'portfolio_highlight';
    const NONCE = '_portfolio_highlight_nonce';

    public static function register()
    {
        add_action('add_meta_boxes', [self::class, 'add'], 10, 2);
        add_action('save_post', [self::class, 'save']);
    }

    public static function add($postType, $post)
    {
        if ($postType === 'work' && current_user_can('publish_posts', $post)) {
            add_meta_box(self::META_KEY, 'Highlighted', [self::class, 'render'], 'work', 'side');
        }
    }

    public static function render($post)
    {
        $value = get_post_meta($post->ID, self::META_KEY, true);
        wp_nonce_field(self::NONCE, self::NONCE);

        $context = Timber::get_context();       
        $context['META_KEY'] = self::META_KEY;
        $context['checked'] = ($value)?'checked':''; 

        Timber::render('metaboxes/highlight.twig', $context);
    }

    public static function save($post)
    {
        if (
            array_key_exists(self::META_KEY, $_POST) &&
            current_user_can('publish_posts', $post) &&
            wp_verify_nonce($_POST[self::NONCE], self::NONCE)
        ) {
            if ($_POST[self::META_KEY] === '0') {
                delete_post_meta($post, self::META_KEY);
            } else {
                update_post_meta($post, self::META_KEY, 1);
            }
        }
    }
}
