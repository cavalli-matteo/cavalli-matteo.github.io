=== All 404 Redirect to Homepage ===
Contributors: wp-buy, osamaesh
Tags: 404 error, redirection, seo redirect, broken images, redirection
Requires at least: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tested up to: 6.6.1
Stable tag: 4.6

Using this plugin, you can fix all 404 error links by redirecting them to homepage using the SEO 301 redirection. Improve your SEO rank & pages speed

== Description ==

By this plugin you can fix all random 404 links appear in you your website and redirect them to homepage or any other page using 301 SEO redirect. 404 error pages hurts the rank of your site in search engines. This smart plugin is a simple solution to handle 404 error pages.

Elevate your website's SEO performance and user experience with our Smart 404 Error Fix & Redirect plugin. This powerful tool automatically identifies and manages random 404 errors on your WordPress site, ensuring that broken links and missing pages are seamlessly redirected. By handling these 404 errors with precision, the plugin directs visitors to your homepage or any other specified page, helping to retain your audience and improve site navigation.

=== Features ===
* **Automatic 404 Redirection:** Effortlessly manage broken links and redirect users to relevant pages.
* **301 SEO Redirects:** Implement permanent 301 redirects to enhance your website's SEO ranking and preserve link equity.
* **Customizable Redirection:** Choose where 404 errors should be redirected – to your homepage, a custom page, or any URL of your choice.
* **Soft 404 Handling:** Address and manage soft 404 errors effectively.
* **Broken Link Management:** Detect and fix broken images and links to maintain a smooth user experience.
* **HTTPS Support:** Ensure compatibility with HTTPS for secure redirection.

=== Benefits ===
* **Improved SEO:** Reduce the negative impact of 404 errors on your search engine rankings with effective 301 redirects.
* **Enhanced User Experience:** Keep visitors engaged by preventing them from encountering error pages.
* **Easy Setup:** Simple installation and configuration with user-friendly options.


**How to use the plugin?**

- After installing the plugin go to the plugin control panel from settings menu.
- Put the link where the plugin should redirect all 404 links in the text box.
- Select the plugin status to be enabled.
- Click the button <b>Update Options</b> to save the from.
- Go to <b>404 URLs</b> tab to see the latest 404 links discovered and redirected

**Note**
Please make sure than the page you put above in the control panel to redirect all 404 to it is a valid link. If this page is not valid it will be considred as an 404 link and will result in redirect loop. In case of redirect loop you can simply disable the plugin and check the page is valid or not. 

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Screenshots ==
1. Plugin Options.
2. Latest 404 links Redirected.



== Changelog ==
= 4.6 =
* Checking with the last version of wordpress 6.6.1
* readme.txt some fixes

= 4.5 =
* Bug fixing in "exclude media" option


= 4.4 =
* Introducing a new feature on the plugin options page to prevent the logging of media links.

= 4.3 =
* bg fixing in reading htaccess file



= 4.2 =
* bg fixing in htaccess file read


= 4.1 =
* Checking with the last version of wordpress 6.1.1
* Changing the wording in writing some clarifications to correct the misunderstanding of some users

= 3.8 =
* Checking with the last version of wordpress 6.1

= 3.7 =
* fix show more link on network sites

= 3.6 =
* show alert message if you have many broken links
* compatibility check with wordpress 6.0


= 3.5 =
* Bug fixing - PHP 8.1 issue


= 3.4 =
* Tested with the latest WordPress Version


= 3.3 =
* Addin hint to download our  "Broken Images Redirection" Plugin


= 3.2 =
* Bug fixes in function prefix 



= 3.1 =
* New feature - Replace all broken images with a custom image 


= 2.3 =
* Bug Fixes - Escaping URLs


= 2.2 =
* Bug Fixes - sanitizing part 2


= 2.1 =
* Bug fixes - sanitizing

= 1.21 =
* Bug fixes

= 1.19 =
* New GUI

= 1.18 =
* Bug fixes in the log report

= 1.17 =
* Bug fixes

= 1.16 =
* fix upgrade message issue in the plugins page

= 1.15 =
* PHP 7.2 compatibility 

= 1.14 =
* add the ability to hide message

= 1.13 =
* PHP 7.x compatibility - Fix deprecated class issue

= 1.12 =
* bug in calculating the broken links count (this was affecting the error message)

= 1.11 =
* PHP 7.x compatibility

= 1.10 =
* Fix deprecated class issue

= 1.9 =
* Fix soft 404 url’s

= 1.8 =
* Fix for issue that may cause infinite redirect loop

= 1.7 =
* Support Handling all 404 error pages when using default permalink structure.
