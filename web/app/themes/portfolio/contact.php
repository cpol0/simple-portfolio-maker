<?php

/**
 * Template Name: Contact
 */

use Timber\Timber;

$context = Timber::get_context();
$context['post'] = Timber::query_post();
$context['darkfooter'] = is_page_template('contact.php'); /* change the footer background color specifically for some pages */
$context['local_dev'] = WP_ENV;

Timber::render('contact.twig', $context);
