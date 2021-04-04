<?php

/**
 * Template Name: Contact
 */

use Timber\Timber;

$context = Timber::get_context();
$context['post'] = Timber::query_post();
$context['darkfooter'] = is_page_template('contact.php'); /* change the footer background color specifically for some pages */

/* Temporary disabled */
/* if (function_exists('wpcf7_enqueue_scripts')) {
    wpcf7_enqueue_scripts();
}

if (function_exists('wpcf7_enqueue_styles')) {
    wpcf7_enqueue_styles();
} */

Timber::render('contact.twig', $context);
