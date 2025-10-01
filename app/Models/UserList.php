<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserList extends Model
{
    use HasFactory;

    protected $table = 'mst_user_list';
    protected $primaryKey = 'userId';
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'userId',
        'emp_code',
        'role_type',
        'roleId_fk',
        'name',
        'password',
        'loginId',
        'state',
        'city',
        'address',
        'emailAddress',
        'profileImage',
        'mobileNumber',
        'alertnetNumber',
        'education',
        'joinDate',
        'degination',
        'dob',
        'doa',
        'aadhar_number',
        'pan_number',
        'aadhar_imageFront',
        'aadharBackImage',
        'pancardImage',
        'job_experience',
        'reporting_head',
        'exitDate',
        'userAuthKey',
        'staus'
    ];
   
}
