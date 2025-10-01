<!-- resources/views/exports/orders.blade.php -->
<table>
    <thead>
        <tr>
            <th>Attendance Date</th>
            <th>Day</th>
            {{-- <th>Region</th> --}}
            <th>State</th>
            <th>First Name</th>
            <th>Reporting Manager</th>
            <th>Reporting Manager Code</th>
            <th>Designation Doer</th>
            <th>Employee Code</th>
            <th>Employee Email</th>
            <th>Employee Phone</th>
            <th>Type</th>
            <th>Start Time/Check in home</th>
            <th>End Time/Check Out home</th>
            <th>First Visit</th>
            <th>Last Visit</th>
            <th>Total Visits</th>
            <th>FIRST N LAST VISIT DIFF</th>
            <th>Visit Time In Minutes</th>
            <th>Login Address</th>
            <th>Logout Address</th>
            <th>Distance travelled</th>
            <th>Reporting</th>
            <th>Late</th>
        </tr>
    </thead>
    <tbody>


        @foreach ($users as $user)
            <tr>
                <td>{{ date('d-m-Y', $user->jobStartDate) }}</td>
                <td>{{ date('l', $user->jobStartDate) }}</td>
                {{-- <td>{{ $user->region }}</td> --}}
                <td>{{ $user->state }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->reporting_manager }}</td>
                <td>{{ $user->reporting_manager_code }} </td>
                <td>{{ $user->designation_doer }}</td>
                <td>{{ $user->emp_code }}</td>
                <td>{{ $user->emailAddress }}</td>
                <td>{{ $user->mobileNumber }}</td>
                <td>PRESENT</td>
                <td>{{ date('d-m-Y h:i:s  A', $user->jobStartDate) }}</td>
                <td>{{ date('d-m-Y h:i:s  A', $user->jobExistDate) }}</td>
                <td>{{ $user->first_visit }}</td>
                <td>{{ $user->last_visit }}</td>
                <td>{{ $user->totalvisits }}</td>
                <td>{{ $user->first_n_last_visit_diff_h }}</td>
                <td>{{ $user->first_n_last_visit_diff_i }}</td>
                <td>{{ $user->checkInLocationArea }}</td>
                <td>{{ $user->checkOutLocationArea }}</td>
                <td>{{ $user->distancetravelled }}</td>
                <td>{{ $user->reporting }}</td>
                <td>{{ $user->late }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
