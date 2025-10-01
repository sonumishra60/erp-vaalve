<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_trunover extends Model
{
    use HasFactory;

    protected $table = 'mst_trunover'; // Replace 'masters' with your actual table name
    protected $primaryKey = 'trunOverId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'trunOverId',
        'customerId_fk',
        'trunOverType_fk',
        'firstYear',
        'secondYear',
        'thirdYear',
        'status',

    ];
}
