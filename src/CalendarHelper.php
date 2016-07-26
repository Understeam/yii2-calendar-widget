<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

use DateInterval;
use DatePeriod;
use DateTime;

/**
 * Class CalendarHelper TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarHelper
{

    /**
     * @param DatePeriod $period
     * @param ItemInterface[] $items
     * @param $xFormat
     * @param $yFormat
     * @return array
     */
    public static function composeGrid(DatePeriod $period, $items, $xFormat, $yFormat)
    {
        $grid = [];
        /** @var DateTime $date */
        foreach ($period as $date) {
            $nextDate = clone $date;
            $nextDate->add($period->getDateInterval());
            $cell = new GridCell($date);
            foreach ($items as $item) {
                $ts = (int)$item->getTimestamp();
                if ($ts >= $date->getTimestamp() && $ts < $nextDate->getTimestamp()) {
                    $cell->addItem($item);
                }
            }
            $grid[$date->format($xFormat)][$date->format($yFormat)] = $cell;
        }
        return $grid;
    }

    /**
     * @param DatePeriod $period
     * @param ItemInterface[] $items
     * @return array
     */
    public static function composeMonthGrid(DatePeriod $period, $items)
    {
        return self::composeGrid($period, $items, 'W', 'N');
    }

    /**
     * @param DatePeriod $period
     * @param ItemInterface[] $items
     * @return array
     */
    public static function composeWeekGrid(DatePeriod $period, $items)
    {
        return self::composeGrid($period, $items, 'N', 'H:i');
    }

    /**
     * Метод возвращает временные границы месяца
     * @param $dateString
     * @return DatePeriod
     */
    public static function getMonthPeriod($dateString)
    {
        $firstDay = new DateTime($dateString);
        $dayOfMonth = (int)$firstDay->format('d');
        // If not starts from first month day
        if ($dayOfMonth != 1) {
            $firstDay->sub(new DateInterval('P' . ($dayOfMonth - 1) . 'D'));
        }
        $endDay = clone $firstDay;
        $endDay->add(new DateInterval('P1M'));
        return new DatePeriod($firstDay, new DateInterval('P1D'), $endDay);
    }

    /**
     * Метод возвращает временные границы недели
     * @param $dateString
     * @return DatePeriod
     */
    public static function getWeekPeriod($dateString)
    {
        $date = new DateTime($dateString);
        $startDate = clone $date;
        $dayOfWeek = $startDate->format('N');
        if ($dayOfWeek > 1) {
            $startDate->sub(new DateInterval('P' . ($dayOfWeek - 1) . 'D'));
        }

        $endDate = clone $startDate;
        $endDate->add(new DateInterval('P7D'));

        return new DatePeriod($startDate, new DateInterval('P1D'), $endDate);
    }

    /**
     * Метод возвращает временные границы отображаемого месяца календаря
     * для последующей отправки, например, в запрос БД
     * @param string $dateString Дата строкой
     * @return DatePeriod
     */
    public static function getMonthDisplayPeriod($dateString)
    {
        $period = self::getMonthPeriod($dateString);
        /** @var DateTime $firstDay */
        $firstDay = $period->getStartDate();
        /** @var DateTime $endDay */
        $endDay = $period->getEndDate();
        $startDate = clone $firstDay;
        $dayOfWeek = $startDate->format('N');
        // If not starts from Monday
        if ($dayOfWeek > 1) {
            $startDate->sub(new DateInterval('P' . ($dayOfWeek - 1) . 'D'));
        }
        $endDate = clone $endDay;
        $dayOfWeek = $endDate->format('N');
        // If not ends on Monday
        if ($dayOfWeek != 1) {
            $endDate->add(new DateInterval('P' . (7 - $dayOfWeek + 1) . 'D'));
        }

        return new DatePeriod($startDate, new DateInterval('P1D'), $endDate);
    }

    /**
     * Метод возвращает временные границы отображаемой недели календаря
     * для последующей отправки, например, в запрос БД
     * @param string $dateString Дата строкой
     * @param integer $precision Шаг в минутах
     * @return DatePeriod
     */
    public static function getWeekDisplayPeriod($dateString, $precision = 60)
    {
        $period = self::getWeekPeriod($dateString);

        return new DatePeriod($period->getStartDate(), new DateInterval('PT' . $precision . 'M'), $period->getEndDate());
    }

    public static function getMonthColumnCount($grid, $column)
    {
        $count = 0;
        foreach ($grid as $row) {
            $cell = $row[$column];
            $count += count($cell->items);
        }
        return $count;
    }

    public static function getWeekColumnCount($grid, $column)
    {
        $count = 0;
        foreach ($grid[$column] as $cell) {
            $count += count($cell->items);
        }
        return $count;
    }

}
