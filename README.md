Koken Password Protection
=========================

The plugin was forked from https://github.com/bhays/brh-password-protection which allows multiple url password combinations. I wanted something a little simpler with just one password that covered the whole install.

Plugin for [Koken](http://koken.me) to allow password protection for the whole install.

This is by no means secure, but it does restrict access to content.

**Note** this plugin is currently incompatable with template caching, you will need to uncheck that option in Settings -> Site Publishing

Filtered output uses [PHP Simple HTML DOM Parser](http://simplehtmldom.sourceforge.net/) by S.C. Chen.


Requirements
------------

1. [Koken](http://koken.me) installation

Installation
------------

1. Upload the brh-password-protection folder to your Koken installation's storage/plugins directory.

2. Sign in to Koken, then visit the Settings > Plugins page to activate the plugin.

3. Once activated, click the Setup button and add a passwords of your choice.

4. Make sure Template Caching is disabled under Settings -> Site Publishing.
