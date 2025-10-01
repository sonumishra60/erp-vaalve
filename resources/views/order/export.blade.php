<!-- resources/views/exports/orders.blade.php -->
<table>
    <thead>
        <tr>
            <th>Order No</th>
            <th>Customer ID</th>
            <th>Order Date</th>
            <th>CAT Code</th>
            <th>Item Name</th>
            <th>Qty</th>
            <th>MRP</th>
            {{-- <th>Total</th>
            <th>Sub Amount</th>
            <th>Discount</th>
            <th>GST Amount</th>
            <th> Total Amount</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->orderNo }}</td>

                @php
                $customername = getcustomerdatabyid($order->customerId_fk)

                @endphp
                <td>{{ $customername ? $customername->CustomerName : '' }}</td>
                <td>{{ date('d-M-Y', $order->orderDate) }}</td>
               
                <td>{{ $order->cat_number }}</td>
                <td>{{ $order->productName }}</td>
                <td>{{ $order->qty }}</td>
                <td>{{ $order->pcsRate }}</td>
                {{-- <td>{{ $order->rateinto }}</td>
                <td>{{ $order->totalAmt }}</td>
                <td>{{ $order->discountAmt }}</td>
                <td>{{ $order->taxAmt }}</td>
                <td>{{ $order->grandAmt }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
