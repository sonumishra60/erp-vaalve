<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mstcustomerlist extends Model
{
    use HasFactory;

    protected $table = 'mst_customerlist';
    protected $primaryKey = 'customerId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'customerId',
        'dist_code',
        'categoryNm',
        'customer_type',
        'CustomerName',
        'consigneeName',
        'dealerType',
        'galleryType',
        'address',
        'pincode',
        'city',
        'state',
        'district',
        'zone',
        'email_id',
        'mobileNo',
        'mainHeads',
        'cluster',
        'empCode',
        'salesInCharge',
        'salesTeamEmail_id',
        'natureOfBuss',
        'ownerName',
        'ownerNumber',
        'transporterName',
        'receivedDate',
        'securityAmount',
        'chequeNo',
        'chequeDate',
        'creditLimit',
        'creditPeriod',
        'gstCertificate',
        'securityChq',
        'amount',
        'faucet_ex_fc_disc',
        'faucet_dealer_scheme_discount',
        'faucet_distributor_scheme_discount',
        'faucet_distributor_disc',
        'faucet_retailer_ubs_scheme_disc',
        'sanitary_ex_sc_dicount',
        'sanitary_distributor_disc',
        'sanitary_dealer_line_discount',
        'faucet_finaldiscount',
        'sanitary_finaldiscount',
        'display_discount',
        'bankChq',
        'stateHead',
        'zoneHead',
        'remarks',
        'securityDepoPaymentMode',
        'agreementImage',
        'dataEntryData',
        'numberOfOrder',
        'lastUpdateDate',
        'customerAuthKey',
        'status',
    ];


}