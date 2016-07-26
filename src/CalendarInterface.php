<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

/**
 * Interface CalendarInterface TODO: Write interface description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
interface CalendarInterface
{
    /**
     * Режим просмотра - "неделя"
     */
    const VIEW_MODE_WEEK = 'week';
    /**
     * Режим просмотра - "месяц"
     */
    const VIEW_MODE_MONTH = 'month';

    /**
     * Возвращает найденные модели в запрашиваемом промежутке времени
     * @param integer $fromTime
     * @param integer $toTime
     * @return ItemInterface[]
     */
    public function findItems($fromTime, $toTime);

    /**
     * Возвращает временные границы, которые доступны для добавления новых объектов
     * @return integer[] массив с штампами времени в одном из форматов: [$startTime, $endTime], [$startTime], [null, $endTime] или []
     */
    public function getAllowedDateRange();

}
