<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Detail extends Model
{
    protected $fillable = ['order_id','item_id','sub_total','qty'];
}
