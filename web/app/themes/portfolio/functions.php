<?php

use App\Site;
use Timber\Timber;

new Site();
$timber = new Timber();
Timber::$autoescape = true; //don't forget to add '| raw' to print html

