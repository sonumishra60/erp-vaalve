<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_ledger extends Model
{
    use HasFactory;


    
    protected $table = 'mst_ledger';
    protected $primaryKey = 'id'; 
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jsondata',
        'datetime',
        'status',
    ];


}
