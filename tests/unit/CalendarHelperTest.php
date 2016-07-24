<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\unit\calendar;

use understeam\calendar\CalendarHelper;
use understeam\unit\calendar\models\CalendarModelItem;

/**
 * Class CalendarHelperTest TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CalendarHelperTest extends TestCase
{

    public function testGetMonthDisplayPeriod()
    {
        $period = CalendarHelper::getMonthDisplayPeriod('2016-06');
        $days = [];
        /** @var \DateTime $date */
        foreach ($period as $date) {
            $days[] = $date->format('d');
        }
        $this->assertEquals([
            '30', '31', '01', '02', '03', '04', '05',
            '06', '07', '08', '09', '10', '11', '12',
            '13', '14', '15', '16', '17', '18', '19',
            '20', '21', '22', '23', '24', '25', '26',
            '27', '28', '29', '30', '01', '02', '03',
        ], $days);
    }

    public function testComposeMonthGrid()
    {
        $models = [
            new CalendarModelItem('2016-05-10'),
            new CalendarModelItem('2016-06-05'),
            new CalendarModelItem('2016-06-31'),
            new CalendarModelItem('2016-06-31'),
            new CalendarModelItem('2016-05-31'),
        ];

        $period = CalendarHelper::getMonthDisplayPeriod('2016-06');
        $grid = CalendarHelper::composeMonthGrid($period, $models);
        $this->assertArrayHasKey(22, $grid); // 22th week
        $this->assertArrayHasKey(26, $grid); // 26th week
        $this->assertArrayHasKey(2, $grid[22]); // Tuesday
        $this->assertArrayHasKey(7, $grid[22]); // Sunday
        $this->assertArrayHasKey(5, $grid[26]); // Friday
    }
}
