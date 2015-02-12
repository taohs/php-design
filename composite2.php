<?php
abstract class Unit {
    abstract function addUnit( Unit $unit );
    public abstract function removeUnit( Unit $unit );
    abstract public function  bombardStrength();
}

class Army extends Unit {
    private $units = array();

    function addUnit( Unit $unit ) {

    }

    function removeUnit( Unit $unit ) {

    }
    function bombardStrength(){
        asdfasfLL
    }
}
$a = new Army();
$b = $a;
$c = new Army();
var_dump($a);
var_dump($b);
var_dump($c);
