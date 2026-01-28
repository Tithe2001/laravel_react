<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}
    public function customer(){

    return $this->belongsTo(Customer::class,"customer_id");
    }

     public function status(){

    return $this->belongsTo(Status::class,"status_id");

    }

}

