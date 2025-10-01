<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_disConsignment extends Model
{
    use HasFactory;

    protected $table = 'mst_disConsignment';
    protected $primaryKey = 'cusConsigId'; 
    public $timestamps = false;

    protected $fillable = [
        'cusConsigId',
        'customerId_fk',
        'consignmentName',
        'address',
        'dataEntryDate',
        'consignmentAuthKey',
        'status',
    ];
}
