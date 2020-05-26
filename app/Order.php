<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['voucher_no','order_date','total','status_id','user_id'];
}
