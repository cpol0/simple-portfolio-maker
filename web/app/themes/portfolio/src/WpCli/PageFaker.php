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

            // example constructor called when plugin loads
        }

        public function fake_defaults()
        {
            $pages = DefaultsPages::getPages();
            $this->fakeHomePage($pages['home']);
            $this->fakeCasesStudiesIndexPage($pages['casesstudies']);
            $this->fakeContactPage($pages['contact']);
            
            WP_CLI::success("Defaults pages faked!");
            
        }

        public function exposed_function_with_args($args, $assoc_args)
        {

            // process arguments 

            // do cool stuff

            // give output
            WP_CLI::success('hello from exposed_function_with_args() !');
        }

        private function fakeHomePage($page): void
        {
            $post_id = $page->ID;

            update_field(Home::WELCOME_TITLE, 'Caliméro!!!', $post_id);
            update_field(Home::WELCOME_SUBTITLE, 'Développeur web null stack', $post_id);
            update_field(Home::SKILLS_TITLE, 'Mes compétences', $post_id);
            update_field(Home::SKILLS_SUBTITLE, 'Développeur 0 stack', $post_id);
            $text = Timber::compile('fake/home/skills-text.twig');
            update_field(Home::SKILLS_TEXT, $text, $post_id);
            update_field(Home::WORKS_TITLE, 'Réalisations', $post_id);
            update_field(Home::WORKS_SUBTITLE, 'Quelques exemples', $post_id);
            update_field(Home::ABOUT_TITLE, 'Mon Parcours', $post_id);
            update_field(Home::ABOUT_SUBTITLE, 'Formation & Expérience', $post_id);
            $text = Timber::compile('fake/home/about-text.twig');
            update_field(Home::ABOUT_TEXT, $text, $post_id);
        }

        private function fakeCasesStudiesIndexPage($page): void
        {
            $post_id = $page->ID;

            update_field(ListCasesStudies::SUBTITLE, 'Mes projets depuis ma sortie de l\'oeuf', $post_id);
        }

        private function fakeContactPage($page): void
        {
            $post_id = $page->ID;

            update_field(Contact::SUBTITLE, 'Me faire coucou', $post_id);
        }

    }
   
}
