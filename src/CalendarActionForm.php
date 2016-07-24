<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

use yii\base\Model;

/**
 * Class CalendarActionForm TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarActionForm extends Model
{

    public $viewMode;

    public $date;

    /**
     * @var CalendarItemInterface
     */
    private $_modelClass;

    public function __construct($modelClass, array $config = [])
    {
        parent::__construct($config);
        $this->_modelClass = $modelClass;
    }

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            ['viewMode', 'default', 'value' => CalendarWidget::VIEW_MODE_MONTH],
            ['date', 'default', 'value' => date('Y-m-d')],
            ['viewMode', 'in', 'range' => [CalendarWidget::VIEW_MODE_MONTH, CalendarWidget::VIEW_MODE_WEEK]],
            ['date', 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * @return \DatePeriod
     */
    public function getPeriod()
    {
        if ($this->viewMode == CalendarWidget::VIEW_MODE_MONTH) {
            return CalendarHelper::getMonthPeriod($this->date);
        } else {
            return CalendarHelper::getWeekPeriod($this->date);
        }
    }

    /**
     * @return \DatePeriod
     */
    public function getDisplayPeriod()
    {
        if ($this->viewMode == CalendarWidget::VIEW_MODE_MONTH) {
            return CalendarHelper::getMonthDisplayPeriod($this->date);
        } else {
            return CalendarHelper::getWeekDisplayPeriod($this->date);
        }
    }

    /**
     * @return array
     */
    public function getGrid()
    {
        $period = $this->getDisplayPeriod();
        $modelClass = $this->_modelClass;
        $models = $modelClass::findCalendarModels(
            $period->getStartDate()->getTimestamp(),
            $period->getEndDate()->getTimestamp()
        );
        if ($this->viewMode == CalendarWidget::VIEW_MODE_MONTH) {
            $grid = CalendarHelper::composeMonthGrid($period, $models);
        } else {
            $grid = CalendarHelper::composeWeekGrid($period, $models);
        }
        return $grid;
    }

}
