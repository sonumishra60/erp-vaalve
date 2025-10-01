<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\mst_orderlist;
use PDF;
use Illuminate\Support\Facades\Log;

class GenerateOrderPDFWithId implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $data;
    protected $fileName;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->fileName = $this->data['orderdata']['orderNo'] . '-' . time() . '.pdf';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('GenerateOrderPDFWithId job started.', ['data' => $this->data]);

        if (!isset($this->data['orderdata'])) {
            Log::error('Order data is missing from the provided data.');
            return;
        }

        $orderId = $this->data['orderdata']['orderId'];
        $filePath = public_path('orderpdf/' . $this->fileName);

        Log::info('PDF file path', ['filePath' => $filePath]);

        try {
            $pdf = PDF::loadView('order.pdf', $this->data);

            //dd($filePath, $pdf->output());
            // Log the PDF output to debug
            Log::info('PDF output', ['pdfOutput' => $pdf->output()]);
            $pdf->save($filePath);

            Log::info('PDF saved successfully', ['filePath' => $filePath]);

            $order = mst_orderlist::where('orderId', $orderId)->first();
            if ($order) {
                $order->pdf_filename = $this->fileName;
                $order->save();
                Log::info('Order updated with PDF filename', ['orderId' => $orderId, 'fileName' => $this->fileName]);
            } else {
                Log::error('Order not found for updating PDF filename', ['orderId' => $orderId]);
            }
        } catch (\Exception $e) {
            Log::error('Error generating PDF', ['error' => $e->getMessage()]);
        }

        Log::info('GenerateOrderPDFWithId job completed successfully.', ['fileName' => $this->fileName]);
    }


      public function getFilePath()
    {
        return $this->filePath;
    }





}
