<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\masterdata;
use App\Models\mastermenu;
use App\Models\mst_inventory;
use App\Models\mst_ledger;
use Illuminate\Support\Facades\Log;

class MastermenuController extends BaseController
{
    //
    public function index()
    {
        return view('master.mastermenuform');
    }

    public function seriesform()
    {
        return view('master.seriersadd');
    }



    public function masterledger()
    {
        $mst_ledger = mst_ledger::orderby('datetime', 'desc')->first();

        return view('master.ledgerlist', compact('mst_ledger'));
    }


    public function ledgerlistdata(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        $mst_ledger = mst_ledger::orderby('datetime', 'desc')->paginate($rowCount, ['*'], 'page', $page);


        $data = [];
        foreach ($mst_ledger as $key => $val) {

            $ledger = json_decode($val->jsondata);

            $entry = [
                'Ledger_Name' => ($ledger->Ledger_Name ?? '') === "Null" ? '' : $ledger->Ledger_Name,
                'Ledger_Group' => ($ledger->Ledger_Group ?? '') === "Null" ? '' : $ledger->Ledger_Group,
                'Address' => ($ledger->Address ?? '') === "Null" ? '' : $ledger->Address,
                'State' => ($ledger->State ?? '') === "Null" ? '' : $ledger->State,
                'Country' => ($ledger->Country ?? '') === "Null" ? '' : $ledger->Country,
                'Pincode' => ($ledger->Pincode ?? '') === "Null" ? '' : $ledger->Pincode,
                'PAN' => ($ledger->PAN ?? '') === "Null" ? '' : $ledger->PAN,
                'GSTIN' => ($ledger->GSTIN ?? '') === "Null" ? '' : $ledger->GSTIN,
                'Opening_Balance' => ($ledger->Opening_Balance ?? '') === "Null" ? '' : $ledger->Opening_Balance,
                'Closing_Balance' => ($ledger->Closing_Balance ?? '') === "Null" ? '' : $ledger->Closing_Balance,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mst_ledger->currentPage(),
            'last_page' => $mst_ledger->lastPage()
        ];


        return response()->json($response);
    }

    public function masterledgersearch(Request $req)
    {
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $ledger_name = $req->input('ledger_name');
        $ledger_group = $req->input('ledger_group');
        $address = $req->input('address');
        $State = $req->input('State');
        $Country = $req->input('Country');
        $Pincode = $req->input('Pincode');
        $PAN = $req->input('PAN');
        $GSTIN = $req->input('GSTIN');
        $opening_balance = $req->input('opening_balance');
        $closing_balance = $req->input('closing_balance');

        $query = mst_ledger::select('jsondata');

        if (!empty($ledger_name)) {
            $query->where('jsondata->Ledger_Name', 'like', '%' . $ledger_name . '%');
        }

        if (!empty($ledger_group)) {
            $query->where('jsondata->Ledger_Group', 'like', '%' . $ledger_group . '%');
        }

        if (!empty($address)) {
            $query->where('jsondata->Address', 'like', '%' . $address . '%');
        }

        if (!empty($State)) {
            $query->where('jsondata->State', 'like', '%' . $State . '%');
        }

        if (!empty($Country)) {
            $query->where('jsondata->Country', 'like', '%' . $Country . '%');
        }

        if (!empty($Pincode)) {
            $query->where('jsondata->Pincode', 'like', '%' . $Pincode . '%');
        }

        if (!empty($PAN)) {
            $query->where('jsondata->PAN', 'like', '%' . $PAN . '%');
        }

        if (!empty($GSTIN)) {
            $query->where('jsondata->GSTIN', 'like', '%' . $GSTIN . '%');
        }

        if (!empty($opening_balance)) {
            $query->where('jsondata->Opening_Balance', 'like', '%' . $opening_balance . '%');
        }

        if (!empty($closing_balance)) {
            $query->where('jsondata->Closing_Balance', 'like', '%' . $closing_balance . '%');
        }

        // Sorting by userId and paginating
        $query->orderBy('datetime', 'desc');
        $mst_ledger = $query->paginate($rowCount, ['*'], 'page', $page);

        $data = [];
        foreach ($mst_ledger as $key => $val) {

            $ledger = json_decode($val->jsondata);

            $entry = [
                'Ledger_Name' => ($ledger->Ledger_Name ?? '') === "Null" ? '' : $ledger->Ledger_Name,
                'Ledger_Group' => ($ledger->Ledger_Group ?? '') === "Null" ? '' : $ledger->Ledger_Group,
                'Address' => ($ledger->Address ?? '') === "Null" ? '' : $ledger->Address,
                'State' => ($ledger->State ?? '') === "Null" ? '' : $ledger->State,
                'Country' => ($ledger->Country ?? '') === "Null" ? '' : $ledger->Country,
                'Pincode' => ($ledger->Pincode ?? '') === "Null" ? '' : $ledger->Pincode,
                'PAN' => ($ledger->PAN ?? '') === "Null" ? '' : $ledger->PAN,
                'GSTIN' => ($ledger->GSTIN ?? '') === "Null" ? '' : $ledger->GSTIN,
                'Opening_Balance' => ($ledger->Opening_Balance ?? '') === "Null" ? '' : $ledger->Opening_Balance,
                'Closing_Balance' => ($ledger->Closing_Balance ?? '') === "Null" ? '' : $ledger->Closing_Balance,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mst_ledger->currentPage(),
            'last_page' => $mst_ledger->lastPage()
        ];


        return response()->json($response);
    }


    public function masterinventory()
    {

        $mst_inventory = mst_inventory::orderby('datetime', 'desc')->first();

        return view('master.inventorylist', compact('mst_inventory'));
    }



    public function inventorylistdata(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');


        $mst_inventory = mst_inventory::orderby('datetime', 'desc')->paginate($rowCount, ['*'], 'page', $page);


        $data = [];
        foreach ($mst_inventory as $key => $val) {

            $inventory = json_decode($val->jsondata);

            $entry = [
                'Name' => ($inventory->Name ?? '') === "Null" ? '' : $inventory->Name,
                'Group' => ($inventory->Group ?? '') === "Null" ? '' : $inventory->Group,
                'Category' => ($inventory->Category ?? '') === "Null" ? '' : $inventory->Category,
                'Units' => ($inventory->Units ?? '') === "Null" ? '' : $inventory->Units,
                'PartNo' => ($inventory->PartNo ?? '') === "Null" ? '' : $inventory->PartNo,
                // 'Alias' => ($inventory->Alias ?? '') === "Null" ? '' : $inventory->Alias,
                // 'Op_Qty' => ($inventory->Op_Qty ?? '') === "Null" ? '' : $inventory->Op_Qty,
                // 'Op_Rate' => ($inventory->Op_Rate ?? '') === "Null" ? '' : $inventory->Op_Rate,
                // 'Op_Amount' => ($inventory->Op_Amount ?? '') === "Null" ? '' : $inventory->Op_Amount,
                'Cl_Qty' => ($inventory->Cl_Qty ?? '') === "Null" ? '' : str_replace(' Pcs','',$inventory->Cl_Qty),
                'Cl_Rate' => ($inventory->Cl_Rate ?? '') === "Null" ? '' : $inventory->Cl_Rate,
                'Cl_Amount' => ($inventory->Cl_Amount ?? '') === "Null" ? '' : $inventory->Cl_Amount,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mst_inventory->currentPage(),
            'last_page' => $mst_inventory->lastPage()
        ];


        return response()->json($response);
    }

    public function masterinventorysearch(Request $req){

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $name = $req->input('name');
        $Group = $req->input('Group');
        $Category = $req->input('Category');
        $Units = $req->input('Units');
        $PartNo = $req->input('PartNo');
        // $Alias = $req->input('Alias');
        // $Op_Qty = $req->input('Op_Qty');
        // $Op_Rate = $req->input('Op_Rate');
        // $Op_Amount = $req->input('Op_Amount');
        $Cl_Qty = $req->input('Cl_Qty');
        $Cl_Rate = $req->input('Cl_Rate');
        $Cl_Amount = $req->input('Cl_Amount');


        $query = mst_inventory::orderby('datetime', 'desc');

        if (!empty($name)) {
            $query->where('jsondata->Name', 'like', '%' . $name . '%');
        }

        if (!empty($Group)) {
            $query->where('jsondata->Group', 'like', '%' . $Group . '%');
        }

        if (!empty($Category)) {
            $query->where('jsondata->Category', 'like', '%' . $Category . '%');
        }

        if (!empty($Units)) {
            $query->where('jsondata->Units', 'like', '%' . $Units . '%');
        }

        if (!empty($PartNo)) {
            $query->where('jsondata->PartNo', 'like', '%' . $PartNo . '%');
        }
        
        // if (!empty($Alias)) {
        //     $query->where('jsondata->Alias', 'like', '%' . $Alias . '%');
        // }
        // if (!empty($Op_Qty)) {
        //     $query->where('jsondata->Op_Qty', 'like', '%' . $Op_Qty . '%');
        // }
        // if (!empty($Op_Rate)) {
        //     $query->where('jsondata->Op_Rate', 'like', '%' . $Op_Rate . '%');
        // }

        // if (!empty($Op_Amount)) {
        //     $query->where('jsondata->Op_Amount', 'like', '%' . $Op_Amount . '%');
        // }
        if (!empty($Cl_Qty)) {
            $query->where('jsondata->Cl_Qty', 'like', '%' . $Cl_Qty . '%');
        }

        if (!empty($Cl_Rate)) {
            $query->where('jsondata->Cl_Rate', 'like', '%' . $Cl_Rate . '%');
        }

        if (!empty($Cl_Amount)) {
            $query->where('jsondata->Cl_Amount', 'like', '%' . $Cl_Amount . '%');
        }
        
        
        $mst_inventory = $query->paginate($rowCount, ['*'], 'page', $page);
   


        $data = [];
        foreach ($mst_inventory as $key => $val) {

            $inventory = json_decode($val->jsondata);

            $entry = [
                'Name' => ($inventory->Name ?? '') === "Null" ? '' : $inventory->Name,
                'Group' => ($inventory->Group ?? '') === "Null" ? '' : $inventory->Group,
                'Category' => ($inventory->Category ?? '') === "Null" ? '' : $inventory->Category,
                'Units' => ($inventory->Units ?? '') === "Null" ? '' : $inventory->Units,
                'PartNo' => ($inventory->PartNo ?? '') === "Null" ? '' : $inventory->PartNo,
                // 'Alias' => ($inventory->Alias ?? '') === "Null" ? '' : $inventory->Alias,
                // 'Op_Qty' => ($inventory->Op_Qty ?? '') === "Null" ? '' : $inventory->Op_Qty,
                // 'Op_Rate' => ($inventory->Op_Rate ?? '') === "Null" ? '' : $inventory->Op_Rate,
                // 'Op_Amount' => ($inventory->Op_Amount ?? '') === "Null" ? '' : $inventory->Op_Amount,
                'Cl_Qty' => ($inventory->Cl_Qty ?? '') === "Null" ? '' : str_replace(' Pcs','',$inventory->Cl_Qty),
                'Cl_Rate' => ($inventory->Cl_Rate ?? '') === "Null" ? '' : $inventory->Cl_Rate,
                'Cl_Amount' => ($inventory->Cl_Amount ?? '') === "Null" ? '' : $inventory->Cl_Amount,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mst_inventory->currentPage(),
            'last_page' => $mst_inventory->lastPage()
        ];


        return response()->json($response);


        
    }


    public function mastermenuformsubmit(Request $req)
    {

        //  dd($req);

        $currentDateTime = now();
        $mainmenudata = $req->mainmenudata;
        $bannerImages = '';

        $masterDataId_fk = $req->masterdata;
        $name = $req->mastermenuname;
        $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
        $accessAuthKey  = sha1($name . '' . $currentDateTime->toDateTimeString());

        $accessUrl = $req->has('url') ? $req->url : '';


        $checkmasterdata = mastermenu::where('masterDataId_fk', $masterDataId_fk)->where('name', $name)->where('status', 1)->first();

        //dd($checkmasterdata);

        if ($checkmasterdata) {


            return response()->json(['resp' => 2, 'msg' => 'Data All Ready Insert']);
        }

        if (!empty($mainmenudata)) {
            $parentId = $mainmenudata;

            if ($req->hasFile('mastermenuimage')) {
                $bannerImages = time() . '.' . $req->mastermenuimage->getClientOriginalExtension();
                $req->mastermenuimage->move(public_path('images'), $bannerImages);
            }
        } else {
            $parentId = null;
        }


        //dd($accessUrl);

        $data = [
            'parentId' => $parentId,
            'name' => $name,
            'masterDataId_fk' => $masterDataId_fk,
            'bannerImages' => $bannerImages,
            'dataEntrydate' => $dataEntrydate,
            'accessAuthKey' => $accessAuthKey,
            'accessUrl' => $accessUrl,
            'status' => 1,
        ];

        $mastermenu = mastermenu::create($data);

        $msg = $mastermenu ? 'Data Insert Successfully' : 'Data Not Insert Successfully';
        $resp = $mastermenu ? 1 : 2;

        return response()->json(['resp' => $resp, 'msg' => $msg]);
    }

    public function seriesformsubmit(Request $req)
    {

        //  dd($req);

        $currentDateTime = now();
        $mainmenudata = $req->mainmenudata;
        $bannerImages = '';

        $masterDataId_fk = $req->masterdata;
        $name = $req->mastermenuname;
        $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
        $accessAuthKey  = sha1($name . '' . $currentDateTime->toDateTimeString());

        $accessUrl = $req->has('url') ? $req->url : '';


        $checkmasterdata = mastermenu::where('parentId', $masterDataId_fk)->where('name', $name)->where('status', 1)->first();

        //dd($checkmasterdata);

        if ($checkmasterdata) {


            return response()->json(['resp' => 2, 'msg' => 'Data All Ready Insert']);
        }




        //dd($accessUrl);

        $data = [
            'parentId' => $masterDataId_fk,
            'name' => $name,
            'masterDataId_fk' => 15,
            'dataEntrydate' => $dataEntrydate,
            'accessAuthKey' => $accessAuthKey,
            'accessUrl' => $accessUrl,
            'status' => 1,
        ];

        $mastermenu = mastermenu::create($data);

        $msg = $mastermenu ? 'Data Insert Successfully' : 'Data Not Insert Successfully';
        $resp = $mastermenu ? 1 : 2;

        return response()->json(['resp' => $resp, 'msg' => $msg]);
    }

    public function getmainmenu()
    {

        //dd($this->masterdata_appmenu[0]->masterDataId);
        $masterdata_appmenu = $this->masterdata_appmenu[0]->masterDataId;
        $mastermenu =  mastermenu::where('masterDataId_fk', $masterdata_appmenu)
            ->whereNull('parentId')
            ->orderBy('masterMenuId', 'desc')
            ->get();

        $resp = $mastermenu->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mastermenu]);
    }


    public function listdata(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $masterdata = $req->input('masterdata');

        $mastermenu  = mastermenu::select('masterMenuId', 'name', 'masterDataId_fk')->where('status', 1)->where('masterDataId_fk', $masterdata)->orderBy('masterMenuId', 'desc')
            ->paginate($rowCount, ['*'], 'page', $page);

        $data = [];
        foreach ($mastermenu as $key => $val) {

            $masterdata = getmasternndatabyid($val->masterDataId_fk);

            $entry = [
                'mastername' => $masterdata->levelName,
                'mastermenuname' => $val->name,
                'masterMenuId' => $val->masterMenuId,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mastermenu->currentPage(),
            'last_page' => $mastermenu->lastPage()
        ];


        return response()->json($response);
    }


    public function serieslistdata(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $masterdata = $req->input('masterdata');

        $mastermenu  = mastermenu::select('masterMenuId', 'name', 'masterDataId_fk')->where('status', 1)->where('parentId', $masterdata)->orderBy('masterMenuId', 'desc')
            ->paginate($rowCount, ['*'], 'page', $page);

        $data = [];
        foreach ($mastermenu as $key => $val) {

            $masterdata = getmasternndatabyid($val->masterDataId_fk);

            $entry = [
                'mastername' => $masterdata->levelName,
                'mastermenuname' => $val->name,
                'masterMenuId' => $val->masterMenuId,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mastermenu->currentPage(),
            'last_page' => $mastermenu->lastPage()
        ];


        return response()->json($response);
    }


    public function masterdelete($id)
    {
        try {
            // Debugging ID
            Log::info('Deleting master menu with ID: ' . $id);

            $masterMenuId = mastermenu::where('masterMenuId', $id)->update(['status' => 0]);

            // Debugging result
            Log::info('Update result: ' . $masterMenuId);

            if ($masterMenuId > 0) {
                return 1; // Update successful
            } else {
                return 'No rows were updated';
            }
        } catch (\Exception $e) {
            Log::error('Error deleting master menu: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    }
}
