<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

/**
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
interface ItemInterface
{

    /**
     * @return integer timestamp записи в календаре
     */
    public function getTimestamp();

    /**
     * @return CalendarInterface
     */
    public function getCalendar();

    /**
     * @param CalendarInterface $calendar
     */
    public function setCalendar(CalendarInterface $calendar);
}
