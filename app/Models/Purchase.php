<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
protected $table = "purchases";

   public function supplier(){

    return $this->belongsTo(Supplier::class,"supplier_id");
    }

     public function status(){

    return $this->belongsTo(Status::class,"status_id");

    }

       public function details()
    {
        return $this->hasMany(PurchaseDetail::class, "purchase_id");
    }
}
