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
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

/**
 * Class CalendarAction TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarAction extends Action
{

    /**
     * @var string основной view файл
     */
    public $viewFile = '@vendor/understeam/yii2-calendar-widget/src/views/calendar';

    /**
     * @var string|CalendarInterface имя компонента календаря
     */
    public $calendar = 'calendar';
    
    /**
     * @var bool использовать Pjax для Ajax загрузки?
     */
    public $usePjax = true;

    /**
     * @var array свойство позволяет определить дополнительные параметры для виджета, см. CalendarWidget
     */
    public $widgetOptions = [];

    public function init()
    {
        parent::init();
        if (is_string($this->calendar)) {
            $this->calendar = Yii::$app->get($this->calendar);
        }
        if (!$this->calendar instanceof CalendarInterface) {
            throw new InvalidConfigException("Class specified in CalendarAction::\$calendar must inherit CalendarInterface");
        }
    }

    public function run()
    {
        $model = new CalendarActionForm($this->calendar);
        $model->load(Yii::$app->request->getQueryParams());
        if (!$model->validate()) {
            // Reset form to default values
            $model = new CalendarActionForm($this->calendar);
            $model->validate();
        }
        $grid = $model->getGrid();
        if ($grid === false) {
            throw new BadRequestHttpException("Cannot build a calendar grid");
        }
        return $this->controller->render($this->viewFile, [
            'usePjax' => $this->usePjax,
            'widgetOptions' => $this->getWidgetOptions($model),
        ]);
    }

    private function getWidgetOptions(CalendarActionForm $model)
    {
        return ArrayHelper::merge($this->widgetOptions, [
            'grid' => $model->getGrid(),
            'viewMode' => $model->viewMode,
            'period' => $model->getPeriod(),
            'calendar' => $this->calendar,
        ]);
    }

}
