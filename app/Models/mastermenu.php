<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mastermenu extends Model
{
    use HasFactory;

    protected $table = 'mst_mastermenu'; // Replace 'masters' with your actual table name
    protected $primaryKey = 'masterMenuId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'masterMenuId',
        'parentId',
        'name',
        'masterDataId_fk',
        'description',
        'dataType',
        'profileImages',
        'bannerImages',
        'dataEntrydate',
        'accessAuthKey',
        'accessUrl',
        'status'
        
    ];
}
