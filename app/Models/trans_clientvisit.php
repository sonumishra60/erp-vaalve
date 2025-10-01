<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_clientvisit extends Model
{
    use HasFactory;

    protected $table = 'trans_clientvisit'; // Replace 'trans_cusbankinfo' with your actual table name
    protected $primaryKey = 'clientVisitId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'clientVisitId',
        'customerId_fk',
        'salesUserId',
        'createById_fk',
        'projectName',
        'locationImage',
        'checkInLocation',
        'checkInLatitude',
        'checkInLongitude',
        'checkInDate',
        'checkInMeterReading',
        'checkInMeterReadingImage',
        'orderReceive',
        'paymentReceive',
        'amount',
        'nextMeetingDate',
        'paymentMode',
        'checkOutLocation',
        'checkOutLatitude',
        'checkOutLongitude',
        'checkOutDate',
        'checkoutmeterReading',
        'checkoutmeterReadingImage',
        'visitAuthKey',
        'status'
        
    ];
}
