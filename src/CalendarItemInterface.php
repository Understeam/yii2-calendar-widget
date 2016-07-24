<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

/**
 * Interface CalendarItemInterface TODO: Write interface description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
interface CalendarItemInterface
{

    /**
     * @return integer timestamp записи в календаре
     */
    public function getTimestamp();

    /**
     * Возвращает найденные модели в запрашиваемом промежутке времени
     * @param integer $fromTime
     * @param integer $toTime
     * @return CalendarItemInterface[]
     */
    public static function findCalendarModels($fromTime, $toTime);

}
