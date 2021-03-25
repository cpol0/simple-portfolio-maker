<?php

use Timber\Timber;

$context = Timber::get_context();

$context['post'] = Timber::query_post(); //génère un objet query de type timber
$context['homepage']= is_front_page();


Timber::render('index.twig', $context);