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
use App\Models\mstcustomerlist;

use Illuminate\Support\Facades\URL;
use DateTime;


class distributorwhatsappmessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $distrubutor_what;

    public function __construct($distrubutor_what)
    {
        
        $this->distrubutor_what = $distrubutor_what;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

       $customer_id =  $this->distrubutor_what['customer_id'];

       $customerdata = mstcustomerlist::select('mobileNo','ownerName')->where('customerId',$customer_id)->first();

       //$receiverMobileNo = $customerdata->mobileNo;
      // $receiverMobileNo = 9999408444;
       $receiverMobileNo = '9999408444,9990934411';
       $CustomerName = $customerdata->ownerName;


       $pdfRoute = URL::route('order.pdf', ['id' => $this->distrubutor_what['orderAuthKey']]);

       $channelId = env('WHATS_APP_CHANNELID');
       $apiKey = env('WHATS_APP_APIKEY');

        // $msg  = $CustomerName.PHP_EOL. PHP_EOL;

        // $msg .= 'Thank you for choosing VAALVE INDIA. We have received your order and your order no is '.$this->distrubutor_what['order_numebr'].'.' .PHP_EOL. PHP_EOL;

        // $msg .= 'Click on the below link for more detials.'.PHP_EOL. PHP_EOL; 

        // $msg .=  $pdfRoute . PHP_EOL . PHP_EOL;

        // $msg .= 'For any query related to your order please contact CRM team +917290096931 or email - crm@vaalve.in.'.PHP_EOL. PHP_EOL;

        // $msg .='Regards'.PHP_EOL;
        // $msg .= 'VAALVE INDIA'.PHP_EOL;
        // $msg .='Customer Care Team';


        $msg  = 'Dear '.$CustomerName.PHP_EOL. PHP_EOL;

        $msg .= 'Thank you for choosing VAALVE INDIA. We have successfully received your order, and your order number is '.$this->distrubutor_what['order_numebr'].'.' .PHP_EOL. PHP_EOL;

        $msg .= 'For more details, please click on the link below:'.PHP_EOL. PHP_EOL; 

        $msg .=  $pdfRoute . PHP_EOL . PHP_EOL;

        $msg .=  'Order Details' . PHP_EOL . PHP_EOL;

        $msg .= 'If you have any questions or need assistance regarding your order, feel free to contact our CRM team at +91 72900 96931 or via email at crm@vaalve.in.'.PHP_EOL. PHP_EOL;

        $msg .='Regards'.PHP_EOL;
        $msg .= 'VAALVE INDIA'.PHP_EOL;
        $msg .='Customer Care Team';
        

        $client = new Client();
        dispatch(function () use ($client, $apiKey, $receiverMobileNo, $channelId, $msg) {
                  
            $response = $client->request('POST', 'http://app.mis.work/api/v1/message/create', [
                'headers' => [
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-api-key' => $apiKey,
                ],
                'json' => [
                    'receiverMobileNo' => $receiverMobileNo,
                    'message' => [$msg],
                    'channelId' => $channelId,
                ],
            ]);
        
        });



    }
}
