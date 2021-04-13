<?php

/**
 * Template Name: Contact
 */

use Timber\Timber;

$context = Timber::get_context();
$context['post'] = Timber::query_post();
$context['darkfooter'] = is_page_template('contact.php'); /* change the footer background color specifically for some pages */
$context['local_dev'] = WP_ENV;

/* Get the first contact form */
$args = array(
    'post_type' => 'wpcf7_contact_form',
    'order' => 'ASC',
    'posts_per_page' => 1
);
$query = new WP_Query($args);
$context['form'] = Timber::query_post($query);


Timber::render('contact.twig', $context);
