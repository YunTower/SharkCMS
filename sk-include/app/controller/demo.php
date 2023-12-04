<?php

use Illuminate\Database\Capsule\Manager as DB;

class Demo
{

    public function test()
    {
        echo DB::table('sk_page')->insert(['name' => 'about', 'title' => '关于', 'content' => '关于', 'status' => true, 'allowComment' => false]);
    }
}
