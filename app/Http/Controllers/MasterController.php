<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\masterdata;
use App\Models\mstlocation;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class MasterController extends BaseController
{
    //
    public function index(){
        return view('master.masterform');
    }

    public function masterformsubmit(Request $req){
      
        $currentDateTime = now();
        $masterdataname = $req->masterdataname;
        $levelname = $req->levelname;
        $masterAuthKey  = sha1($masterdataname.''.$currentDateTime->toDateTimeString());
        
        $groupNamedata =  MasterData::where('status',1)
                                ->orderBy('masterDataId', 'desc')
                                ->limit(1)->first();

            if($groupNamedata){
                $groupName =  $groupNamedata->groupName + 1;
            }else{
                $groupName = 1;
            }

       //  dd($groupName);
            $data = [
                'fieldName' => $masterdataname,
                'levelName' => $levelname,
                'masterAuthKey' => $masterAuthKey,
                'groupName' => $groupName,
                'dataType' => 0,
                'displaymage' => 0,
                'status' => 1
            ];

        $masterdata = masterdata::create($data);

        if($masterdata){
            $msg = 'Data Insert Successfully';
            $resp = 1;
        }else{
            $msg = 'Data Not Insert Successfully';
            $resp = 2;
        }

        return response()->json(['resp' => $resp,'msg' => $msg]);

    }


    public function getmasterdata(){
        $MasterData =  MasterData::where('status',1)
        ->orderBy('masterDataId', 'desc')
        ->get();

        if($MasterData){
            $data = $MasterData;
            $resp = 1;
        }else{
            $data = '';
            $resp = 2;
        }

        return response()->json(['resp' => $resp,'data' => $data]);

    }


    public function locationadd(){

        return view('location.addlocation');
    }


    public function locationsubmit(request $req){

      $currentDateTime = now();
      $location = $req->location;
      $cityAuth  = sha1($location.''.$currentDateTime->toDateTimeString());
      $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
      $parentId  = $req->statename;
   
      $data = [
        'parentId' => $parentId,
        'cityName' => $location,
        'dataEntryDate' => $dataEntrydate,
        'cityAuth'=>$cityAuth,
        'status'=>1,
    ];

    $mstlocation = mstlocation::create($data);

    if($mstlocation){
        $msg = 'Data Insert Successfully';
        $resp = 1;
    }else{
        $msg = 'Data Not Insert Successfully';
        $resp = 2;
    }

    return response()->json(['resp' => $resp,'msg' => $msg]);


    }






}
