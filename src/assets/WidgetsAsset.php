<?php

namespace carlcs\diywidget\assets;

use Craft;
use craft\helpers\FileHelper;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class WidgetsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $sourcePath = Craft::getAlias('@config/diy-widget');

        if (!is_dir($sourcePath)) {
            return;
        }

        $this->sourcePath = $sourcePath;

        $this->depends = [
            CpAsset::class,
        ];

        $options = [
            'only' => ['*.js', '*.css']
        ];

        foreach (FileHelper::findFiles($sourcePath, $options) as $file) {
            $relativePath = substr($file, strlen($sourcePath) + 1);

            switch (pathinfo($file, PATHINFO_EXTENSION)) {
                case 'js':
                    $this->js[] = $relativePath;
                    break;
                case 'css':
                    $this->css[] = $relativePath;
                    break;
            }
        }

        parent::init();
    }
}
