<?php
namespace Craft;

class DiyWidgetWidget extends BaseWidget
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the widget's name.
     *
     * @return string
     */
    public function getName()
    {
        return 'Do It Yourself';
    }

    /**
     * Returns the widget's title.
     *
     * @return string
     */
    public function getTitle()
    {
        $settings = $this->getSettings();

        return Craft::t($settings->title);
    }

    /**
     * Returns the widget's body HTML.
     *
     * @return string|null
     */
    public function getBodyHtml()
    {
        $settings = $this->getSettings();
        $templatePath = $settings->templatePath;

        if (!empty($templatePath)) {
            $widget = [
                'id' => $this->model->id,
                'title' => Craft::t($settings->title),
                'templatePath' => $templatePath,
            ];

            $html = craft()->diyWidget->getHtml($templatePath, ['widget' => $widget]);

            return $html ?: '<div class="error">'.Craft::t('Could not find the selected template.').'</div>';
        }
    }

    /**
     * Returns the widget's settings HTML.
     *
     * @return string
     */
    public function getSettingsHtml()
    {
        $templateOptions = [];

        foreach (craft()->diyWidget->templatePaths as $templatePath) {
            if (substr($templatePath, 0, 1) !== '_') {
                $filename = explode('.', $templatePath)[0];
                $name = $this->titleize($filename);

                $templateOptions[] = ['label' => Craft::t($name), 'value' => $templatePath];
            }
        }

        return craft()->templates->render('diywidget/widgets/diy/settings', [
            'settings' => $this->getSettings(),
            'templateOptions' => $templateOptions,
            'isAdmin' => craft()->userSession->isAdmin(),
        ]);
    }

    // Protected Methods
    // =========================================================================

    /**
     * Converts pascalCase and snake_case to a sentence.
     *
     * @param string $str
     *
     * @return string
     */
    protected function titleize($str)
    {
        $str = preg_replace('/([A-Z]+)([A-Z][a-z])/', '\1-\2', $str);
        $str = preg_replace('/([a-zd])([A-Z])/', '\1-\2', $str);
        $str = preg_replace('/[^A-Z^a-z^0-9]+/', ' ', $str);

        return ucwords(strtolower($str));
    }

    /**
     * Defines the settings.
     *
     * @return array
     */
    protected function defineSettings()
    {
        return [
            'title'        => [AttributeType::String, 'required' => true, 'default' => $this->getName()],
            'templatePath' => [AttributeType::String],
        ];
    }
}
