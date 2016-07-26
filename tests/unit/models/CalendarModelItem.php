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

    public $date;

    public function __construct($date, array $config = [])
    {
        $this->date = $date;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function getTimestamp()
    {
        return strtotime($this->date);
    }

    /**
     * @inheritdoc
     */
    public static function findCalendarModels($fromTime, $toTime)
    {
        // TODO: Implement findCalendarModels() method. 
    }

    /**
     * @inheritdoc
     */
    public static function getAllowedDateRange()
    {
        return [time() + 360 * 24, time() + 3600 * 24 * 30];
    }
}
