<?php

namespace Portfolio;

use Portfolio\ACFfields\CaseStudy;
use Portfolio\ACFfields\Contact;
use Portfolio\ACFfields\Home;
use Portfolio\ACFfields\ListCasesStudies;
use Portfolio\Metaboxes\HighlightCaseStudy;
use Portfolio\Migrations\DefaultsMenus;
use Portfolio\Migrations\DefaultsPages;
use Portfolio\WpCli\PageFaker;
use Timber\Timber;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WP_CLI;

class Site extends \App\Site
{    
    /**
     * __construct
     *
     * @param  mixed $site_name_or_id
     * @return void
     */
    public function __construct($site_name_or_id = null)
    {
        parent::__construct($site_name_or_id);
        add_action('setup_theme', new DefaultsPages()); /* Create default pages if needed */
        add_action('setup_theme', new DefaultsMenus()); /* Create default menus if needed */
        add_action('init', [$this, 'registerMenus']);
        add_action('init', [$this, 'registerPostTypes']);
        add_action('init', [$this, 'registerImages']);
        add_filter('timber/twig', [$this, 'extendTwig']);
        add_action('admin_init', [$this, 'customizeEditorSettings']);
        add_action('admin_init', [$this, 'buildAcfFields']);
        add_action('admin_init', [$this, 'manageCasesStudiesAdminColumns']);
        add_action('after_setup_theme', function () {
            load_theme_textdomain('portfolio', get_template_directory() . '/languages');
        });
        add_filter('wpcf7_autop_or_not', '__return_false'); /* Remove extra <p> which lead to broken CSS grid */
        /* add_filter('wpcf7_load_js', '__return_false'); Temporary disabled, see also contact.php
        add_filter('wpcf7_load_css', '__return_false'); */
        HighlightCaseStudy::register();

        // CLI scripts
        if (defined('WP_CLI') && WP_CLI) {
            WP_CLI::add_command('portfolio', PageFaker::class);
        }
        
    }
    
    /**
     * registerMenus
     *
     * @return void
     */
    public function registerMenus(): void
    {
        register_nav_menus([
            'header' =>  __('Main menu', 'portfolio'), 
            'logo' => __('Logo', 'portfolio'),
            'footer' =>  __('Social Medias', 'portfolio')
        ]);
    }
    
    /**
     * customizeEditorSettings
     *
     * @return void
     */
    public function customizeEditorSettings(): void{
        add_filter('use_block_editor_for_post', '__return_false', 10); /* Disable gutemberg */
        /* Disable global editor field for custom type 'casestudy' */
        remove_post_type_support('casestudy', 'editor'); 
        /* Disable global editor field for some templates */
        $this->disableContentEditorForTemplates(['home.php', 'contact.php', 'archive-casestudy.php']);
        
    }
    
    /**
     * buildAcfFields
     * Build ACF fields through wordplate/extendedACF lib
     *
     * @return void
     */
    public function buildAcfFields(): void
    {
        /* Is ACF installed? */
        if (!function_exists('register_extended_field_group')) {
            return;
        }

        /* Build custom fields for all these pages */
        Home::builPageFields();
        CaseStudy::buildPageFields();
        ListCasesStudies::buildPageFields();
        Contact::buildPageFields();
    }

    
    /**
     * registerImages
     * Register custom image sizes
     *
     * @return void
     */
    public function registerImages(): void
    {
        add_image_size('block', 550, 400, true);
        add_image_size('mosaic-large', 500, 600, true);
        add_image_size('mosaic-small', 500, 288, true);
    }
    
    /**
     * registerPostTypes
     * Register a case study type
     *
     * @return void
     */
    public function registerPostTypes(): void
    {
        register_post_type('casestudy', [
            'label' => __('Case studies', 'portfolio'),
            'menu_icon' => 'dashicons-hammer',
            'labels' => [
                'name'                     => __('Case study', 'portfolio'),
                'singular_name'            => __('Case study', 'portfolio'),
                'edit_item'                => __('Edit case study', 'portfolio'),
                'new_item'                 => __('New case study', 'portfolio'),
                'view_item'                => __('View case study', 'portfolio'),
                'view_items'               => __('View cases studies', 'portfolio'),
                'search_items'             => __('Search case studies', 'portfolio'),
                'not_found'                => __('No case studies found.', 'portfolio'),
                'not_found_in_trash'       => __('No case studies found in Trash', 'portfolio'),
                'all_items'                => __('All cases studies', 'portfolio'),
                'archives'                 => __('Case study archive', 'portfolio'),
                'attributes'               => __('Case study attributes', 'portfolio'),
                'insert_into_item'         => __('Insert into case study', 'portfolio'),
                'uploaded_to_this_item'    => __('Uploaded to this case study', 'portfolio'),
                'filter_items_list'        => __('Filter cases studies list', 'portfolio'),
                'items_list_navigation'    => __('Cases studies list navigation', 'portfolio'),
                'items_list'               => __('Cases studies list', 'portfolio'),
                'item_published'           => __('Case study published.', 'portfolio'),
                'item_published_privately' => __('Case study published privately.', 'portfolio'),
                'item_reverted_to_draft'   => __('Case study reverted to draft.', 'portfolio'),
                'item_scheduled'           => __('Case study scheduled.', 'portfolio'),
                'item_updated'             => __('Case study updated.', 'portfolio'),
            ],
            'public' => true,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'has_archive' => true,
            'rewrite'     => array(
                'slug' => __('case-study', 'portfolio'),
            ),
            'register_meta_box_cb' => HighlightCaseStudy::register(),
            'supports' => ['title', 'editor', 'excerpt', 'thumbnail']
        ]);

    }
    
    /**
     * manageCasesStudiesAdminColumns
     * add a column for highlighted case studies in the admin section
     *
     * @return void
     */
    public function manageCasesStudiesAdminColumns()
    {
        add_filter('manage_casestudy_posts_columns', function ($columns) {
            $newColumns = [];
            foreach ($columns as $k => $v) {
                if ($k === 'date') {
                    $newColumns['highlight-work'] = __('Highlighted', 'portfolio');
                }
                $newColumns[$k] = $v;
            }
            return $newColumns;
        });

        add_filter('manage_casestudy_posts_custom_column', function ($column, $postId) {
            if ($column === 'highlight-work') {
                $context = Timber::get_context();
                $context['isHighlighted'] = get_post_meta($postId, HighlightCaseStudy::META_KEY, true);
            
                Timber::render('metaboxes/highlight-admin-column.twig', $context);
            }

        }, 10, 2);
    }

    /**
     * extendTwig
     *
     * @param  mixed $twig
     * @return Environment
     */
    public function extendTwig($twig): Environment
    {
        $twig->addFilter(new TwigFilter('col', ['Portfolio\Twig\Block', 'colClass']));
        $twig->addFilter(new TwigFilter('reveal', ['Portfolio\Twig\Block', 'revealClass']));
        $twig->addFilter(new TwigFilter('setTitle', ['Portfolio\Twig\Block', 'ish2']));
        $twig->addFilter(new TwigFilter('trimextrabr', ['Portfolio\Twig\Block', 'trimExtraBR']));
        $twig->addFilter(new TwigFilter('technotags', ['Portfolio\Twig\Block', 'technoTags']));
        $twig->addFunction(new TwigFunction('cutOffBody', ['Portfolio\Twig\Block', 'cutOffBody']));
        return $twig;
    }

    /**
     * disableContentEditorForTemplates
     * Disable content editor for page template
     *
     * @param  mixed $templates
     * @return void
     */
    private function disableContentEditorForTemplates(array $templates): void
    {

        if (isset($_GET['post'])) {
            $post_id = $_GET['post'];
        }

        if (!isset($post_id)) return;

        $template_file = get_post_meta($post_id, '_wp_page_template', true);

        if (in_array($template_file, $templates)) {
            remove_post_type_support('page', 'editor');
        }
    }
    
}