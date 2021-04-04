<?php

use Timber\Timber;

$context = Timber::get_context();

$context['post'] = Timber::query_post();

//dd($context);
Timber::render('casestudy.twig', $context);