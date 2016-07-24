<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

use yii\base\Object;

/**
 * Class CalendarCell TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarCell extends Object
{

    private $_models;

    public function setModels($models)
    {
        ksort($models);
        $this->_models = $models;
    }

    public function getModels()
    {
        return $this->_models;
    }

}
