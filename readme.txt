=== Google Safe Search ===
Contributors: miqrogroove
Tags: Google, SafeSearch, adult, content, rating, ICRA, upload, directory, folder
Requires at least: 2.7
Tested up to: 3.0
Stable tag: 1.0

Creates a separate uploads directory for adult content to comply with the Google SafeSearch system.

== Description ==

This plugin helps solve the problem of hosting content intended for different audiences on the same blog.  It gives you the option to upload files to either the default location, or to a subdirectory named "screen".

Separating uploads in this manner may be necessary because Google does not support the current ICRA standard for content rating.  Blogs containing a small number of images that are inappropriate for some audiences may have the entire domain blocked in Google's Image Search results unless those few images are separated from the others.

According to Google employee Susan Moskwa, "We filter at the site- or directory-level, not on individual images; so the best thing would be to put fully "safe" images in one folder, and "moderate" and/or "strict" images in a different folder(s) ... If you had a particular folder that contained all the safe images (or all the unsafe images) we should be able to whitelist the clean stuff."

For background information, see [Google Webmaster Forum](http://www.google.com/support/forum/p/Webmasters/thread?tid=65a31945a70e73b8)

This plugin does not automatically notify Google of your blog's content policy.  At this time, it is necessary to contact Google through the link mentioned above if your Google Image Search results are being filtered incorrectly.

This plugin does not enable you to automatically move any pre-existing uploads between directories.  Doing so properly would involve modifying the posts they are attached to as well as redirecting the old URLs to the new ones at the server layer.  That procedure is beyond the intended scope of this system.

This plugin was inspired and made possible by the dPost Uploads plugin from WordPress developer Dion Hulse ([dd32](http://dd32.id.au/))


== Installation ==

1. Upload the `google-safe-search` directory to your `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

This is a zero-configuration plugin.  There are no settings.

Deactivation removes everything except the files you uploaded.  There is no "uninstall" necessary.


== Changelog ==

= 1.0 =
* First version, released 13 February 2010
* WordPress 3.0-alpha tested 15 February 2010