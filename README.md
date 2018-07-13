# Do It Yourself widget for Craft CMS

A super easy way to create dashboard widgets for the Control Panel.

## Installation

Do It Yourself widget is available in the Plugin Store. You can also install the plugin manually from the command line with the following commands.

```
> composer require carlcs/craft-diywidget
> ./craft install/plugin diy-widget
```

## Getting Started

To get started simply create a new folder called `diy-widget` inside of your config folder.
You can create new widgets using Twig/HTML, by creating a `widgetname.html` file.

To add CSS or JS simply create a `widgetname.css` or `widgetname.js` file.

You can look at the examples provided in the `_examples/diy-widget` folder. Simply copy the examples into your `diy-widget` folder and you'll be able to select and add them to your dashboard.

## License

[MIT](LICENSE.md)
