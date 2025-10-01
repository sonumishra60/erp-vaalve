<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_visitlog extends Model
{
    use HasFactory; 

    protected $table = 'trans_visitlog'; // Replace 'trans_cusbankinfo' with your actual table name
    protected $primaryKey = 'visitId'; 
    public $timestamps = false;


    protected $fillable = [
        'userId_fk',
        'clientvisit_id_fk',
        'checkInType',
        'visitLocation',
        'visitLatitude',
        'visitLongitude',
        'km',
        'visitDate',
        'distributorcheck',
        'visitLogAuthKey',
        'status'  
    ];


}
