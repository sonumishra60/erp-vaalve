<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_inventory extends Model
{
    use HasFactory;


    protected $table = 'mst_inventory';
    protected $primaryKey = 'id'; 
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jsondata',
        'datetime',
        'status',
    ];


}
