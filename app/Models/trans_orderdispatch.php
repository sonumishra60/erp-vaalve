<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_orderdispatch extends Model
{
    use HasFactory;

    protected $table = 'trans_orderdispatch';
    protected $primaryKey = 'orderDispatchId'; 
    public $timestamps = false;

     // Define the fillable columns
     protected $fillable = [
        'orderDispatchId',
        'orderId_fk',
        'truckNumber',
        'driverName',
        'fromLocation',
        'toLocation',
        'currentLocation',
        'damageValue',
        'claimAmount',
        'dispatchDate',
        'allDamageImage',
        'deliverDate',
        'biltiNumber',
        'dispatchtAuthKey',
        'remarks',
        'status'
    ];
}
