<?php

namespace Portfolio\WpCli;

use App\ImageUpload;
use Exception;
use Portfolio\ACFfields\CaseStudy;
use Portfolio\ACFfields\CustomFields\Block;
use Portfolio\ACFfields\CustomFields\Mosaic;
use Portfolio\Metaboxes\HighlightCaseStudy;
use Portfolio\Migrations\DefaultsPages;
use Timber\Timber;
use WP_CLI;
use WP_Post;



/**
 * CasestudyFaker
 * Generate fake cases studies
 */
class CasestudyFaker
{
    const MAX = 7; /* Number of cases studies to create */

    public function __construct()
    {
    }
    
    /**
     * fake
     *
     * @return void
     */
    public static function fake(): void
    {
        /* First, upload some images to gallery */
        ImageFaker::fake();

        /* Get the index page */
        $indexPage = DefaultsPages::getPage(DefaultsPages::CASESSTUDIESINDEX_TEMPLATE);

        /* Now generate the cases studies */
        for ($i = 0; $i < self::MAX; $i++) {

            $title = "Case study n°$i";
            $post_id = self::makeCaseStudy([
                'post_title'     => $title,
                'post_name'      => sanitize_text_field($title),
                'post_content'   => 'This is a case study. Feel free to edit this page.',
            ]);
            /* Fake it with some values */
            self::fakeCaseStudy($post_id, $i, $indexPage);
        }
    }

    /**
     * makeCaseStudy
     * Generate an empty case study
     *
     * @param  mixed $customParams
     * @return int
     */
    public static function makeCaseStudy(array $customParams): int
    {
        $params = [
            'post_status'    => 'publish',
            'post_author'    => '1',
            'post_type'      => 'casestudy',
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
        ];

        foreach ($customParams as $key => $value) {
            $params[$key] = $value;
        }

        try {
            return $post_id = wp_insert_post($params);
        } catch (Exception $e) {
            echo 'can\'t create fake case study: ',  $e->getMessage(), "\n";
        }
    }
    
    /**
     * fakeCaseStudy
     *
     * @param  mixed $post_id
     * @param  mixed $index
     * @param  mixed $indexPage
     * @return void
     */
    private static function fakeCaseStudy(int $post_id, int $index, WP_Post $indexPage): void
    {
        /* Fake block 0 */
        update_field(CaseStudy::SUBTITLE, 'Here the subtitle', $post_id);
        update_field(Block::TYPE . '0', 'fulltext', $post_id);
        $text = Timber::compile('fake/casesstudies/fulltext.twig');
        update_field(Block::BLOCK . '0', $text, $post_id);

        /* Set various cases studies lenghts */
        switch ($index) {
            default:
            /* Other cases studies are long case study with all blocks dispositions and a mosaic */
            case 3:
                /* Set the blocks 0,1,2,3 for 4th case study */
                update_field(Block::TYPE . '3', 'blocktextleft', $post_id);
                update_field(Block::TITLE . '3', 'Left text', $post_id);
                $attachId = self::getRandomImagesId()[0];
                $text = Timber::compile('fake/casesstudies/blocktextright.twig', ['imageSrc' => wp_get_attachment_image_src($attachId, 'block')[0]]);
                update_field(Block::BLOCK . '3', $text, $post_id);
            case 2:
                /* Set the blocks 0,1,2 for 3rd case study */
                update_field(Block::TYPE . '2','2textcolumns',$post_id);
                update_field(Block::TITLE . '2', '2 text columns', $post_id);
                $attachId = self::getRandomImagesId()[0];
                $text = Timber::compile('fake/casesstudies/2textcolumns.twig', ['imageSrc' => wp_get_attachment_image_src($attachId, 'block')[0]]);
                update_field(Block::BLOCK . '2', $text, $post_id);
                update_field(Block::BLOCK . '2-secondtextcolumn', $text, $post_id);
            case 1:
                /* Set the blocks 0,1 for 2nd case study */
                update_field(Block::TYPE . '1', 'blocktextright', $post_id);
                update_field(Block::TITLE . '1', 'Right text', $post_id);
                $attachId = self::getRandomImagesId()[0];
                $text = Timber::compile('fake/casesstudies/blocktextright.twig', ['imageSrc' => wp_get_attachment_image_src($attachId, 'block')[0]]);
                update_field(Block::BLOCK . '1', $text, $post_id);
                break;
        }

        /* Fake the mosaic */
        /* pickup 3 random images in the gallery and attach them to the post */
        $imagesId = self::getRandomImagesId(3);
        for ($i = 0; $i < 3; $i++) {
            $attachId = $imagesId[$i];
            if ($i === 0) {
                update_field(Mosaic::MOSAIC_IMAGE_LARGE, $attachId, $post_id);
            } elseif ($i === 1) {
                update_field(Mosaic::MOSAIC_IMAGE_SMALL1, $attachId, $post_id);
            } elseif ($i === 2) {
                update_field(Mosaic::MOSAIC_IMAGE_SMALL2, $attachId, $post_id);
            }
        }

        /* Case study main image */
        $attachId = self::getRandomImagesId()[0];
        set_post_thumbnail($post_id, $attachId);

        /* Fake technos */
        update_field(CaseStudy::TAGS_TITLE, 'Libs used', $post_id);
        $text = Timber::compile('fake/casesstudies/techno.twig');
        update_field(CaseStudy::TAGS, $text, $post_id);

        update_field(CaseStudy::TECHNO, '<i class="fab fa-wordpress"></i>Techno', $post_id);

        /* Set true index page */
        $link = array(
            'title' => $indexPage->post_title,
            'url' => $indexPage->guid,
            'target' => "_blank",
        );
        update_field(CaseStudy::WORK_INDEX, $link, $post_id);

        /* Highlight 3 first cases studies */
        if($index < 3){
            update_post_meta($post_id, HighlightCaseStudy::META_KEY, 1);
        }
    }
    
    /**
     * getRandomImagesId
     * Get random images Ids from gallery
     *
     * @param  mixed $nb
     * @return array
     */
    private static function getRandomImagesId(?int $nb = 1): array
    {
        $images = ImageUpload::getImagesFromLibrary();

        for ($i = 0; $i < $nb; $i++) {
            $randImagesId[] = $images[rand(0, count($images) - 1)]['id'];
        }

        return $randImagesId;
    }
}
