# Do It Yourself widget for Craft CMS

A super easy way to create dashboard widgets for the Control Panel.

## Installation

Do It Yourself widget is available in the Plugin Store. You can also install the plugin manually from the command line with the following commands.

```
> composer require carlcs/craft-diywidget
> ./craft install/plugin diy-widget
```

## Getting Started

It is super easy to build you own widgets using this plugin. All you need to do is to create a new folder called `diy-widget` inside of your config folder and add Twig templates to it.

You can create new widgets using Twig/HTML, by creating a `widgetname.html` file.

These templates will now be available to add to your dashboard. If you need custom CSS or some Javascript, just upload it into that folder as well and they will be included automatically. Simply create a `widgetname.css` or `widgetname.js` file.

If you don’t feel like crafting, just have a play with the example template files provided with the plugin.

## License

[MIT](LICENSE.md)
