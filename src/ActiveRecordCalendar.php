<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Класс, который позволяет легко использовать ActiveRecord в качестве объекта календаря
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class ActiveRecordCalendar extends Component implements CalendarInterface
{

    /**
     * @var string|ActiveRecord имя класса модели
     */
    public $modelClass;

    /**
     * @var string атрибут модели, в котором содержится время публикации
     */
    public $dateAttribute = 'date';

    /**
     * @var array|callable период доступных дат
     */
    public $dateRange = [];

    /**
     * @var array|callable фильтр для выборки. Передавать можно как массив ['attribute' => 'value'], так и callable.
     * В случае с callable результирующая функция должна иметь вид:
     * function (ActiveQuery $query, $startTime, $endTime) {
     *   return $query;
     * }
     * Фильтрация по датам применяется вне зависимости от наличия этого параметра
     */
    public $filter;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!$this->modelClass) {
            throw new InvalidConfigException("ActiveRecordCalendar::\$modelClass is not set");
        }
        if (!class_exists($this->modelClass)) {
            throw new InvalidConfigException("Class defined in ActiveRecordCalendar::\$modelClass not found");
        }
    }

    /**
     * @inheritdoc
     */
    public function findItems($startTime, $endTime)
    {
        $modelClass = $this->modelClass;
        $query = $modelClass::find();
        $query
            ->andWhere([
                'AND',
                [
                    '>=',
                    $this->dateAttribute,
                    date('Y-m-d H:i:s', $startTime),
                ],
                [
                    '<',
                    $this->dateAttribute,
                    date('Y-m-d H:i:s', $endTime),
                ],
            ]);
        if (is_callable($this->filter)) {
            $resultQuery = call_user_func($this->filter, $query, $startTime, $endTime);
            if ($resultQuery instanceof ActiveQuery) {
                $query = $resultQuery;
            }
        }
        /** @var ItemInterface[] $models */
        $models = $query->all();
        foreach ($models as $model) {
            $model->setCalendar($this);
        }
        return $models;
    }

    /**
     * @inheritdoc
     */
    public function getAllowedDateRange()
    {
        if (is_callable($this->dateRange)) {
            return call_user_func($this->dateRange);
        }
        if (is_array($this->dateRange)) {
            return $this->dateRange;
        }
        throw new InvalidConfigException("ActiveRecordCalendar::\$dateRange must be array or callable");
    }
}
