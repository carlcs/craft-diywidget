<?php

namespace carlcs\diywidget\controllers;

use carlcs\diywidget\Plugin;
use Craft;
use craft\web\Controller;
use yii\web\Response;

class DiyWidgetController extends Controller
{
    /**
     * Returns the widget body HTML.
     *
     * @return Response
     */
    public function actionGetHtml(): Response
    {
        $this->requireLogin();
        $this->requireAcceptsJson();

        $templatePath = Craft::$app->getRequest()->getRequiredBodyParam('templatePath');
        $html = Plugin::getInstance()->getWidgets()->getBodyHtml($templatePath);

        return $this->asJson(compact('html'));
    }
}
