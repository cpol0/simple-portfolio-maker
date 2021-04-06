<?php

namespace Portfolio\WpCli;

use App\ImageUpload;
use WP_CLI;

if (defined('WP_CLI') && WP_CLI) {

    class ImageFaker
    {
        public static function fake(): void
        {
            self::uploadFakeImages();
            
        }

        private static function uploadFakeImages(): void
        {
            $path = get_stylesheet_directory() . '/assets/fake/800/';
            $filenames = [
                '1043-800x800.jpg',
                '1057-800x800.jpg',
                '1078-800x800.jpg',
                '210-800x800.jpg',
                '23-800x800.jpg',
                '238-800x800.jpg',
                '287-800x800.jpg',
                '290-800x800.jpg',
                '320-800x800.jpg',
                '440-800x800.jpg',
                '441-800x800.jpg',
                '501-800x800.jpg',
                '53-800x800.jpg',
                '581-800x800.jpg',
                '609-800x800.jpg',
                '637-800x800.jpg',
                '659-800x800.jpg',
                '825-800x800.jpg',
                '894-800x800.jpg',
                '912-800x800.jpg',
                '938-800x800.jpg',
                '947-800x800.jpg',
                '952-800x800.jpg',
                '977-800x800.jpg',
                '984-800x800.jpg',
            ];

            foreach ($filenames as $file) {
                $images[] = $path . $file;
            }

            ImageUpload::bulkUploadFromSrcToLibrary($images);
        }
    }

}