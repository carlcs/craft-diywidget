<?php

namespace carlcs\diywidget\services;

use Craft;
use craft\base\Component;
use craft\helpers\FileHelper;
use craft\helpers\StringHelper;
use Exception;

/**
 * @property array $allWidgets
 * @property array $allGlobalSets
 */
class Widgets extends Component
{
    // Properties
    // =========================================================================

    private ?array $_widgets = null;
    private ?array $_globalSets = null;

    // Public Methods
    // =========================================================================

    public function getAllWidgets(): array
    {
        if ($this->_widgets !== null) {
            return $this->_widgets;
        }

        $this->_widgets = [];
        $basePath = Craft::getAlias('@config/diy-widget');

        if (!is_dir($basePath)) {
            return $this->_widgets;
        }

        foreach ($this->findTemplates($basePath) as $path) {
            // Let’s sanitize the template path right away
            $path = preg_replace('/[\"\')(]/', '', $path);

            $relativePath = substr($path, strlen($basePath) + 1);

            $filename = pathinfo($path, PATHINFO_FILENAME);
            $title = StringHelper::toTitleCase(implode(' ', StringHelper::toWords($filename, false, true)));
            $className = str_replace(' ', '', $title);

            $iconPath = pathinfo($path, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($path, PATHINFO_FILENAME) . '.svg';
            $iconPath = file_exists($iconPath) ? $iconPath : null;

            $this->_widgets[] = [
                'className' => $className,
                'displayName' => Craft::t('site', $title),
                'templatePath' => $relativePath,
                'iconPath' => $iconPath,
            ];
        }

        return $this->_widgets;
    }

    public function getBodyHtml(string $templatePath, array $variables = []): string
    {
        $variables = array_merge($this->getAllGlobalSets(), $variables);

        $view = Craft::$app->getView();

        $oldTemplatesPath = $view->getTemplatesPath();
        $view->setTemplatesPath(Craft::getAlias('@config/diy-widget'));

        try {
            $html = $view->renderTemplate($templatePath, $variables);
        } catch (Exception $e) {
            Craft::error('There was an error while rendering the widget. '.$e->getMessage(), __METHOD__);
            $html = '<div class="error">'.Craft::t('diy-widget', 'There was an error while rendering the widget.').'</div>';
        }

        $view->setTemplatesPath($oldTemplatesPath);

        return $html;
    }

    // Protected Methods
    // =========================================================================

    protected function findTemplates(string $basePath): array
    {
        $general = Craft::$app->getConfig()->getGeneral();

        $only = [];
        foreach ($general->defaultTemplateExtensions as $ext) {
            $only[] = '*.'.$ext;
        }

        return FileHelper::findFiles($basePath, [
            'only' => $only,
            'except' => ['_*'],
        ]);
    }

    protected function getAllGlobalSets(): array
    {
        if ($this->_globalSets !== null) {
            return $this->_globalSets;
        }

        $this->_globalSets = [];

        foreach (Craft::$app->getGlobals()->getAllSets() as $globalSet) {
            $this->_globalSets[$globalSet->handle] = $globalSet;
        }

        return $this->_globalSets;
    }
}
