<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;

/**
 * Class CalendarAction TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarAction extends Action
{

    public $viewFile = '@vendor/understeam/yii2-calendar-widget/src/views/calendar';

    public $modelClass;

    public $usePjax = true;

    public function init()
    {
        parent::init();
        if (!$this->modelClass) {
            throw new InvalidConfigException("CalendarAction::\$modelClass must be set");
        }
        if (!class_exists($this->modelClass)) {
            throw new InvalidConfigException("Class specified in CalendarAction::\$modelClass not found");
        }
    }

    public function run()
    {
        $model = new CalendarActionForm($this->modelClass);
        $model->load(Yii::$app->request->getQueryParams());
        if (!$model->validate()) {
            // Reset form to default values
            $model = new CalendarActionForm($this->modelClass);
            $model->validate();
        }
        $grid = $model->getGrid();
        if ($grid === false) {
            throw new BadRequestHttpException("Cannot build a calendar grid");
        }
        return $this->controller->render($this->viewFile, [
            'model' => $model,
            'usePjax' => $this->usePjax,
        ]);
    }

}
