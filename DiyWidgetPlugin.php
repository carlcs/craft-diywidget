<?php
namespace Craft;

class DiyWidgetPlugin extends BasePlugin
{
    public function getName()
    {
        return 'Do It Yourself Widget';
    }

    public function getVersion()
    {
        return '1.2.0';
    }

    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'carlcs';
    }

    public function getDeveloperUrl()
    {
        return 'https://github.com/carlcs';
    }

    public function getDocumentationUrl()
    {
        return 'https://github.com/carlcs/craft-diywidget';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://github.com/carlcs/craft-diywidget/raw/master/releases.json';
    }

    // Public Methods
    // =========================================================================

    /**
     * Initializes the plugin.
     */
    public function init()
    {
        if (craft()->request->isCpRequest()) {
            $this->includeCustomCpResources();
        }
    }

    /**
     * Make sure requirements are met before installation.
     *
     * @throws Exception
     */
    public function onBeforeInstall()
    {
        if (version_compare(craft()->getBuild(), '2778', '<')) {
            throw new Exception($this->getName().' plugin requires Craft 2.6.2778 or later.');
        }

        if (!defined('PHP_VERSION') || version_compare(PHP_VERSION, '5.4', '<')) {
            throw new Exception($this->getName().' plugin requires PHP 5.4 or later.');
        }
    }

    /**
     * Registers resource paths for requests starting with config/redactorinlinestyles/.
     */
    public function getResourcePath($path)
    {
        if (strncmp($path, 'config/diywidget/', 17) == 0) {
            return craft()->path->getConfigPath().'diywidget/'.substr($path, 17);
        }
    }

    // Protected Methods
    // =========================================================================

    /**
     * Includes resources for the Control Panel from the craft/config/diywidget/ folder.
     */
    protected function includeCustomCpResources()
    {
        $templatePaths = [];

        $folderPath = craft()->path->getConfigPath().'diywidget/';

        if (IOHelper::folderExists($folderPath)) {
            $filePaths = glob($folderPath.'*.{twig,html,css,js}', GLOB_BRACE);

            foreach ($filePaths as $filePath) {
                $pathInFolder = str_replace($folderPath, '', $filePath);
                $resourcePath = 'config/diywidget/'.$pathInFolder;

                switch (IOHelper::getExtension($filePath)) {
                    case 'twig':
                    case 'html':
                        $templatePaths[] = $pathInFolder;
                        break;
                    case 'css':
                        craft()->templates->includeCssResource($resourcePath);
                        break;
                    case 'js':
                        craft()->templates->includeJsResource($resourcePath);
                        break;
                }
            }
        }

        craft()->diyWidget->templatePaths = $templatePaths;
    }
}
