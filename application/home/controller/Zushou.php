<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2018/8/12
 * Time: 21:53
 */

namespace app\home\controller;


class Zushou extends Home
{

    public function index()
    {

//        return 123;
        return $this->fetch('index');
    }


}