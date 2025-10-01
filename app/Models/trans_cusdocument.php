<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_cusdocument extends Model
{
    use HasFactory;

    protected $table = 'trans_cusdocument'; // Replace 'masters' with your actual table name
    protected $primaryKey = 'cusDocId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'cusDocId',
        'customerId_fk',
        'documentType_fk',
        'documentNumber',
        'docFrontImage',
        'docBackImage',
        'docExpiryDate',
        'dataEntryDate',
        'documentAuthKey',
        'status'
    ];

}
