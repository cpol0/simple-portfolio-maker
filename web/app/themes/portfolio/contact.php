<?php

/**
 * Template Name: Contact
 */

use Timber\Timber;

$context = Timber::get_context();
$context['post'] = Timber::query_post();
$context['darkfooter'] = is_page_template('contact.php');


Timber::render('contact.twig', $context);
