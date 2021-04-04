<?php

use Timber\Timber;

$context = Timber::get_context();

$context['post'] = Timber::query_post();

($context);
Timber::render('casestudy.twig', $context);