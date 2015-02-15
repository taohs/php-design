<?php
abstract class Unit {
    abstract function addUnit( Unit $unit );
    public abstract function removeUnit( Unit $unit );
    abstract public function  bombardStrength();
}

class Army extends Unit {
    private $units = array();

    function addUnit( Unit $unit ) {
        if ( in_array( $unit, $this->units, true)) {
            return;
        }
        $this->units[] = $unit;
    }

    function removeUnit( Unit $unit ) {

    }
    function bombardStrength(){

    }
}
$test = array_udiff( array(1,1,3), array(0,1,3), function ( $a, $b ) { return ( $a === $b )? 0: 1; } );
var_dump($test);
var_dump(array_diff(array(1,1,3),array(2,1,3)));
die();
$a = new Army();
$b = $a;
$c = new Army();
var_dump($a);
var_dump($b);
var_dump($c);
