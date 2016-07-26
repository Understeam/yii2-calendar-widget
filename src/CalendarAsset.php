<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

/**
 * Class CalendarAsset TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@vendor/understeam/yii2-calendar-widget/src/assets';

    public $css = [
        'css/calendar.css',
    ];

    public $js = [
        'js/yii.calendar.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
