## BuddyPress Addon for the MailChimp Integration Plugin (WPMUDEV)

![Screenshot](https://img.shields.io/badge/build-passed-1ece30.svg) ![Screenshot](https://img.shields.io/badge/plugin-WPMUDEV-blue.svg) ![Screenshot](https://img.shields.io/badge/license-GNU_GPL_v2-red.svg) ![Screenshot](https://img.shields.io/badge/release-1.0.0-orange.svg)

This addon allows you to pull data from BuddyPress xProfile fields and pass them in a function call to the MailChimp API. Currently the MailChimp Integration plugin does not read xProfile data out of the Box. 

This applies to users of Membership as well, by default Membership does not support multi dimensional arrays so the groups feature does not work. 

#### Standalone plugin 

Download the zip file and upload it as part of the upload new plugin screen from the admin. It will show up in the list of installed plugins, simply click activate and it will work. 

#### MU Plugin

Open up the `mu-plugins` folder in your WordPress Directory (or create one). Its usually located within the `wp-content` folder of your `public_html` folder. Select the PHP file `bp-mci-addon.php` and place it in the `wp-content/mu-plugin` folder in your WordPress Directory. You will have additional options under display settings as shown in the screenshot below.