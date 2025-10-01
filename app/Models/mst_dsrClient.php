<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_dsrClient extends Model
{
    use HasFactory;

    protected $table = 'mst_dsrClient';
    protected $primaryKey = 'dsrClientId'; 
    public $timestamps = false;

    protected $fillable = [
        'dsrClientId',
        'userId_fk',
        'name',
        'ownerName',
        'phoneNumber',
        'meterReading',
        'meterReadingImage',
        'visitingCard',
        'counterimage',
        'checkInLocation',
        'checkInLatitude',
        'checkInLongitude',
        'checkInDate',
        'checkOutLocation',
        'checkOutLatitude',
        'checkOutLongitude',
        'checkoutmeterReading',
        'checkoutmeterReadingImage',
        'checkOutDate',
        'entryDate',
        'prospect',
        'orderReceive',
        'paymentReceive',
        'nextMeetingDate',
        'amount',
        'paymentMode',
        'entryAuthKey',
        'status'
        
    ];


}
