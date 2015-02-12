<?php
/**
 * Created by PhpStorm.
 * User: taohaisong
 * Date: 2015/2/12
 * Time: 11:47
 */

/**
 * Class Unit
 * 抽象单元类 基类
 */
abstract class Unit {
    public abstract function bombardStrength();
}

/**
 * Class Archer
 * 弓箭手 基类
 */
class Archer extends Unit{
    function bombardStrength() {
        return 4;
    }
}

/**
 * Class LaserCannonUnit
 * 激光炮基类
 */
class LaserCannonUnit extends Unit{
    function bombardStrength() {
        return 44;
    }
}

/**
 * Class Army
 * @var $unit Unit
 */
class Army {
    private $units = array();
    function addUnit( Unit $unit ) {
        array_push($this->units,$unit);
    }
    function bombardStrength() {
        $ret = 0;
        foreach( $this->units as $unit ) {
            $ret = $unit->bombardStrength();
        }
        return $ret;
    }

    private $armies = array();
    function addArmy( Army $army ) {
        array_push( $this->armies,$army );
    }
    function bombardStrengths() {
        $ret = 0;
        foreach( $this->units as $unit ) {
            $ret += $unit->bombardStrength();
        }

        foreach( $this->armies as $army ) {
            $ret += $army->bombardStrength();
        }

        return $ret;
    }
}
