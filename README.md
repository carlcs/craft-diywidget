# Do It Yourself widget for Craft CMS

A super easy way to create your own dashboard widgets for the Control Panel.

## Installation

Do It Yourself widget is available in the Plugin Store. You can also install the plugin manually from the command line with the following commands.

```
composer require carlcs/craft-diywidget
php craft plugin/install diy-widget
```

## Getting Started

It is super easy to build your own widgets using this plugin. All you need to do is to create a new folder called `diy-widget` inside of your config folder and add Twig templates to it.

You can create new widgets using Twig/HTML, by creating a `widget-name.html` file.

These templates will now be available to add to your dashboard. To give the widget an icon, upload a `widget-name.svg` file. If you need custom CSS or some Javascript, just upload it into that folder as well and they will be included automatically.

If you don’t feel like crafting, just have a play with the example template files provided with the plugin. Copy the files from [`_examples/diy-widget/`](_examples/diy-widget) into your `config/diy-widget/` folder.

## License

[MIT](LICENSE.md)
