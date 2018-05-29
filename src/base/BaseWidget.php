<?php

namespace carlcs\diywidget\base;

use carlcs\diywidget\Plugin;
use craft\base\Widget;

/**
 * @property string $bodyHtml
 */
class BaseWidget extends Widget
{
    // Static
    // =========================================================================

    /**
     * @return string|null
     */
    public static function templatePath()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    protected static function allowMultipleInstances(): bool
    {
        return false;
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the widget's body HTML.
     *
     * @return string
     */
    public function getBodyHtml(): string
    {
        $widget = [
            'id' => $this->id,
            'name' => self::displayName(),
            'templatePath' => static::templatePath(),
        ];

        return Plugin::getInstance()->getWidgets()->getBodyHtml(static::templatePath(), ['widget' => $widget]);
    }
}
