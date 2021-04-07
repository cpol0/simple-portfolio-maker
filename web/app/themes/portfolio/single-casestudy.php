<?php

use Timber\Timber;

$context = Timber::get_context();

$context['post'] = Timber::query_post();

/* TODO: each image displayed in a mosaic create a SQL query, this is not very optimized... 
    It could be nice to retrieve all datas in 1 query like 
    SELECT post_id, meta_key, meta_value FROM wp_postmeta WHERE post_id IN (x,y,z,...) ORDER BY meta_id ASC
    where x,y,z are the images post ID.
*/

//dd($context);
Timber::render('casestudy.twig', $context);