<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_salestargethistory extends Model
{
    use HasFactory;

    protected $table = 'trans_salestargethistory'; // Replace 'trans_salesBankInfo' with your actual table name
    protected $primaryKey = 'achieveTargetId'; 
    public $timestamps = false;

     // Define the fillable columns
     protected $fillable = [
        'achieveTargetId',
        'orderId_fk',
        'sales_userId_fk',
        'achievePrimaryTarget',
        'achieveSecondaryTarget',
        'orderType',
        'seniorUserId',
        'monthNm',
        'yearNo',
        'dataEntryDate',
        'salesachieveTargetAuthKey',
        'status',
    ];


}
