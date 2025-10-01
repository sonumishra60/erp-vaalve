<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Vaalve Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-css.css') }}">
    <style>
        @media print {
            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
        }

        .table {
            color: #000000;
            font-family: 'Open Sans', sans-serif;
        }

        .invoice-content {
            font-family: 'Open Sans', sans-serif;
            color: #000000;
            font-size: 12px;
        }

        h1 {
            font-family: 'Open Sans', sans-serif;
            margin: 0px;
            padding: 0px;
        }

        h2 {
            font-family: 'Open Sans', sans-serif;
            margin: 0px;
            padding: 0px;
        }

        h3 {
            font-family: 'Open Sans', sans-serif;
            margin: 0px;
            padding: 0px;
        }

        h4 {
            font-family: 'Open Sans', sans-serif;
            margin: 0px;
            padding: 0px;
        }

        h5 {
            font-family: 'Open Sans', sans-serif;
            margin: 0px;
            padding: 0px;
        }

        h6 {
            font-family: 'Open Sans', sans-serif;
            margin: 0px;
            padding: 0px;
        }

        p {
            font-family: 'Open Sans', sans-serif;
            margin: 0px;
            padding: 0px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .mb-30 {
            margin-bottom: 30px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
    </style>
</head>

<body style="font-family: 'Open Sans', sans-serif; margin: 0px; padding: 0px;">

    <!-- Invoice 2 start -->
    <div class="invoice-2 invoice-content">
        <div class="container">
            <div class="row">
                <div>
                    <div>
                        <div>
                            <div>
                                <div>
                                    <div style="width: 100%;">
                                        <div>
                                            <!-- logo started -->
                                            <div class="logo"
                                                style="background: url(https://apimis.in/vaalve/public/assets/media/logos/vaalve-invoice-image-1.jpg);   width: 100%;  
                                                    padding: 5px 0px 5px 0px;
                                                    background-size: cover;
                                                    height: auto;
                                                    margin-top: 10px;">
                                                <div>
                                                    <h1 style="text-align: center; color: #fff; font-size: 18px; margin: 0px; padding: 0px;">
                                                        Performa Invoice</h1>
                                                    <p
                                                        style="text-align: center; color: #fff; font-size: 14px; padding: 0px;">
                                                        [Section 31 of GST Act 2017 read with GST Rules,2017]<br>
                                                        Goods & Service</p>
                                                </div>
                                            </div>
                                            <!-- logo ended -->
                                        </div>
                                    </div>
                                    <div class="" style="width: 50%; float: left; margin-top: 10px;">
                                        <div>
                                            <div>
                                                <h2 style="font-size: 16px; color: #333; margin: 0px; padding: 0px;">
                                                    VAALVE BATHWARE INDIA LIMITED</h2>
                                                <p style="font-size: 12px; color: #333; margin: 0px; padding: 0px;">
                                                    <strong> No. U28994DL2021PLC384082</strong>
                                                </p>
                                                <p style="font-size: 12px; color: #333; margin: 0px; padding: 0px;">
                                                    Address: 63, Prakash Industrial Estate, Sahibabad,<br>
                                                    Ghaziabad, Uttar Pradesh - 201005</p>

                                            </div>
                                        </div>
                                    </div>
                                    <div style="width: 50%; float: left; margin-top: 10px;">
                                        <div>
                                            <img
                                                src="{{ asset('pdfimage/Vaalve-Logo-New-Blue-1024x235.png') }}"
                                                style="width: 200px; float: right;">
                                            </div>
                                    </div>
                                    <div class="clear" style="clear: both; width: 100%; height: 1px;"></div>


                                    <div
                                        style="width: 100%; margin-top: 10px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td>GSTIN/UIN: 09AAICV1817B1ZI </td>
                                                <td>PAN No.: AAICV1817B</td>
                                                <td>Tel No.: 18001209954</td>
                                                <td>Email Id: accounts@vaalve.in</td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <div>
                                <div class="row">
                                    <div style="width:80%;float: left;margin-top:10px;">
                                        <div>


                                            <p style="font-size: 12px; color: #333;">
                                                Customer P.O./Ref. No :<br>
                                                Vehicle No./LR No. :<br>
                                                @php
                                                $transport = getmastermenudatabyid($orderdata['transportId_fk']);
                                            @endphp
                                                Name Of Transporter : {{ $transport->name }}<br>
                                                Order No. : {{ $orderdata['orderNo'] }}<br>
                                                Date : {{ date('d-M-Y', $orderdata['orderDate']) }}<br>
                                                Sales Person Name : {{ salesuserdata($orderdata['sales_person_id']) }}<br>
                                                Mode/Terms of Payment : {{ $customerinfo['creditPeriod'] }} Days<br>
                                            </p>

                                        </div>
                                    </div>

                                    <div style='width:20%;float: right;margin-top:10px;'>
                                        <p style="font-size: 12px; color: #333;"><strong>Date</strong> {{ date('d-M-Y') }} </p>
                                    </div>



                                </div>
                            </div>
                            <div class="clear" style="clear: both; width: 100%; height: 1px; margin-bottom: 10px;">
                            </div>
                            <div
                                style="clear: both; width: 100%; height: 1px; background: #333; height: 1px; margin-bottom: 15px;">
                            </div>

                            <div>
                                <div class="row">
                                    <div style="width: 50%; float: left;">
                                        <div>


                                            <p style="font-size: 12px; color: #333;">
                                                <strong>Details of Receiver(Billed to)</strong> <br>
                                                Name: {{ $customerinfo['CustomerName'] }} <br>
                                                Address: {{ $customerinfo['address'] }}<br>
                                                @php
                                                    $state = getlocationdatabyid($customerinfo['state']);
                                                @endphp
                                                State: {{ $state['cityName'] ?? '' }} <br>
                                                Pincode:{{ $customerinfo['pincode'] ?? '' }}<br>
                                                GSTIN: {{ $customerinfo['gstCertificate'] ?? '' }}<br>
                                                Tel No.: {{ $customerinfo['mobileNo'] ?? '' }}<br>
                                                Email ID: {{ $customerinfo['email_id'] }}
                                            </p>

                                        </div>
                                    </div>
                                    <div style="width: 50%; float: right;">
                                        <div>
                                            <div>

                                                <p style="font-size: 12px; color: #333;">
                                                    <strong> Details of Consignee (Shipped To)</strong><br>
                                                    Name: {{ $orderdata['retailer_project_name'] }} <br>
                                                    Address: {{ $orderdata['shppingAddress'] }}<br>
                                                  
                                                    GSTIN: {{ $customerinfo['gstCertificate'] }}<br>
                                                    Tel No.:{{ $customerinfo['mobileNo'] }}<br>
                                                    Email ID: {{ $customerinfo['email_id'] }}<br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear" style="clear: both; width: 100%; height: 1px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="width: 100%; margin-top: 15px;">
                                    <table style="width: 100%;" cellspacing="0" cellpadding="0">
                                        <thead class=" " style="background: #0e2952; color: #fff !important;">
                                            <tr class="tr">
                                                <th style="padding: 4px; font-size: 12px; text-align: center;border: 1px solid #0e2952;width:30px!important">S.No.</th>
                                                <th style="padding: 4px; font-size: 12px; text-align: center;border: 1px solid #0e2952;width:60px!important">Image
                                                </th>
                                                <th style="padding: 4px; font-size: 12px; text-align: center;border: 1px solid #0e2952;width:80px!important">Series
                                                </th>
                                                <th style="padding: 4px; font-size: 12px; text-align: center;border: 1px solid #0e2952; width:50px!important">CAT Code
                                                </th>
                                                <th style="padding: 4px; font-size: 12px; text-align: center; border: 1px solid #0e2952; width:180px!important">
                                                    Item Name</th>

                                                <th style="padding: 4px; font-size: 12px; text-align: center;border: 1px solid #0e2952;width:50px!important">Qty</th>
                                                <th style="padding: 4px; font-size: 12px; text-align: center;border: 1px solid #0e2952;width:50px!important">Price
                                                </th>

                                                <th style="padding: 4px; font-size: 12px; text-align: center;border: 1px solid #0e2952;width:50px!important">Value
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderItems as $key => $item)

                                            @php
                                          
                                                if($item->pcsRate == 0){
                                                    $htmlspan = '<span style="background-color: #50cd89;padding:3px;font-size:12px;color:#fff;width:100px;">In Scheme</span>';
                                                }else{
                                                    $htmlspan = '';
                                                }
                                                
                                            @endphp
                                            
                                                <tr class="tr">
                                                    <td
                                                        style="font-size: 12px; color: #333; padding: 4px; border-left:1px solid #000; border-right: 0.5 solid #000; border-bottom: 0.5 solid #000;  border-top: 0.5 solid #000;  text-align:center;width:30px!important;height:69px;">
                                                        {{ $key + 1 }} </td>
                                                    <td style="font-size: 12px; color: #333; padding: 4px; border-right: 0.5 solid #000; border-bottom: 0.5 solid #000; border-left: none;width:60px!important;height:69px;">

                                                        @if ($item['productitem']['productImage'] != null)
                                                            <img src="{{ asset('images/' . $item['productitem']['productImage']) }}"
                                                                alt="Product Image" width="60">
                                                        @endif
                                                         
                                                   
                                                    </td>

                                                    @php
                                                        $seriesdata = getmastermenudatabyid($item['productitem']['subCategoryId_fk']);
                                                    @endphp

                                                    <td style="font-size: 12px; color: #333; padding: 4px;  border-right: 0.5 solid #000; border-bottom: 0.5 solid #000;width:80px!important; height:69px;">
                                                        {{$seriesdata['name'] }}    </td>


                                                    <td
                                                        style="font-size: 12px; color: #333; padding: 4px;  border-right: 0.5 solid #000; border-bottom: 0.5 solid #000; width:50px!important;height:69px;">
                                                        {{ $item['productitem']['cat_number'] }}</td>
                                                    <td
                                                        style="font-size: 12px; color: #333; padding: 4px; border-right: 0.5 solid #000; border-bottom: 0.5 solid #000; width:180px!important;height:69px;">

                                                        @if ($item['productitem']['productName'] != null)
                                                            {{ $item['productitem']['productName'] }} <br> {!!$htmlspan !!}
                                                        @else
                                                            NA
                                                        @endif

                                                    </td>

                                                    <td
                                                        style="font-size: 12px; color: #333; padding: 4px; border-right: 0.5 solid #000; border-bottom: 0.5 solid #000; text-align:right;width:50px!important;height:69px;">
                                                        {{ $item->qty }} Pcs.</td>
                                                    <td
                                                        style="font-size: 12px; color: #333; padding: 4px; border-right: 0.5 solid #000; border-bottom: 0.5 solid #000; text-align:right; width:50px!important;height:69px;">

                                                        @if($item['productitem']['netrate'] != '')

                                                        {{   number_format($item['productitem']['netrate'], 2, '.', ',') }} <span style="color:red;">*</span>

                                                        @else
                                                        {{   number_format($item->pcsRate, 2, '.', ',') }}
                                                        @endif
                                                     
                                                    </td>

                                                    <td
                                                        style="font-size: 12px; color: #333; padding: 4px;  border-right: 0.5 solid #000; border-bottom: 0.5 solid #000; text-align:right;width:50px!important;height:69px;">
                                                        {{ number_format($item->totalAmt, 2, '.', ',') }} </td>
                                                </tr>
                                            @endforeach

                                         
                                        </tbody>
                                    </table>
                                </div>

                                <div class="clear" style="clear: both; width: 100%; height: 1px;"></div>

                                <div style="margin-top: 40px;">

                                    <table style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr class="tr">
                                                <td style="width: 32%;  padding: 4px; font-size: 12px;">
                                                    <p> Company’s Bank Details </p>
                                                    <p> Bank Name: </p>
                                                    <p> A/c No. : > </p>
                                                    <p> IFSC Code:</p>
                                                </td>

                                                {{-- <td style="width: 32%; padding: 4px; font-size: 12px;">
                                                    <div class="topbox">
                                                        <div style="width: 50%; float: left;">
                                                            <p>Over Due Days</p>
                                                        </div>
                                                        <div style="width: 50%; float: right;">
                                                            <p>Overdue Amount</p>
                                                        </div>
                                                        <div class="clear"
                                                            style="clear: both; width: 100%; height: 2px; background: #000;">
                                                        </div>

                                                        <div style="width: 50%; float: left;">
                                                            <p>(< 60 days ) </p>
                                                                    <p>(> 60 days )</p>
                                                        </div>
                                                        <div style="width: 50%; float: right;">
                                                            <p>25,00,829.23</p>
                                                            <p>12,16,912.64</p>
                                                        </div>

                                                        <div class="clear"
                                                            style="clear: both; width: 100%; height: 1px; background: #000; margin-top: 40px;">
                                                        </div>
                                                        <div style="width: 50%; float: left;">
                                                            <p style="font-size: 15px;"><strong> Total</strong></p>
                                                        </div>
                                                        <div style="width: 50%; float: right;">
                                                            <p style="font-size: 15px;" class="text-right">
                                                                <strong>37,17,741.87</strong>
                                                            </p>
                                                        </div>

                                                        <div class="clear"
                                                            style="clear: both; width: 100%; height: 1px; "></div>
                                                    </div>

                                                </td> --}}

                                                <td style="width: 36%;  padding: 4px; font-size: 12px;">
                                                    <div class="topbox">

                                                     <div class="clear"
                                                            style="clear: both; width: 100%; height: 1px;"></div>
                                                        <div style="width: 50%; float: left;">
                                                            <p class="text-left">Total Qty</p>
                                                        </div>
                                                        <div style="width: 50%; float: right;">
                                                            <p class="text-right"> {{ $orderdata->quantity }}</p>
                                                        </div>


                                                        <div class="clear"
                                                            style="clear: both; width: 100%; height: 1px;"></div>
                                                        <div style="width: 50%; float: left;">
                                                            <p class="text-left">Sub Total</p>
                                                        </div>
                                                        <div style="width: 50%; float: right;">
                                                            <p class="text-right"> {{ moneyFormatIndia($orderdata->totalAmt) }}</p>
                                                        </div>
                                                        <div class="clear"
                                                            style="clear: both; width: 100%; height: 1px;"></div>
                                                        <div style="width: 50%; float: left;">
                                                            <p class="text-left">Distributor Discount (-){{ $orderdata->enterDiscount }} %  </p>
                                                        </div>
                                                        <div style="width: 50%; float: right;">
                                                            <p class="text-right">{{  moneyFormatIndia($orderdata->discountAmt) }}</p>
                                                        </div>
                                                       
                                                        <div class="clear"
                                                            style="clear: both; width: 100%; height: 1px;"></div>
                                                        <div style="width: 50%; float: left;">
                                                            <p class="text-left">IGST@18% </p>
                                                        </div>
                                                        <div style="width: 50%; float: right;">
                                                            <p class="text-right">{{ moneyFormatIndia($orderdata->taxAmt)  }}</p>
                                                        </div>
                                                        
                                                        <div class="clear"
                                                            style="clear: both; width: 100%; height: 1px;"></div>
                                                        <div style="width: 50%; float: left;">
                                                            <p class="text-left"> Rounded Off </p>
                                                        </div>
                                                        @php
                                                        
                                                           $totlRoundof = round($orderdata->grandAmt) - $orderdata->grandAmt;
                                                              $afterDecimal = $orderdata->grandAmt - floor($orderdata->grandAmt);
                                                        @endphp
                                                        <div style="width: 50%; float: right;">
                                                            @if($afterDecimal > 0.5)
                                                                  <p class="text-right"> {{ number_format(abs($totlRoundof),2) }} </p>
                                                           @else
                                                                 <p class="text-right"> - {{ number_format(abs($totlRoundof),2) }}</p>
                                                           @endif
                                           
                                                          
                                                        </div>
                                                        
                                                        
                                                        <div class="clear"
                                                            style="clear: both; width: 100%; height: 1px;"></div>
                                                        <div style="width: 50%; float: left;">
                                                            <p class="text-left">Total Invoice Amount</p>
                                                        </div>
                                                        <div style="width: 50%; float: right;">
                                                            <p class="text-right"> {{ moneyFormatIndia(round($orderdata->grandAmt)) }}</p>
                                                        </div>
                                                        <div class="clear"
                                                            style="clear: both; width: 100%; height: 1px;"></div>
                                                    </div>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div style="margin-top:20px;">
                                <div class="row">
                                    <div style="width: 50%; float: left;">
                                        <div class="invoice-number mb-30">
                                            <p style="font-size: 12px; color: #333;">
                                                Amount Payable in Words: INR {{ numberToWords(round($orderdata->grandAmt))}} Only<br>
                                                Amount of Tax Payable in Words: INR {{ numberToWords(round($orderdata->taxAmt))}} Only

                                            </p>
                                        </div>
                                    </div>
                                    <div style="width: 50%; float: right; text-align:right; padding:20px;">
                                        <div class="invoice-number mb-30">
                                            <div class="invoice-number-inner">

                                                <p style="font-size: 12px; color: #333;">
                                                    For VAALVE BATHWARE INDIA LIMITED<br><br>
                                                    Authorised Signatory
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear" style="clear: both; width: 100%; height: 1px;"></div>

                            <div class="invoice-bottom">
                                <div class="row">
                                    <div style="width: 100%;">
                                        <div class="foot-img">
                                            <img src="{{ asset('pdfimage/foot-img-min.jpg')}}"  style="width: 100%; height: auto;">
                                            </div>
                                    </div>

                                    <p style="font-size: 12px; color: #333; text-align:center">This is a Computer Generated Invoice</p>
                                </div>
                            </div>
                            <div class="clear" style="clear: both; width: 100%; height: 1px;"></div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice 2 end -->


</body>

</html>
