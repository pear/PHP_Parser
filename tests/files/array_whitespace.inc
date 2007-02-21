<?php
function test1($a = array(1, 2 => 'hi', 'my' => array(4)))
{
    static $b = array(
        array(
            1,
            2,
            3 => 'hello',
            array('my' => 'goodness')
        )
    );
    return array(
        new Test('hi'),
        'my' => $a . dirname(__FILE__),
    );
}
?>