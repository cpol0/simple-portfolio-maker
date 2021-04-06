<?php

namespace App;

use WP_Query;

class ImageUpload
{    
    /**
     * getImagesFromLibrary
     * Return an array with id & url of all images in the gallery
     *
     * @return array
     */
    public static function getImagesFromLibrary(): array
    {
        $query_images_args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => -1,
        );

        $query_images = new WP_Query($query_images_args);

        $images = array();
        foreach ($query_images->posts as $image) {
            $images[] = [
                'id' => $image->ID,
                'url' => wp_get_attachment_url($image->ID),
            ];
        }

        return $images;
    }
    
    /**
     * bulkUploadFromSrcToLibrary
     * Bulk upload for images in a locl folder
     *
     * @param  mixed $imagesPaths
     * @return void
     */
    public static function bulkUploadFromSrcToLibrary(array $imagesPaths)
    {
        foreach($imagesPaths as $imagePath){
            self::uploadImageToLibrary($imagePath);
        }
    }
    
    /**
     * uploadImageToLibrary
     * Upload a single image into library
     *
     * @param  mixed $image_path
     * @param  mixed $post_id
     * @return void
     */
    public static function uploadImageToLibrary(string $image_path, ?int $post_id = 0)
    {
        /* Get the path to the upload directory */
        $upload_dir = wp_upload_dir();

        /* Get data */
        $image_data = file_get_contents($image_path);

        /* Wite file in uploads dir */
        $filename = basename($image_path);
        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }
        file_put_contents($file, $image_data);


        $wp_filetype = wp_check_filetype($filename, null);

        /* Record in DB */
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);
        return $attach_id;
    }
}
