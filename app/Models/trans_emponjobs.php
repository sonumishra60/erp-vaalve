<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_emponjobs extends Model
{
    use HasFactory;

    protected $table = 'trans_emponjobs'; // Replace 'trans_salesBankInfo' with your actual table name
    protected $primaryKey = 'empIdOnJobsId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'empIdOnJobsId',
        'userId_fk', 
        'vehicleId_fk',
        'checkInLocationLongitude',
        'checkInLocationLongitude',
        'checkInLocationArea',
        'checkOutLocationLatitude',
        'checkOutLocationLongitude',
        'checkOutLocationArea',
        'jobStartDate',
        'jobExistDate',
        'status'
    ];

}
