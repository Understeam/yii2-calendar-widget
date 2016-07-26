# Yii2 Calendar Component

Компонент предназначен для отображения данных внутри календаря с разбивкой
по неделям или месяцам.

## Установка

Установка производится через [Composer](https://getcomposer.org):

```
$ composer require understeam/yii2-calendar-widget:^0.1 --prefer-dist
```

После этого компонент будет установлен в директорию vendor, а его классы будут
доступны в пространстве имён `understeam\calendar`.

## Настройка

Для начала нужно понять - какую модель вы желаете отображать в календаре. Например,
`app\models\Event`. Выбранная модель должна наследовать интерфейс
`understeam\calendar\ItemInterface`, а так же добавить примесь (trait)
`understeam\calendar\ActiveRecordItemTrait`

```php
<?php
namespace app\models;

use understeam\calendar\ItemInterface;
use understeam\calendar\ActiveRecordItemTrait;

class Event extends \yii\db\ActiveRecord implements ItemInterface {
    use ActiveRecordItemTrait;
}
```

Также необходимо добавить компонент в конфигурацию приложения:

```php
'components' => [
    'calendar' => [
        'class' => 'understeam\calendar\ActiveRecordCalendar',  // Имя класса календаря
        'modelClass' => 'app\models\Event',                     // Имя класса модели
        'dateAttribute' => 'date',                              // Атрибут модели, в котором хранится дата (тип в БД timestamp или datetime)
        'dateRange' => [time() + 86400, time() + 2592000]       // период, в который будет доступно событие onClick
        // Так же в dateRange можно передать функцию, которая должна вернуть нужный массив в случае если нужны динамические вычисления
        // 'dateRange' => ['app\models\User', 'getCalendarRange'],
    ],
],
```

## Подключение в контроллер

Чтобы отобразить календарь на странице достаточно добавить `action` в нужный контроллер:

```php
public function actions() {
    return [
        'calendar' => [
            'class' => 'understeam\calendar\CalendarAction',
            'calendar' => 'calendar',           // ID компонента календаря (да, можно подключать несколько)
            'usePjax' => true,                  // Использовать ли pjax для ajax загрузки страниц
            'widgetOptions' => [                // Опции виджета (см. CalendarWidget)
                'clientOptions' => [            // Опции JS плагина виджета (пока только одна)
                    'onClick' => new JsExpression('showPopup'),   // JS функция, которая будет выполнена при клике на доступное время
                    // Эта функция принимает 2 параметра: date и time
                    // Для тестирования можно использовать следующий код:
                    // 'onClick' => new JsExpression("function(d,t){alert([d,t].join(' '))}")
                ],
            ],
        ],
    ];
}
```

## Подключение календаря как виджета

Этот вариант нужно использовать для подключения виджета как часть другой страницы.
С этим немного сложнее, т.к. в виджет нужно передавать некоторый набор данных, а именно:

* grid - сформированный массив сетки календаря
* viewMode - режим просмотра (неделя / месяц)
* period - Объект `DatePeriod`, где начало и конец - это период, который выбран в календаре
* calendar - Наследник `CalendarInterface`, компонент календаря

Общую логику можно проследить в `CalendarAction`.

Этот момент планируется улучшить путём введения сущности `CalendarGrid`, в которую будет
вынесено формирование сетки и методы для определения периодов.

## Планы

На данный момент календарь оптимизирован для работы с `ActiveRecord`, однако
вы можете написать свой компонент-наследник `CalendarInterface` для конфигурации
или забора данных. В будущем планируется простой календарь, без `ActiveRecord`.
