<?php

/**
 * Template Name: Home Page
 */

use Timber\Timber;

$context = Timber::get_context();

$context['post'] = Timber::query_post(); //génère un objet query de type timber
$context['darkfooter'] = is_page_template('home.php');

$args = array(
    'meta_query' => array(
        array(
            'key' => 'portfolio_highlight',
            'value' => '1',
        ),
    ),
    'post_type' => 'work'
);
$query = new WP_Query($args);
$context['highlightedWorks'] = Timber::query_posts($query);

Timber::render('home.twig', $context);
