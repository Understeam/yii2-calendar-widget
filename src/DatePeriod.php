<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\calendar;

use DateInterval;
use DateTimeInterface;

/**
 * PHP реализация класса DatePeriod как в PHP 5.6.3
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class DatePeriod implements \Iterator
{

    private $_dateInterval;

    private $_endDate;

    private $_startDate;

    public function __construct(DateTimeInterface $start, DateInterval $interval, DateTimeInterface $end, $options = 0)
    {
        $this->_dateInterval = $interval;
        $this->_startDate = $start;
        $this->_endDate = $end;
    }

    public function getDateInterval()
    {
        return $this->_dateInterval;
    }

    public function getEndDate()
    {
        return clone $this->_endDate;
    }

    public function getStartDate()
    {
        return clone $this->_startDate;
    }

    /**
     * @var \DateTime
     */
    private $_current;

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->_current;
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        if ($this->_current === null) {
            $this->_current = clone $this->_startDate;
        } else {
            $this->_current = clone $this->_current;
            $this->_current->add($this->_dateInterval);
        }
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->_current->getTimestamp();
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->_current !== null
        && $this->_current->getTimestamp() < $this->_endDate->getTimestamp();
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->_current = clone $this->_startDate;
    }
}
