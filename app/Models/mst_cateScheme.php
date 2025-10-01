<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_cateScheme extends Model
{
    use HasFactory;

    protected $table = 'mst_cateScheme';
    protected $primaryKey = 'schemeId'; 
    public $timestamps = false;

    protected $fillable = [
        'schemeId',
        'cateId_fk',
        'numberOfItem',
        'noOfFreeQty',
        'dataEntryDate',
        'startDate',
        'endDate',
        'schemeAuthKey',
        'status',
    ];

}
