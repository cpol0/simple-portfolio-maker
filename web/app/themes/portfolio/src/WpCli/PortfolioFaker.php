<?php

namespace Portfolio\WpCli;

use Portfolio\ACFfields\CaseStudy;
use Portfolio\ACFfields\Contact;
use Portfolio\ACFfields\Home;
use Portfolio\ACFfields\ListCasesStudies;
use Portfolio\Migrations\DefaultsPages;
use Timber\Timber;
use WP_CLI;

if (defined('WP_CLI') && WP_CLI) {

    class PortfolioFaker
    {

        public function __construct()
        {

        }

        public function fake_defaults()
        {
            PageFaker::fake();
            WP_CLI::success("Defaults pages faked!");
        }

        public function fake_casestudy()
        {
            CasestudyFaker::fake();
            WP_CLI::success("Cases studies faked!");
        }

        public function fake_images()
        {
            ImageFaker::fake();
            WP_CLI::success("Images faked!");
        }

    }
   
}
