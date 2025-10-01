<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masterdata extends Model
{
    use HasFactory;

    protected $table = 'masterdata'; // Replace 'masters' with your actual table name
    protected $primaryKey = 'masterDataId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'masterDataId',
        'fieldName',
        'levelName',
        'masterAuthKey',
        'dataType',
        'groupName',
        'displaymage',
        'status'
    ];

}
