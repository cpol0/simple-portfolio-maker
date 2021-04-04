<?php

/**
 * Template Name: Cases Studies index
 */

use Timber\Timber;

$context = Timber::get_context();

$context['archivePage'] = Timber::query_post();

/* Get all cases studies */
$context['archives'] = Timber::get_posts(array('post_type' => 'casestudy'));

//dd($context);
Timber::render('list-casesstudies.twig', $context);
