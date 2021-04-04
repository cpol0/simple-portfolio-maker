<?php

/**
 * Template Name: Home Page
 */

use Timber\Timber;

$context = Timber::get_context();

$context['post'] = Timber::query_post();
$context['darkfooter'] = is_page_template('home.php'); /* change the footer background color specifically for some pages */

/* Get only highlighted cases studies */
$args = array(
    'meta_query' => array(
        array(
            'key' => 'portfolio_highlight',
            'value' => '1',
        ),
    ),
    'post_type' => 'casestudy'
);
$query = new WP_Query($args);
$context['highlightedWorks'] = Timber::query_posts($query);

Timber::render('home.twig', $context);
