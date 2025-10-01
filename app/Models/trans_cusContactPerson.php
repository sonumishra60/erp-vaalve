<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trans_cusContactPerson extends Model
{
    use HasFactory;

    protected $table = 'trans_cuscontactperson'; // Replace 'trans_cusbankinfo' with your actual table name
    protected $primaryKey = 'cusContactPersonId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'cusContactPersonId',
        'customerId_fk',
        'name',
        'degination',
        'emailId',
        'phoneNumber',
        'contactAuthKey',
        'status'
    ];
}
