<?php

use App\Site;
use Portfolio\Site as PortfolioSite;
use Timber\Timber;

$site = new PortfolioSite();

$timber = new Timber();
Timber::$autoescape = true; //don't forget to add '| raw' to print html

