<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;
use yii\base\Object;

/**
 * Class CalendarGridCell TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarGridCell extends Object
{

    public $date;

    public $items = [];

    public function __construct(\DateTime $date, array $config = [])
    {
        parent::__construct($config);
        $this->date = $date;
    }

    public function addItem(CalendarItemInterface $item)
    {
        $this->items[] = $item;
    }

}
