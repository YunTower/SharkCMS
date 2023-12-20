<?php

use Illuminate\Database\Capsule\Manager as DB;

class Demo
{

    public function test()
    {
      echo $_SERVER['HTTP_USER_AGENT'];
      echo '<script>console.log(navigator.userAgent)</script>';
    }
}
