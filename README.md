# mediawiki-special-realname

This is a [MediaWiki](https://www.mediawiki.org/) extension that provides a special page. The page will redirect to a user's page, given the user's real name.

It is very useful for group or corporate Wikis, where users call each other by their real names and fills the "Real name" field in their profiles.

This extension has been tested on MediaWiki 1.23.9. It should support any newer versions. (Older versions have been EOL-ed.)

## Features

* Look up in the database for users with the specified real name. (Users can set their real names in their profiles.)
* Redirect to the user's page if there is one match.
* Supports sub-pages in the user's namespace.
* Shows a list of matches if there are several results.

## How to use

Copy `MWExtSpecialRealName` folder to `MediaWiki-Root/extensions/`. Then add the following line to the bottom of `LocalSettings.php`:
```php
require_once( "$IP/extensions/MWExtSpecialRealName/MWExtSpecialRealName.php" );
```

You can then create links to `[[Special:RN/USER-REAL-NAME]]`.

### Template:RN

We also provide a [template](Template_RN.mediawiki) for custom link formats. You can put the template code in `Template:RN`, upload an `User.png` icon, then use `{{RN|USER-REAL-NAME}}` to create the link.
