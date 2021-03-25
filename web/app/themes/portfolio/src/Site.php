<?php

namespace Portfolio;

use Portfolio\ACFfields\Home;
use Portfolio\ACFfields\ListWork;
use Portfolio\ACFfields\Work;
use Portfolio\Metaboxes\HighlightWork;
use Portfolio\Twig\Filters;
use Timber\Timber;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Site extends \App\Site
{
    public function __construct($site_name_or_id = null)
    {
        parent::__construct($site_name_or_id);
        add_action('init', [$this, 'registerMenus']);
        add_action('init', [$this, 'registerPostTypes']);
        add_action('init', [$this, 'registerImages']);
        add_filter('timber/twig', [$this, 'extendTwig']);
        add_action('admin_init', [$this, 'customizeEditorSettings']);
        add_action('admin_init', [$this, 'buildAcfFields']);
        add_action('admin_init', [$this, 'manageWorkAdminColumns']);
        HighlightWork::register();
    }

    public function registerMenus(): void
    {
        register_nav_menus([
            'header' => 'Menu principal',
            'logo' => 'logo',
            'footer' => 'Réseaux Sociaux'
        ]);
    }

    public function customizeEditorSettings(): void{
        add_filter('use_block_editor_for_post', '__return_false', 10); /* Disable gutemberg */
        remove_post_type_support('page', 'editor'); /* Disable glofab editor field for pages */
        remove_post_type_support('work', 'editor'); /* Disable glofab editor field for custom type 'work' */
    }

    //TODO: bouger ça dans un doccier fields, puis faire un home.php, work.php, etc....
    public function buildAcfFields(): void
    {
        
        if (!function_exists('register_extended_field_group')) {
            return;
        }

        Home::builHomePageFields();
        Work::buildWorkPageFields();
        ListWork::buildWorkListPageFields();
    }

    

    public function registerImages(): void
    {
        add_image_size('block', 550, 400, true);
        add_image_size('mosaic-large', 500, 600, true);
        add_image_size('mosaic-small', 500, 288, true);
    }
    

    public function registerPostTypes(): void
    {
        register_post_type('work', [
            'label' => __('Work', 'portfolio'),
            'menu_icon' => 'dashicons-hammer',
            'labels' => [
                'name'                     => __('Work', 'portfolio'),
                'singular_name'            => __('Work', 'portfolio'),
                'edit_item'                => __('Edit work', 'portfolio'),
                'new_item'                 => __('New work', 'portfolio'),
                'view_item'                => __('View work', 'portfolio'),
                'view_items'               => __('View works', 'portfolio'),
                'search_items'             => __('Search works', 'portfolio'),
                'not_found'                => __('No works found.', 'portfolio'),
                'not_found_in_trash'       => __('No works found in Trash', 'portfolio'),
                'all_items'                => __('All works', 'portfolio'),
                'archives'                 => __('Work archive', 'portfolio'),
                'attributes'               => __('Work attributes', 'portfolio'),
                'insert_into_item'         => __('Insert into work', 'portfolio'),
                'uploaded_to_this_item'    => __('Uploaded to this work', 'portfolio'),
                'filter_items_list'        => __('Filter works list', 'portfolio'),
                'items_list_navigation'    => __('Works list navigation', 'portfolio'),
                'items_list'               => __('Works list', 'portfolio'),
                'item_published'           => __('Work published.', 'portfolio'),
                'item_published_privately' => __('Work published privately.', 'portfolio'),
                'item_reverted_to_draft'   => __('Work reverted to draft.', 'portfolio'),
                'item_scheduled'           => __('Work scheduled.', 'portfolio'),
                'item_updated'             => __('Work updated.', 'portfolio'),
            ],
            'public' => true,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'has_archive' => 'realisations',
            'register_meta_box_cb' => HighlightWork::register(),
            'supports' => ['title', 'editor', 'excerpt', 'thumbnail']
        ]);

    }

    public function manageWorkAdminColumns()
    {
        add_filter('manage_work_posts_columns', function ($columns) {
            $newColumns = [];
            foreach ($columns as $k => $v) {
                if ($k === 'date') {
                    $newColumns['highlight-work'] = __('Highlight', 'portfolio');
                }
                $newColumns[$k] = $v;
            }
            return $newColumns;
        });

        add_filter('manage_work_posts_custom_column', function ($column, $postId) {
            if ($column === 'highlight-work') {
                $context = Timber::get_context();
                $context['isHighlighted'] = get_post_meta($postId, HighlightWork::META_KEY, true);
            
                Timber::render('metaboxes/highlight-admin-column.twig', $context);
            }

        }, 10, 2);
    }

     public function extendTwig($twig): Environment
    {
        $twig->addFilter(new TwigFilter('col', ['Portfolio\Twig\Block', 'colClass']));
        $twig->addFilter(new TwigFilter('reveal', ['Portfolio\Twig\Block', 'revealClass']));
        $twig->addFilter(new TwigFilter('setTitle', ['Portfolio\Twig\Block', 'ish2']));
        $twig->addFilter(new TwigFilter('trimextrabr', ['Portfolio\Twig\Block', 'trimExtraBR']));
        $twig->addFilter(new TwigFilter('technotags', ['Portfolio\Twig\Block', 'technoTags']));
        $twig->addFunction(new TwigFunction('cutOffBody', ['Portfolio\Twig\Block', 'cutOffBody']));
        $twig->addFunction(new TwigFunction('writeBlock', ['Portfolio\Twig\Block', 'writeBlock']));
        return $twig;
        
    }

    /* public function registerTaxonomies(): void
    {
         voir 44:15 part2
    } */

    //2:22:28 part2
}