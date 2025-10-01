<?php 

namespace App\Exports;

use App\Models\mst_orderlist;
use App\Models\mstcustomerlist;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class OrdersExport implements FromView
{
    protected $orderNo, $order_p, $companyName, $fromDate, $toDate, $amount, $discount, $gstAmt, $totalAmount;

    public function __construct($orderNo, $order_p, $companyName, $fromDate, $toDate, $amount, $discount, $gstAmt, $totalAmount)
    {
        $this->orderNo = $orderNo;
        $this->companyName = $companyName;
        $this->fromDate = $fromDate;
        $this->order_p = $order_p;
        $this->toDate = $toDate;
        $this->amount = $amount;
        $this->discount = $discount;
        $this->gstAmt = $gstAmt;
        $this->totalAmount = $totalAmount;
    }

    public function view(): View
    {
        // $orders = mst_orderlist::when($this->fromDate && $this->toDate, function ($query) {
        //     $query->whereBetween('mst_orderlist.orderDate', [$this->fromDate, $this->toDate]);
        // })
        // ->join('mst_orderitem', 'mst_orderitem.orderId_fk', '=', 'mst_orderlist.orderId')
        // ->join('mst_productlist', 'mst_productlist.productId', '=', 'mst_orderitem.productId_fk')
        // ->select('mst_orderlist.*','mst_productlist.cat_number','mst_productlist.productName','mst_orderitem.qty','mst_orderitem.pcsRate','mst_orderitem.totalAmt as rateinto')
        // ->get();  
        
        if (!empty($this->companyName)) {
            $query_cat = mstcustomerlist::where('CustomerName', 'like', '%' . $this->companyName . '%')->pluck('customerId')->toArray();
        }
        
        $orders = mst_orderlist::select(
                'mst_orderlist.*',
                'mst_productlist.cat_number',
                'mst_productlist.productName',
                'mst_orderitem.qty',
                'mst_orderitem.pcsRate',
                'mst_orderitem.totalAmt as rateinto'
            )
            ->join('mst_orderitem', 'mst_orderitem.orderId_fk', '=', 'mst_orderlist.orderId')
            ->join('mst_productlist', 'mst_productlist.productId', '=', 'mst_orderitem.productId_fk')
            ->join('mst_customerlist', 'mst_customerlist.customerId', '=', 'mst_orderlist.customerId_fk')
            ->where('mst_orderlist.status', '!=', 0);

        if($this->order_p == 's'){
           // $orders->where('retailer_project_name','!=', null);
           $orders->where('mst_orderlist.retailer_project_name', '!=', null)
            ->where('mst_customerlist.consigneeName', '!=', null)
            ->whereColumn('mst_customerlist.CustomerName', '!=', 'mst_customerlist.consigneeName');
        }
        else{
            $orders->where(function ($query) {
                $query->whereColumn('mst_customerlist.CustomerName', 'mst_customerlist.consigneeName')
                    ->orWhereNull('mst_customerlist.consigneeName');
            });
        }

        if (session('userinfo')->role_type == 3) {
            $orders->where('mst_orderlist.sales_person_id', session('userinfo')->userId);
        }
        
        if ($this->orderNo) {
            $orders->where('orderNo', 'like', '%' . $this->orderNo . '%');
        }
        
        if (!empty($this->companyName) && !empty($query_cat)) {
            $orders->whereIn('mst_orderlist.customerId_fk', $query_cat);
        }
        
        if ($this->fromDate && $this->toDate) {
            $orders->whereBetween('mst_orderlist.orderDate', [$this->fromDate, $this->toDate]);
        }
        
        if ($this->amount) {
            $orders->where('mst_orderlist.totalAmt', 'like', '%' . $this->amount . '%');
        }
        
        if ($this->discount) {
            $orders->where('mst_orderlist.discountAmt', 'like', '%' . $this->discount . '%');
        }
        
        if ($this->gstAmt) {
            $orders->where('mst_orderlist.taxAmt', 'like', '%' . $this->gstAmt . '%');
        }
        
        if ($this->totalAmount) {
            $orders->where('mst_orderlist.grandAmt', 'like', '%' . $this->totalAmount . '%');
        }
        
        // Execute the query
        $orders = $orders->get();
        
       // dd($orders);

        return view('order.export', [
            'orders' => $orders
        ]);
        
    }
}
