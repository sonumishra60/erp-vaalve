<!-- resources/views/exports/orders.blade.php -->
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Employee Name</th>
            <th>Employee State</th>
            <th>Customer Code</th>
            <th>Schedule Customer Name</th>
            <th>Retailor Name</th>
            <th>City</th>
            <th>Schedule Call</th>
            <th>CheckIn</th>
            <th>CheckOut</th>
            <th>Timespent</th>
            <th>Activities</th>
        </tr>
    </thead>
    <tbody>


        @foreach ($users as $user)
            <tr>
                <td>{{ $user['Date'] }}</td>
                <td>{{ $user['name'] }}</td>
                <td>{{ $user['state'] }}</td>
                <td>{{ $user['dist_code'] }}</td>
                <td>{{ $user['CustomerName'] }}</td>
                <td>{{ $user['projectname'] }}</td>
                <td>{{ $user['city'] }}</td>
                <td></td>
                <td>{{ $user['checkInDate'] }}</td>
                <td>{{ $user['checkOutDate'] }}</td>
                <td>{{ $user['time_spent'] }}</td>
                <td></td>
            </tr>
        @endforeach


       

    </tbody>
</table>
