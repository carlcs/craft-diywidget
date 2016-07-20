<?php
namespace Craft;

class DiyWidgetService extends BaseApplicationComponent
{
    // Properties
    // =========================================================================

    /**
     * @var array
     */
    public $templatePaths;

    /**
     * @var array
     */
    private $_globals;

    // Public Methods
    // =========================================================================

    /**
     * Returns the HTML for the widget.
     *
     * @param string $templatePath
     * @param array $variables
     *
     * @return string|null
     */
    public function getHtml($templatePath, $variables = [])
    {
        $html = null;

        if (in_array($templatePath, $this->templatePaths)) {
            $variables = array_merge($this->getAllGlobals(), $variables);

            $oldTemplatesPath = craft()->templates->getTemplatesPath();
            craft()->templates->setTemplatesPath(craft()->path->getConfigPath().'diywidget');

            try {
                $html = craft()->templates->render($templatePath, $variables);
            } catch (\Exception $e) {
                DiyWidgetPlugin::log('There was an error while rendering the template. '.$e->getMessage(), LogLevel::Error);
                $html = '<div class="error">'.Craft::t('There was an error while rendering the widget.').'</div>';
            }

            craft()->templates->setTemplatesPath($oldTemplatesPath);
        }

        return $html;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Returns all global sets.
     *
     * @return array|null
     */
    protected function getAllGlobals()
    {
        if (!$this->_globals) {
            $globals = [];

            foreach (craft()->globals->getAllSets() as $globalSet) {
                $globals[$globalSet->handle] = $globalSet;
            }

            $this->_globals = $globals;
        }

        return $this->_globals;
    }
}
