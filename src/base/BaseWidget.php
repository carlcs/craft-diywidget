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

    public static function templatePath(): ?string
    {
        return null;
    }

    protected static function allowMultipleInstances(): bool
    {
        return false;
    }

    // Public Methods
    // =========================================================================

    public function getBodyHtml(): ?string
    {
        $widget = [
            'id' => $this->id,
            'name' => self::displayName(),
            'templatePath' => static::templatePath(),
        ];

        return Plugin::getInstance()->getWidgets()->getBodyHtml(static::templatePath(), ['widget' => $widget]);
    }
}
