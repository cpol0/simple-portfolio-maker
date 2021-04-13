# Simple Portfolio Maker

## Overview

Simple Portfolio Maker (SPM) is (mostly) a Wordpress theme that allows you to easily build your portfolio. 

## Example
<a href="https://pol-carre.fr">Pol's portfolio</a>

 <a href="https://pol-carre.fr">
    <img alt="Pol Carré" src="doc/img/screenshot.png" height="600">
  </a>

## Features

- Predefined blocks which let you choose your text and images arrangement (left, right, on 2 columns, et....).
- Delivered with SEO plugins by default
- Contact form included
- Home page with your highklighted cases studies
- An index page for all your cases studies
- Simple and sober design with easily customizable CSS sheets
- Thanks to <a href="https://github.com/timber/timber">Timber</a>, it is very easy to adapt the html (twig files) to fit your needs.
- Useless CSS & JS from default wordpress installation removed to speed up the site
- Tanks to <a href="https://roots.io/bedrock/">Bedrock</a>, you also take advantage of nice features like:
  - Better folder structure
  - Easy WordPress configuration with environment specific files
  - Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)
  - Autoloader for mu-plugins (use regular plugins as mu-plugins)
  - Enhanced security (separated web root and secure passwords with [wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))

## Requirements

- PHP >= 7.4
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- If you just want to look over the theme and run a demo, [docker-compose](https://docs.docker.com/compose/install/) is also recommanded but not mandatory in production.

## Installation

1. Clone this project
2. Update environment variables in the `.env` file as explained [here](https://roots.io/docs/bedrock/master/installation/). You can copy paste `.env.example` to have an example.
3. Build docker images:
   ```sh
   $ make build
   ```
4. Install all dependencies
   ```sh
   $ make install
   ```
5. Run docker
   ```sh
   $ make dev
   ```
6. According to the `.env` file, create your Wordpress database. By default, you can create it with PhpMyAdmin on http://localhost:8001. Defaults credentials are `root`/`root`.
7. Finish the Wordpress installation and access to WordPress admin at http://localhost:8000
8. In another shell, configure defaults settings for the theme:
   ```sh
   $ make configure
   ```
9. If you want to crate fake cases studies:
   ```sh
   $ make fake
   ```
10. You should have a nice portfolio now on http://localhost:8000 ! 🎉

## Documentation

### Add your case studies

Under "Posts", you have now a "Case study" item:

![Case study entry](/doc/img/case-study-menu.png "Case study entry")

You can choose the block type you want with the select box, then let's put your images and write your text:

![Block type](/doc/img/block-type.png "Block type")

Additionnally, you may have some mandatory fields to fill to have a nice case study to display, let yourself be guided with the instructions diplayed under each field.

For a better rendering, you have to set a featured image on each case study. 
You can also choose to highlight you case study, in this case it will be displayed on the home page.

![Highlight box](/doc/img/highlight-box.png "Highlight box")


### Contact form settings

You have to set yourself some things to have a functionnal contact form.

1. ⚠️ If you have several contact forms, Simple Portfolio Maker will always use the first one! (shorted by `id`)
![CF7 short code](/doc/img/cf7-shortcode.png "CF7 short code")

2. Copy paste this code in the tab "form" of your contact form.
```twig
[text* your-name placeholder "Nom &amp; Prénom / Société"]
[email* your-email placeholder "Email"]
[textarea* your-message minlength:50 placeholder "Votre message"]
<div>
	<button class="btn" type="submit">
		Envoyer le message
	</button>
</div>
```

![CF7 form code](/doc/img/cf7-formcode.png "CF7 form code")

### Mail settings

You can configue your mail settings in the "WP mail SMTP" panel.

If you want to test locally emails (thanks to [Maildev](https://github.com/maildev/maildev)), please follow the guide:

1. Select "Other SMTP"
2. Settings:
  - set `maildev` for SMTP host
  - Encryption: `none`
  - SMTP Port: `25`
  - Auto TLS: `off`
  - Authentication: `off`
3. save settins
4. Go to "email test" tab on the top of the page and send email
5. You should have an email at http://localhost:1080 ! 🎉


## License
[CC BY-NC 4.0](https://creativecommons.org/licenses/by-nc/4.0/)


## Contributing

Contributions are welcome from everyone.

