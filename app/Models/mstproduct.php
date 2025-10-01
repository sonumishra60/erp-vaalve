<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mstproduct extends Model
{
    use HasFactory;

    protected $table = 'mst_productlist'; // Replace 'masters' with your actual table name
    protected $primaryKey = 'productId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'productId',
        'categoryId_fk',
        'brandId_fk',
        'subCategoryId_fk',
        'cat_number',
        'mrp',
        'dop_netprice',
        'mop_netprice',
        'productName',
        'productDesc',
        'piece',
        'boxPack',
        'boxMRP',
        'productColorId_fk',
        'productCode',
        'productImage',
        'startDate',
        'endDate',
        'dataEntryDate',
        'productAuthKey',
        'status'
    ];

}
