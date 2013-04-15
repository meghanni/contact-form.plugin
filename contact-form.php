<?php

/*
Plugin Name: Clean and Simple Contact Form
Plugin URI: http://megnicholas.co.uk/plugins/clean-and-simple-contact-form
Description: A simple and clean contact form with Google reCaptcha. <strong>Clean</strong>: all user inputs are stripped in order to avoid cross-site scripting (XSS) vulnerabilities. <strong>Simple</strong>: Ajax enabled validation for immediate response and guidance for your users (can be switched off). <strong>Stylish</strong>: Use the included stylesheet or switch it off and use your own for seamless integration with your website. Uses <strong>Bootstrap</strong> classes. 
Version: 4.04
Author: Meghan Nicholas
Author URI: http://megnicholas.co.uk
License: GPLv2 or later
bootstrap,
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

include('shortcodes/contact-form.php');
include('class.cff.php');
include('class.cff_pluginsettings.php');
include('class.cff_settings.php');
include('class.cff_contact.php');

if ( cff_PluginSettings::UseRecaptcha() )
    include('recaptcha-php-1.11/recaptchalib.php');

if (!defined('CFF_THEME_DIR'))
    define('CFF_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('CFF_PLUGIN_NAME'))
    define('CFF_PLUGIN_NAME', 'contact-form');

if (!defined('CFF_PLUGIN_DIR'))
    define('CFF_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . CFF_PLUGIN_NAME);

if (!defined('CFF_PLUGIN_URL'))
    define('CFF_PLUGIN_URL', WP_PLUGIN_URL . '/' . CFF_PLUGIN_NAME);

if (!defined('CFF_VERSION_KEY'))
    define('CFF_VERSION_KEY', 'cff_version');

if (!defined('CFF_VERSION_NUM'))
    define('CFF_VERSION_NUM', '4.04');

if (!defined('CFF_OPTIONS_KEY'))
    define('CFF_OPTIONS_KEY', 'cff_options');

add_option(CFF_VERSION_KEY, CFF_VERSION_NUM);

$cff = new cff();
