<?php

namespace Portfolio\WpCli;

use Portfolio\ACFfields\Contact;
use Portfolio\ACFfields\Home;
use Portfolio\ACFfields\ListCasesStudies;
use Portfolio\Migrations\DefaultsPages;
use Timber\Timber;
use WP_CLI;

if (defined('WP_CLI') && WP_CLI) {

    class PageFaker
    {

        public function __construct()
        {

        }

        public static function fake()
        {
            $pages = DefaultsPages::getPages();
            self::fakeHomePage($pages['home']);
            self::fakeCasesStudiesIndexPage($pages['casesstudies']);
            self::fakeContactPage($pages['contact']);
        }

        private static function fakeHomePage($page): void
        {
            $post_id = $page->ID;

            update_field(Home::WELCOME_TITLE, 'Your name', $post_id);
            update_field(Home::WELCOME_SUBTITLE, 'Développeur web null stack', $post_id);
            update_field(Home::SKILLS_TITLE, 'My Skills', $post_id);
            update_field(Home::SKILLS_SUBTITLE, '0 stack developer', $post_id);
            update_field(Home::SKILLS_TAGS, '<ul>
                                <li><a href="http://php.net"><i class="fab fa-php"></i></a></li>
                                <li><a href="http://wordpress.com"><i class="fab fa-wordpress"></i></a></li>
                        </ul>', $post_id);
            $text = Timber::compile('fake/home/skills-text.twig');
            update_field(Home::SKILLS_TEXT, $text, $post_id);
            update_field(Home::WORKS_TITLE, 'Cases studies', $post_id);
            update_field(Home::WORKS_SUBTITLE, 'Some examples', $post_id);
            update_field(Home::ABOUT_TITLE, 'About me', $post_id);
            update_field(Home::ABOUT_SUBTITLE, 'Experience', $post_id);
            $text = Timber::compile('fake/home/about-text.twig');
            update_field(Home::ABOUT_TEXT, $text, $post_id);
        }

        private static function fakeCasesStudiesIndexPage($page): void
        {
            $post_id = $page->ID;

            update_field(ListCasesStudies::SUBTITLE, 'Cases studies', $post_id);
        }

        private static function fakeContactPage($page): void
        {
            $post_id = $page->ID;

            update_field(Contact::SUBTITLE, 'Contact me', $post_id);
        }

    }
   
}
