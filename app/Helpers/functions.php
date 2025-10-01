<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\mstcustomerlist;
use App\Models\mastermenu;
use App\Models\trans_cusbankinfo;
use App\Models\trans_cusdocument;
use App\Models\mstlocation;
use App\Models\masterdata;
use App\Models\trans_customersalesperson;
use NumberToWords\NumberToWords;
use App\Models\UserList;


define('MAIN_DISTRIBUTOR', '180');
define('MAIN_DEALER', '179');
define('MAIN_RETAILER', '327');
define('MAIN_UBS', '328');

if (!function_exists('getmasternndatabyid')) {
    function getmasternndatabyid($id){

      $masterdatabyid = masterdata::where('masterDataId',$id)->take('levelName')->first();

      return $masterdatabyid;
    }
}


if (!function_exists('getmasterdatabyid')) {
    function getlocationdatabyid($id){

      $masterdatabyid = mstlocation::where('cityId',$id)->take('cityId','cityName')->first();

      return $masterdatabyid;
    }
}


if (!function_exists('getmastermenudatabyid')) {
  function getmastermenudatabyid($id){
    $masterMenuId = mastermenu::where('masterMenuId',$id)->first();
    return $masterMenuId;
  }
}


if (!function_exists('getcustomerdatabyid')) {
  function getcustomerdatabyid($id){
    $customerdata = mstcustomerlist::where('customerId',$id)->first();
    return $customerdata;
  }
}


if (!function_exists('numberToWords')) {

  
function numberToWords($number){
    $words = array(
        '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
        '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
        '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen',
        '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
        '30' => 'thirty','40' => 'forty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
        '80' => 'eighty','90' => 'ninety');

    // Ensure $number is a string and contains only digits
    $number = (string) preg_replace('/[^0-9]/', '', $number);

    // First find the length of the number
    $number_length = strlen($number);
    // Initialize an empty array
    $number_array = array(0,0,0,0,0,0,0,0,0);
    $received_number_array = array();

    // Store all received numbers into an array
    for($i=0;$i<$number_length;$i++){
        $received_number_array[$i] = substr($number,$i,1);
    }

    // Populate the empty array with the numbers received - most critical operation
    for($i=9-$number_length,$j=0;$i<9;$i++,$j++){
        $number_array[$i] = $received_number_array[$j];
    }

    $number_to_words_string = "";
    // Finding out whether it is teen and then multiply by 10, example 17 is seventeen
    for($i=0,$j=1;$i<9;$i++,$j++){
        if($i==0 || $i==2 || $i==4 || $i==7){
            if($number_array[$j]==0 || $number_array[$i] == "1"){
                $number_array[$j] = intval($number_array[$i])*10+intval($number_array[$j]);
                $number_array[$i] = 0;
            }
        }
    }

    $value = "";
    for($i=0;$i<9;$i++){
        if($i==0 || $i==2 || $i==4 || $i==7){
            $value = intval($number_array[$i])*10;
        } else {
            $value = intval($number_array[$i]);
        }

        if($value != 0) { $number_to_words_string .= $words["$value"]." "; }
        if($i==1 && $value != 0){ $number_to_words_string .= "Crores "; }
        if($i==3 && $value != 0){ $number_to_words_string .= "Lakhs "; }
        if($i==5 && $value != 0){ $number_to_words_string .= "Thousand "; }
        if($i==6 && $value != 0){ $number_to_words_string .= "Hundred "; }
    }

    if($number_length > 9) {
        $number_to_words_string = "Sorry, this does not support more than 99 Crores";
    }

    return ucwords(strtolower($number_to_words_string));
}

}

if(!function_exists('salesuserdata')){

    function salesuserdata($salesid){
  
      $mst_user_list = UserList::select('name')->where('userId',$salesid)->first();
  
      return $mst_user_list->name;
  
    }
  
  }

  if (!function_exists('primarytarget')) {
    function primarytarget($sales_id, $mon, $year) {
        $primarytarget = DB::table('trans_salestarget')
            ->select(DB::raw("SUM(primaryTarget) as pamt"))
            ->where(function ($query) use ($sales_id) {
                // $query->where('areaHead_userId_fk', '=', $sales_id)
                //     ->orWhere('stateHead_userId_fk', '=', $sales_id)
                //     ->orWhere('nationalHead_userId_fk', '=', $sales_id)
                $query->Where('sales_userId_fk', '=', $sales_id);
            })
            ->where('monthNm', '=', $mon)
            ->where('yearNo', '=', $year)
            ->get();
  
            //dd();
        return $primarytarget[0]->pamt;
    }
  }

  if (!function_exists('primarytargetnew')) {
    function primarytargetnew($sales_id, $mon, $year) {
        $primarytarget = DB::table('trans_salestarget')
            ->select(DB::raw("SUM(primaryTarget) as pamt"))
            ->where(function ($query) use ($sales_id) {
                 $query->where('areaHead_userId_fk', '=', $sales_id)
                    ->orWhere('stateHead_userId_fk', '=', $sales_id)
                    ->orWhere('nationalHead_userId_fk', '=', $sales_id)
                    ->orWhere('sales_userId_fk', '=', $sales_id);
            })
            ->where('monthNm', '=', $mon)
            ->where('yearNo', '=', $year)
            ->get();
  
            //dd();
        return $primarytarget[0]->pamt;
    }
  }

  
  if (!function_exists('secondarytarget')) {
    function secondarytarget($sales_id, $mon, $year) {
        $secondarytarget = DB::table('trans_salestarget')
            ->select(DB::raw("SUM(secondaryTarget) as st"))
            ->where(function ($query) use ($sales_id) {
                // $query->where('areaHead_userId_fk', '=', $sales_id)
                //     ->orWhere('stateHead_userId_fk', '=', $sales_id)
                //     ->orWhere('nationalHead_userId_fk', '=', $sales_id)
                //     ->orWhere('sales_userId_fk', '=', $sales_id);
                $query->Where('sales_userId_fk', '=', $sales_id);
            })
            ->where('monthNm', '=', $mon)
            ->where('yearNo', '=', $year)
            ->get();
  
            
        return $secondarytarget[0]->st;
    }
  }
  


if (!function_exists('moneyFormatIndia')) {
    function moneyFormatIndia($amount1) {
        // Remove commas and convert to float
        $amount1 = floatval(str_replace(',', '', $amount1));
    
        // Format the number with two decimal places
        $formatted1 = number_format($amount1, 2, '.', '');
    
        // Apply Indian number formatting pattern
        $formatted1 = preg_replace('/(\d)(?=(\d\d)+\d\.)/', '$1,', $formatted1);
    
        return $formatted1;
    }
    
}

if(!function_exists('getSeniorUserIds')){

    function getSeniorUserIds($userId,$mon,$year)
    {
        // Check if the user ID exists in sales_userId_fk
        $seniorUserIds = DB::table('trans_salestarget')
            ->select('sales_userId_fk','areaHead_userId_fk', 'stateHead_userId_fk', 'nationalHead_userId_fk')
            ->where('sales_userId_fk', $userId)
            ->where('monthNm', '=', $mon)
            ->where('yearNo', '=', $year)
            ->first();
    
        // If not found, check in areaHead_userId_fk
        if (!$seniorUserIds) {
            $seniorUserIds = DB::table('trans_salestarget')
                ->select('areaHead_userId_fk','stateHead_userId_fk', 'nationalHead_userId_fk')
                ->where('areaHead_userId_fk', $userId)
                ->where('monthNm', '=', $mon)
                ->where('yearNo', '=', $year)
                ->first();
        }
    
        // If not found, check in stateHead_userId_fk
        if (!$seniorUserIds) {
            $seniorUserIds = DB::table('trans_salestarget')
                ->select('stateHead_userId_fk','nationalHead_userId_fk')
                ->where('stateHead_userId_fk', $userId)
                ->where('monthNm', '=', $mon)
                ->where('yearNo', '=', $year)
                ->first();
        }
    
         // If not found, check in stateHead_userId_fk
         if (!$seniorUserIds) {
          $seniorUserIds = DB::table('trans_salestarget')
              ->select('nationalHead_userId_fk')
              ->where('nationalHead_userId_fk', $userId)
              ->where('monthNm', '=', $mon)
              ->where('yearNo', '=', $year)
              ->first();
      }
    
    
        return $seniorUserIds;
    }
    
    }


    if (!function_exists('dividedbyhundred')) {
        function multiplebyhundred($amount1) {
            return $amount1 * 100;
        }
    }

    
if (!function_exists('dateString')) {
    function dateString($dateString) {
        if ($dateString instanceof DateTimeImmutable) {
            // If it's a DateTimeImmutable object, get the timestamp directly
            return $dateString->getTimestamp();
        } elseif (is_string($dateString)) {
            // If it's a string, first replace slashes with dashes and then convert to timestamp
            $formattedDate = str_replace('/', '-', $dateString);
            $timestamp = strtotime($formattedDate);
            return $timestamp;
        } else {
            // Handle cases where the input is neither a string nor a DateTimeImmutable
            throw new InvalidArgumentException("The date input must be a string or DateTimeImmutable.");
        }
    }
    
}
    

if (!function_exists('calculateDistance')) {
    function calculateDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
        // Convert degrees to radians
        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515; // Distance in miles
    
        // Convert miles to kilometers
        $distance = $miles * 1.609344;
        return $distance;
    }

    
}


?>