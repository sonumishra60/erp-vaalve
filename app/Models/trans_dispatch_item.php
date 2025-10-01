<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_dispatch_item extends Model
{
    use HasFactory;

    protected $table = 'trans_dispatch_item';
    protected $primaryKey = 'orderDispatchId'; 
    public $timestamps = false;

     // Define the fillable columns
     protected $fillable = [
        'itemDispatchId',
        'itemOrderId_fk',
        'orderDispatchId_fk',
        'orderId_fk',
        'productId_fk',
        'qty',
        'status'
    ];

}
