<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_orderlist extends Model
{
    use HasFactory;

    protected $table = 'mst_orderlist';
    protected $primaryKey = 'orderId'; 
    public $timestamps = false;

    protected $fillable = [
        'orderId',
        'order_category',
        'customerId_fk',
        'sales_person_id',
        'createById_fk',
        'brandId_fk',
        'orderNo',
        'createDate',
        'orderDate',
        'deliveryDate',
        'paymentDate',
        'enterTargetValue',
        'enterDiscount',
        'pendingTGTValue',
        'enterCashDiscount',
        'paymentMode',
        'discountAmt',
        'quantity',
        'totalAmt',
        'taxAmt',
        'grandAmt',
        'mtdValue',
        'casheDiscount',
        'bankId_fk',
        'transportId_fk',
        'chequeNumber',
        'retailer_project_name',
        'targetValue',
        'orderType',
        'itemDetails',
        'shppingAddress',
        'remarks',
        'orderAuthKey',
        'pdf_filename',
        'status'
    ];

    


}
