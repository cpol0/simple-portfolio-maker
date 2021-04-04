<?php

/**
 * Template Name: Cases Studies index
 */

use Timber\Timber;

$context = Timber::get_context();

/* Get the page */
$archivePage = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'archive-casestudy.php'
))[0];

$pageId = $archivePage->ID;
$context['archivePage'] = $archivePage;
$context['subtitle'] = get_post_meta( $pageId,'subtitle')[0];

/* Get all cases studies */
$context['archives'] = Timber::query_posts();

//dd($context);
Timber::render('list-casesstudies.twig', $context);
