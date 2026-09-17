=== Custom Base Terms ===
Contributors: artprojectgroup
Donate link: https://artprojectgroup.es/tienda/donacion
Tags: permalinks, author, search, comments, pagination
Requires at least: 5.0
Tested up to: 7.2
Requires PHP: 7.4
Stable tag: 1.1.1
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Change the custom URL structures for author, search, comments, pagination and feed pages.

== Description ==
**Custom Base Terms** adds five new options to *Settings -> Permalinks* where you can set the custom URL structures for the author, search, comments, pagination and feed pages.

= Features =
* Simple and easy to configure.
* Lets you build friendly URLs.
* Helps improve your WordPress SEO.
* Multilingual. Supports every native WordPress language.

= Translations =
* English: by [Art Project Group](https://artprojectgroup.es/) (default language).
* Spanish: by [Art Project Group](https://artprojectgroup.es/).

= Technical support =
**Art Project Group** offers [**Technical support**](https://artprojectgroup.es/tienda/ticket-de-soporte) to configure or install **Custom Base Terms**.

= Origin =
**Custom Base Terms** has been programmed from the [*Custom Author Base*](https://wordpress.org/plugins/custom-author-base/) plugin by [Jeff Farthing](https://profiles.wordpress.org/jfarthing84/), which, even being a magnificent plugin, did not offer all the features we needed. His work has been absolutely essential to build this plugin.

= More information =
You can learn more about **Custom Base Terms** on our [official website](https://artprojectgroup.es/plugins-para-wordpress/custom-base-terms), and follow the development on [GitHub](https://github.com/artprojectgroup/custom-base-terms).

= More plugins =
You can find more [WordPress plugins](https://artprojectgroup.es/plugins-para-wordpress) at [Art Project Group](https://artprojectgroup.es) and on our [WordPress profile](https://profiles.wordpress.org/artprojectgroup/).

== Installation ==
1. Install the plugin in one of the following ways:
 * Upload the `custom-base-terms` folder to the `/wp-content/plugins/` directory via FTP.
 * Upload the full ZIP file via *Plugins -> Add New -> Upload* in the WordPress administration panel.
 * Search for **Custom Base Terms** in *Plugins -> Add New* and click *Install Now*.
2. Activate the plugin through the *Plugins* menu in the WordPress administration panel.
3. Configure the plugin with the *Settings* link on the plugins page or in *Settings -> Permalinks*.
4. That's it. If you like it and find it useful, please consider making a [*donation*](https://artprojectgroup.es/tienda/donacion).

== Frequently Asked Questions ==
= How do I configure the plugin? =
Click the *Settings* link, or go to *Settings -> Permalinks*, and enter the custom URL structures for the author, search, comments, pagination and feed pages.

= What happens if I leave a field empty? =
The base goes back to the one WordPress uses by default for that term.

= Do I need to flush the permalinks after changing a base? =
No. The plugin rebuilds the rewrite rules itself when you save the permalinks page.

= Technical support =
If you need help to configure or install **Custom Base Terms**, **Art Project Group** offers its [**Technical support**](https://artprojectgroup.es/tienda/ticket-de-soporte) service.

*In no case does **Art Project Group** provide any kind of free technical support.*

== Screenshots ==
1. Screenshot of **Custom Base Terms**.

== Changelog ==
= 1.1.1 =
* Added the license to the plugin header, and the plugin prefix to its global constants and variables.
* Removed the manual translation loading, discouraged since WordPress 4.6. Translations keep coming from the WordPress.org language packs.
* The plugin page on WordPress.org is now written in English.
= 1.1.0 =
* Security fix: any logged-in user, or an external site through CSRF, could change the permalink bases of the site.
* Security fix: every output is escaped and the remote WordPress.org response is no longer passed through unserialize().
* The rating stars no longer disappear nor raise a PHP notice when the WordPress.org API does not answer.
* The field labels and the support link are now translated.
* The stylesheet is only loaded on the screens where the plugin displays something.
* Compatible with WordPress 7.2.
= 1.0.3 =
* Security update to remove a detected Cross-Site Scripting (XSS) vulnerability.
= 1.0.2.3 =
* Header update.
* Stylesheet update.
* Screenshot update.
= 1.0.2.2 =
* Minor code changes.
= 1.0.2.1 =
* Minor code changes.
= 1.0.2 =
* Localization fix.
* Header update.
* Stylesheet update.
* Screenshot update.
= 1.0.1.1 =
* Support links update and minor changes.
= 1.0.1 =
* Font package update. New Google+ icon.
* Translations update.
= 1.0 =
* Translations update.
* New responsive stylesheet.
* Internal structure reworked to follow the WordPress standards.
* Screenshot update.
= 0.7.3 =
* Fixed a bug that deleted the whole configuration when the plugin was deactivated.
* Minor fix that prevents an error code when collecting the plugin information.
= 0.7.2 =
* Donation link change.
= 0.7.1 =
* Minor fix that prevents an error code when collecting the plugin information.
= 0.7 =
* Added a cache for the external data.
* Added a function that clears the cache when the plugin is deleted.
* Donation button and link change.
= 0.6 =
* Stylesheets updated for the new WordPress 8.
= 0.5 =
* New buttons added.
* Added the Feed base field.
= 0.4 =
* Settings button added.
* Languages update.
= 0.3 =
* Minor code changes.
* Links added.
* Information texts update.
* Multilingual option.
= 0.2 =
* Fixed minor errors in the source code.
= 0.1 =
* Initial version.

== Upgrade Notice ==
= 1.1.1 =
* Maintenance release for the WordPress.org plugin review requirements. Coming from 1.0.3 or earlier, it also carries the security fixes of 1.1.0.
= 1.1.0 =
* Security update that prevents any logged-in user from changing the permalink bases of the site. Recommended for every site.

== Translations ==
* *English*: by [**Art Project Group**](https://artprojectgroup.es/) (default language).
* *Español*: por [**Art Project Group**](https://artprojectgroup.es/).

== Support ==
Since **Custom Base Terms** is completely free, **Art Project Group** only provides the service of [**Technical support**](https://artprojectgroup.es/tienda/ticket-de-soporte) upon payment. In no case does **Art Project Group** provide any kind of free technical support.

== Donation ==
Did you like **Custom Base Terms** and find it useful on your website? We would appreciate a [small donation](https://artprojectgroup.es/tienda/donacion) that will help us keep improving this plugin and creating more completely free plugins for the whole WordPress community.

== Thanks ==
* To [Jeff Farthing](https://profiles.wordpress.org/jfarthing84/) for his great plugin, which inspired **Custom Base Terms**.
* To all of you who use it.
* To all of you who help to improve it.
* To all of you who make donations.
* To all of you who encourage us with your comments.

Thank you all so much!
