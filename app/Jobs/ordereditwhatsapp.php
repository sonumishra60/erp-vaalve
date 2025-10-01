<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use App\Models\UserList;
use App\Models\mst_orderitem;
use App\Models\mst_orderlist;
use App\Models\trans_salestargethistory;
use Illuminate\Support\Facades\URL;
use DateTime;


class ordereditwhatsapp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sales_data;

    public function __construct($sales_data)
    {
        
        $this->sales_data = $sales_data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


        //dd($this->sales_data);
        

        $year = date('Y');
        $month = date('M');

        $mtd_first_date = '01-'.$month.'-'.$year;
        $mtd_first_date = strtotime($mtd_first_date);

        $lastDayOfMonth = new DateTime("$year-$month-01");
        $lastDayOfMonth->modify('last day of this month');
        $mtd_last_date = $lastDayOfMonth->format('d-m-Y');
      //  dd($mtd_last_date);
        $mtd_last_date = strtotime($mtd_last_date);


        $filteredSalesData = array_values(array_filter((array)$this->sales_data['sales_whatspp'], function ($value) {
            return !is_null($value);
        }));

        
    
        $loginIds = UserList::select('userId','loginId', 'name')
        ->whereIn('userId', $filteredSalesData)
        ->get();

        //dd($loginIds);

        foreach($loginIds as $key => $user){

           // $receiverMobileNo = $user->loginId;
          // $receiverMobileNo = '8527033664';

          $receiverMobileNo = '9999408444,9990934411';

            //dd($receiverMobileNo);
       
        $channelId = env('WHATS_APP_CHANNELID');
        $apiKey = env('WHATS_APP_APIKEY');

    //    $trans_salestargethistory =  trans_salestargethistory::where('sales_userId_fk',$user->userId)
    //                             ->where('monthNm',date('M'))
    //                             ->where('yearNo',date('Y'))
    //                             ->sum('achievePrimaryTarget');
                                
        $discountAmt = mst_orderlist::where('sales_person_id',$user->userId)
        ->where('createDate', '>=', $mtd_first_date)
        ->where('createDate', '<=', $mtd_last_date)
        ->sum('discountAmt');
        
            $totalAmt = mst_orderlist::where('sales_person_id',$user->userId)
                    ->where('createDate', '>=', $mtd_first_date)
                    ->where('createDate', '<=', $mtd_last_date)
                    ->sum('totalAmt');

        $mtd = round($totalAmt - $discountAmt, 2);

            //dd($trans_salestargethistory.' = '.date('M').' = '.date('Y').' = '.$user->userId);
        
       // $receiverMobileNo = '8585923403';

       //dd('$mtd => '. $mtd);
       //dd($this->sales_data);
       $pdfRoute = URL::route('order.pdf', ['id' => $this->sales_data['orderAuthKey']]);
        // $msg  = '*!!! New Order !!!*'.PHP_EOL. PHP_EOL;
        // $msg .= 'Dear  *'.$user->name.'*'. PHP_EOL;
        // $msg .= 'New order has been confirmed '. PHP_EOL;
        // $msg .= 'Primary TGT  : '. primarytarget($user->userId, date('M'),date('Y')).  PHP_EOL;
        // $msg .= 'Primary MTD  : '. $trans_salestargethistory.  PHP_EOL;

        $tgt = primarytarget($user->userId, date('M'),date('Y'));


        $pendingtgt =   round($tgt - $mtd, 2);

        if($pendingtgt < 0){
            $pendingtgt = 0;
        }

        $msg  = 'Hi *Mr. '.$user->name.'*,'.PHP_EOL. PHP_EOL;

        $msg .= 'Please find below detials of the order form submitted. The Automatic Order# for the same is '.$this->sales_data['order_numebr'].'.' .PHP_EOL. PHP_EOL;

        $msg .= 'Click on the below link for more detials.'.PHP_EOL. PHP_EOL; 

        $msg .=  $pdfRoute . PHP_EOL . PHP_EOL;

        $msg .=  'Current Order Value - Rs. '.$this->sales_data['current_order'].PHP_EOL;
        $msg .=  'MTD Sales - Rs. '.(int) $mtd.PHP_EOL;
        $msg .=  'Pending TGT - Rs. '. (int) $pendingtgt.PHP_EOL.PHP_EOL;

        $msg .='Feel free to call on +919999408444 for further details.';

        $msg .='Thanks'.PHP_EOL;
        $msg .='Team VAALVE';
      
      //  dd( $msg);
        $client = new Client();
        // dispatch(function () use ($client, $apiKey, $receiverMobileNo, $channelId, $msg) {
                  
        //     $response = $client->request('POST', 'http://app.mis.work/api/v1/message/create', [
        //         'headers' => [
        //             'accept' => 'application/json',
        //             'Content-Type' => 'application/json',
        //             'x-api-key' => $apiKey,
        //         ],
        //         'json' => [
        //             'receiverMobileNo' => $receiverMobileNo,
        //             'message' => [$msg],
        //             'channelId' => $channelId,
        //         ],
        //     ]);
        
        // });

       // dd($response);



        }
        


    }
}
