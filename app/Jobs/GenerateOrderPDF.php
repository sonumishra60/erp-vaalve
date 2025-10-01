<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Models\mst_orderlist;
use PDF;

class GenerateOrderPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
       // set_time_limit(300); // Increase the maximum execution time
    }

    public function handle()
    {
        try {
            Log::info('PDF generation started');

            $orderdata = $this->data['orderdata'];
            $orderId = $orderdata['orderId'];

            $pdf = PDF::loadView('order.pdf', $this->data);
            $filePath = public_path('orderpdf/');
            $fileName = $orderdata['orderNo'] . '-' . time() . '.pdf';
            $pdf->save($filePath . $fileName);

            $order = mst_orderlist::where('orderId', $orderId)->first();
            if ($order) {
                $order->pdf_filename = $fileName;
                $order->save();
            }

            Log::info('PDF generation completed');
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
        }
    }
}