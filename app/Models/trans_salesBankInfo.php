<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_salesBankInfo extends Model
{
    use HasFactory;

    protected $table = 'trans_salesbankinfo'; // Replace 'trans_salesBankInfo' with your actual table name
    protected $primaryKey = 'salesBankId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'salesBankId',
        'userId_fk', 
        'bankId_fk',
        'accountHolder',
        'accountNo',
        'accountTpe',
        'ifscCode',
        'blankCqueScanCopy',
        'dataEntryDate',
        'bankAuthKey',
        'status'
    ];

}
 