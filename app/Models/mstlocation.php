<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mstlocation extends Model
{
    use HasFactory;

    protected $table = 'mst_location'; // Replace 'masters' with your actual table name
    protected $primaryKey = 'cityId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'cityId',
        'parentId',
        'cityName',
        'cityLat',
        'cityLong',
        'dataEntryDate',
        'cityAuth',
        'status'
    ];
}
