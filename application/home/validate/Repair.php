<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2018/8/9
 * Time: 14:45
 */

namespace app\home\validate;


use think\Validate;

class Repair extends Validate
{
        protected $rule=[
            ['name','require|max:20','姓名不能为空|姓名最大不能超过20个字符'],
            ['tel','require','电话不能为空']
        ];
}