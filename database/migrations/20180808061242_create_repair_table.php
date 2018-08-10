<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateRepairTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        /*
        table('user');
        $table->addColumn('username', 'string',array('limit' => 32,'default'=>'','comment'=>'用户名'))
            ->addColumn('nickname', 'string',array('limit' => 32,'default'=>'','comment'=>'昵称'))
            ->addColumn('password', 'string',array('limit' => 100,'default'=>'','comment'=>'用户密码'))
            ->addColumn('salt', 'string',array('limit' => 50,'default'=>'','comment'=>'盐'))
            ->addColumn('login_status', 'integer',array('limit' => 11,'default'=>0,'comment'=>'登陆状态'))
            ->addColumn('login_code', 'string',array('limit' => 32,'default'=>0,'comment'=>'排他性登陆标识'))
            ->addColumn('last_login_ip', 'string',array('limit' => 30,'default'=>0,'comment'=>'最后登录IP'))
            ->addColumn('last_login_time', 'timestamp',array('comment'=>'最后登录时间'))
            ->addTimestamps()   //默认生成create_time和update_time两个字段
            ->addIndex(array('username'), array('unique' => true))
            ->create();
    }*/


    }
}
