<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $apiKey;
    protected $receiverMobileNo;
    protected $channelId;
    protected $msg;
    protected $attachment;


    public function __construct($receiverMobileNo, $msg, $attachment)
    {
       $this->apiKey = env('WHATS_APP_APIKEY');
        $this->receiverMobileNo = $receiverMobileNo;
        $this->channelId = env('WHATS_APP_CHANNELID');
        $this->msg = $msg;
        $this->attachment = $attachment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();

        $payload = [
            'receiverMobileNo' => $this->receiverMobileNo,
            'message' => [$this->msg],
            'channelId' => $this->channelId,
        ];

        // Conditionally add the attachment if it exists
        if (!empty($this->attachment)) {
            $payload['filePathUrl'] = [$this->attachment];
        }

        $response = $client->request('POST', 'http://app.mis.work/api/v1/message/create', [
            'headers' => [
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'x-api-key' => $this->apiKey,
            ],
            'json' => $payload,
        ]);
    }
}
