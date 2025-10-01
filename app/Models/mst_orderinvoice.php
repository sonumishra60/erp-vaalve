<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_orderinvoice extends Model
{
    use HasFactory;

    protected $table = 'mst_orderinvoice';
    protected $primaryKey = 'orderinvoiceId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'orderinvoiceId',
        'orderId_fk',
        'invoiceName',
        'totalAmount',
        'createdby',
        'createdAt',
        'status',
    ];


}