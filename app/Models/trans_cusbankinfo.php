<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_cusbankinfo extends Model
{
    use HasFactory;


    protected $table = 'trans_cusbankinfo'; // Replace 'trans_cusbankinfo' with your actual table name
    protected $primaryKey = 'cusBankId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'cusBankId',
        'customerId_fk', 
        'bankId_fk',
        'accountHolder',
        'accountNo',
        'accountTpe',
        'ifscCode',
        'blankChqueScanCopy',
        'dataEntryDate',
        'bankAuthKey',
        'status'
        
    ];


    
}
