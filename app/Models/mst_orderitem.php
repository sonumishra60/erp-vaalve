<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\mstproduct;
use App\Models\mastermenu;

class mst_orderitem extends Model
{
    use HasFactory;


    protected $table = 'mst_orderitem';
    protected $primaryKey = 'itemOrderId'; 
    public $timestamps = false;

    protected $fillable = [
        'itemOrderId',
        'customerId_fk',
        'orderId_fk',
        'productId_fk',
        'qty',
        'boxPrice',
        'pcsRate',
        'mrptype',
        'totalAmt',
        'discountAmt',
        'netAmt',
        'status',
    ];

    public function productitem()
    {
        return $this->hasOne(mstproduct::class, 'productId', 'productId_fk')
        ->select(['productId', 'productImage','dop_netprice','mop_netprice','cat_number', 'productName','subCategoryId_fk']);
      
    }



   


}
