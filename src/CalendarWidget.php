<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

use Yii;
use yii\base\Widget;

/**
 * Виджет для отображения календаря
 *
 * @property string $viewMode режим просмотра. Определяется на основе сессии, однако можно задать вручную
 *
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarWidget extends Widget
{

    /**
     * @var array Сетка моделей для отображения
     */
    public $grid;

    /**
     * @var string View файл для режима "неделя"
     */
    public $weekView = '@vendor/understeam/yii2-calendar-widget/src/views/week';

    /**
     * @var string View файл для режима "месяц"
     */
    public $monthView = '@vendor/understeam/yii2-calendar-widget/src/views/month';

    /**
     * @var string View файл для ячейки режима "неделя"
     */
    public $weekCellView = '@vendor/understeam/yii2-calendar-widget/src/views/week_cell';

    /**
     * @var string View файл для ячейки режима "месяц"
     */
    public $monthCellView = '@vendor/understeam/yii2-calendar-widget/src/views/month_cell';

    /**
     * Режим просмотра - "месяц"
     */
    const VIEW_MODE_MONTH = 'month';

    /**
     * Режим просмотра - "неделя"
     */
    const VIEW_MODE_WEEK = 'week';

    /**
     * @var string устанавливает режим просмотра
     */
    public $viewMode;

    /**
     * @var \DatePeriod период времени, который следует отобразить
     */
    public $period;

    /**
     * @var string Action, на который будет производиться переход по ссылкам. По умолчанию текущий
     */
    public $action;

    public $actionDateParam = 'date';

    public $actionViewModeParam = 'viewMode';

    public $usePjax = true;

    public function run()
    {
        if ($this->viewMode == self::VIEW_MODE_WEEK) {
            return $this->renderWeek();
        } else {
            return $this->renderMonth();
        }
    }

    public function renderWeek()
    {
        return $this->render($this->weekView, [
            'grid' => $this->grid,
        ]);
    }

    public function renderMonth()
    {
        return $this->render($this->monthView, [
            'grid' => $this->grid,
        ]);
    }

    public function getActionUrl()
    {
        if (!$this->action) {
            return [Yii::$app->controller->getRoute()];
        } else {
            return [$this->action];
        }
    }

    public function getWeekViewUrl()
    {
        $url = $this->getActionUrl();
        $url[$this->actionDateParam] = $this->period->getStartDate()->format('Y-m-d');
        $url[$this->actionViewModeParam] = self::VIEW_MODE_WEEK;
        return $url;
    }

    public function getMonthViewUrl()
    {
        $url = $this->getActionUrl();
        $url[$this->actionDateParam] = $this->period->getEndDate()->sub(new \DateInterval('P1D'))->format('Y-m-d');
        $url[$this->actionViewModeParam] = self::VIEW_MODE_MONTH;
        return $url;
    }

    public function getNextUrl()
    {
        $url = $this->getActionUrl();
        $url[$this->actionDateParam] = $this->getNextDate()->format('Y-m-d');
        $url[$this->actionViewModeParam] = $this->viewMode;
        return $url;
    }

    public function getPrevUrl()
    {
        $url = $this->getActionUrl();
        $url[$this->actionDateParam] = $this->getPrevDate()->format('Y-m-d');
        $url[$this->actionViewModeParam] = $this->viewMode;
        return $url;
    }

    /**
     * @return \DateTime
     */
    public function getNextDate()
    {
        return $this->period->getEndDate();
    }

    /**
     * @return \DateTime
     */
    public function getPrevDate()
    {
        /** @var \DateTime $date */
        $date = $this->period->getStartDate();
        $date->sub(new \DateInterval($this->viewMode == self::VIEW_MODE_WEEK ? 'P7D' : 'P1M'));
        return $date;
    }

    public function getPeriodString()
    {
        $firstDay = $this->period->getStartDate();
        $lastDay = $this->period->getEndDate();
        $lastDay->sub(new \DateInterval('P1D'));

        $left = [(int)$firstDay->format('d')];
        $right = [(int)$lastDay->format('d')];
        $common = [];

        if ($firstDay->format('m') == $lastDay->format('m')) {
            $common[] = Yii::$app->formatter->asDate($firstDay, 'MMM');
        } else {
            $left[] = Yii::$app->formatter->asDate($firstDay, 'MMM');
            $right[] = Yii::$app->formatter->asDate($lastDay, 'MMM');
        }

        if ($firstDay->format('Y') == $lastDay->format('Y')) {
            $common[] = Yii::$app->formatter->asDate($firstDay, 'YYYY');
        } else {
            $left[] = Yii::$app->formatter->asDate($firstDay, 'YYYY');
            $right[] = Yii::$app->formatter->asDate($lastDay, 'YYYY');
        }

        $string = implode(' ', $left) . ' — ' . implode(' ', $right);
        if (count($common)) {
            $string .= ' ' . implode(' ', $common);
        }
        return $string;
    }
}