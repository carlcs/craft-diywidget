<?php
namespace Craft;

class DiyWidgetController extends BaseController
{
    // Public Methods
    // =========================================================================

    public function actionGetHtml()
    {
        $this->requireAjaxRequest();

        $templatePath = craft()->request->getRequiredPost('templatePath');

        if ($templatePath) {
            $this->returnJson(['html' => craft()->diyWidget->getHtml($templatePath)]);
        }
    }
}
