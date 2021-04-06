<?php

namespace Portfolio\WpCli;

use App\ImageUpload;
use WP_CLI;
use WP_Query;

class Debug {
    public function __invoke( $args ) 
    {
        /* customdebug CLI command, whrite here what you want :-) */
        WP_CLI::success( $args[0] );
    }

    
}