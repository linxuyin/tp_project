<?php


namespace app\admin\model;

/**
 * @property int $UID
 * @property string $username
 *
 */
use think\Model;

class User extends Model {
    protected  $table = 'user';
    protected $schema =[
        'UID' => 'int',
        'username' => 'string',
        'nickname' => 'string',
        'password' => 'string',
        'qq' => 'string',
        'email' => 'text',
        'tel' => 'string',
        'regtime' => 'datetime',
    ];

}