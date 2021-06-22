<?php


namespace app\admin\model;


class Manager extends \think\Model {
    protected $table='manager';
    protected $schema =[
        'id' => 'int',
        'name' => 'string',
        'password' => 'string',
        'age' => 'int',
        'email' => 'text',
        'create_time' => 'datetime',
        'update_time' => 'datetime',
    ];
}