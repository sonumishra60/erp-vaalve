<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_salestarget extends Model
{
    use HasFactory;

    protected $table = 'trans_salestarget'; // Replace 'trans_salesBankInfo' with your actual table name
    protected $primaryKey = 'salesTargetId'; 
    public $timestamps = false;

     // Define the fillable columns
     protected $fillable = [
        'salesTargetId',
        'sales_userId_fk',
        'areaHead_userId_fk',
        'stateHead_userId_fk',
        'nationalHead_userId_fk',	
        'primaryTarget',
        'secondaryTarget',
        'monthNm',
        'yearNo',
        'dataEntryDate',
        'salesTargetAuthKey',
        'status',
    ];



}
