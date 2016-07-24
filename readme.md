# Do It Yourself widget for Craft CMS

![Do It Yourself](https://github.com/carlcs/craft-diywidget/blob/master/resources/screenshot.png)

## Installation

The plugin is available on Packagist and can be installed using Composer. You can also download the [latest release][0] and copy the files into craft/plugins/diywidget/.

```
$ composer require carlcs/craft-diywidget
```

## Creating Widgets

It is super easy to build you own widgets using this plugin. All you need to do is to create a folder craft/config/diywidget/ and add Twig templates to it.

These templates will now be available for use in Do It Yourself widgets on your dashboard. If you need custom CSS or some Javascript, just upload it into that folder as well and they will be included automatically.

If you don’t feel like crafting, just have a play with the [example template files][1]  provided with the plugin.

## Requirements

- PHP 5.4 or later
- Craft CMS 2.6.2778 or later


  [0]: https://github.com/carlcs/craft-diywidget/releases/latest
  [1]: _examples/
