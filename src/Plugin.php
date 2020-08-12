<?php

namespace carlcs\diywidget;

use carlcs\diywidget\assets\WidgetsAsset;
use carlcs\diywidget\services\Widgets;
use Craft;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Dashboard;
use yii\base\Event;

/**
 * @property Widgets $widgets
 * @method static Plugin getInstance()
 */
class Plugin extends \craft\base\Plugin
{
    // Public Properties
    // =========================================================================

    /**
     * @inheritdoc
     */
    public $schemaVersion = '2.0.1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->set('widgets', Widgets::class);

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Craft::$app->getView()->registerAssetBundle(WidgetsAsset::class);

            foreach ($widgets = $this->getWidgets()->getAllWidgets() as $widget) {
                $this->_includeWidget($widget);
            }
        }

        Event::on(Dashboard::class, Dashboard::EVENT_REGISTER_WIDGET_TYPES, function(RegisterComponentTypesEvent $event) {
            foreach ($widgets = $this->getWidgets()->getAllWidgets() as $widget) {
                $event->types[] = "\\carlcs\\diywidget\\widgets\\$widget[className]";
            }
        });
    }

    /**
     * Returns the widgets service.
     *
     * @return Widgets
     */
    public function getWidgets(): Widgets
    {
        return $this->get('widgets');
    }

    // Private Methods
    // =========================================================================

    /**
     * Evaluates dynamically generated code for a DIY widget class. The variables
     * that get injected are sanitized in getAllWidgets()
     *
     * @param array $widget
     * @see \carlcs\diywidget\services\Widgets::getAllWidgets()
     */
    private function _includeWidget(array $widget)
    {
        $code = file_get_contents(__DIR__.'/widgets/diywidget.stub');

        $code = strtr($code, [
            '{$className}' => $widget['className'],
            '{$displayName}' => $widget['displayName'],
            '{$templatePath}' => $widget['templatePath'],
            '{$iconPath}' => $widget['iconPath'],
        ]);

        eval($code);
    }
}
