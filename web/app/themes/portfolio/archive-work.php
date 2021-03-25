<?php

/**
 * Template Name: Case Studies index
 */

use Timber\Timber;

$context = Timber::get_context();

$archivePage = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'archive-work.php'
))[0];

$pageId = $archivePage->ID;
$context['archivePage'] = $archivePage;
$context['subtitle'] = get_post_meta( $pageId,'subtitle')[0];

$context['archives'] = Timber::query_posts();

//dd($context);
Timber::render('list-work.twig', $context);
