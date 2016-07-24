<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\unit\calendar\models;

use understeam\calendar\CalendarItemInterface;
use yii\base\Model;

/**
 * Class CalendarModelItem TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarModelItem extends Model implements CalendarItemInterface
{

    private $_date;

    public function __construct($date, array $config = [])
    {
        $this->_date = $date;
        parent::__construct($config);
    }

    /**
     * @return integer timestamp записи в календаре
     */
    public function getTimestamp()
    {
        return strtotime($this->_date);
    }

    /**
     * @return string URL миниатюры изображения для вставки в календарь
     */
    public function getImageUrl()
    {
        return '';
    }

    /**
     * @return mixed первичный ключ записи (определён в ActiveRecord)
     */
    public function getPrimaryKey()
    {
        return 1;
    }

    /**
     * Возвращает найденные модели в запрашиваемом промежутке времени
     * @param integer $fromTime
     * @param integer $toTime
     * @return \understeam\calendar\CalendarItemInterface[]
     */
    public static function findCalendarModels($fromTime, $toTime)
    {
        // TODO: Implement findCalendarModels() method. 
    }
}
