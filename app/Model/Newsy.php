<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Newsy extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'new';
    protected $primaryKey = 'new_id';

    /**
     * 可以被批量赋值的属性.
     *白名单
     * @var array
     */
    //protected $fillable = ['name'];

    /**
     * 不能被批量赋值的属性
     *黑名单
     * @var array
     */
    protected $guarded = [];

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}