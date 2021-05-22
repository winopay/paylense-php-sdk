<?php

namespace Paylense;

require_once "Collections.php";

class Test
{
    public function getToken()
    {
        $coll = Collections::getAuthentication();
        echo $coll;
    }
}


if (!debug_backtrace()) {
    $obj = new Test();
    $obj;
}
