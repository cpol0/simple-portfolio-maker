<?php

use Timber\Timber;

$context = Timber::get_context();

$context['post'] = Timber::query_post(); //génère un objet query de type timber

//dd($context);
Timber::render('work.twig', $context);