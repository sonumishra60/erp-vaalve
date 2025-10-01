<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserList;

class trans_customersalesperson extends Model
{
    use HasFactory;

    protected $table = 'trans_customersalesperson'; // Replace 'trans_cusbankinfo' with your actual table name
    protected $primaryKey = 'cusSalesPersonId'; 
    public $timestamps = false;

    // Define the fillable columns
    protected $fillable = [
        'cusSalesPersonId',
        'userId_fk',
        'customerId_fk',
        'joinDate',
        'exitDate',
        'assignSelesAuthKey',
        'status'
    ];



    public function salesdata()
    {
        return $this->hasOne(UserList::class, 'userId', 'userId_fk');
    }


}
