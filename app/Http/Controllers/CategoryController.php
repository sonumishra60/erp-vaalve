<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\masterdata;
use App\Models\mastermenu;

class CategoryController extends Controller
{

    public function index(){
        return view('category.categorylist');
    }

    public function listdata(Request $req){

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        $mastermenu = mastermenu::where('masterDataId_fk', 15)
                                ->whereNull('parentId')
                                ->where('status', 1)
                                ->orderBy('masterMenuId', 'asc')
                                ->paginate($rowCount, ['masterMenuId', 'name', 'accessAuthKey'], 'page', $page);

        return response()->json(['data' => $mastermenu]);
        
    }

    public function editsubmit(Request $req){

        $category_id  = $req->category_id;
        $categoryname = $req->categoryname;

        $mastermenuupdate =  mastermenu::where('masterMenuId',$category_id)->update(['name'=>$categoryname]);
        $msg = $mastermenuupdate ? 1 : 0;
        return $msg;

    }

    public function childlist($id){
        $mastermenuid = mastermenu::where('accessAuthKey',$id)->take('masterMenuId','accessAuthKey','name')->first();
        return view('category.childlist', compact('mastermenuid'));
    }

    public function childlistdata(Request $req){

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $checkauthkey = $req->input('checkauthkey');

        $checklistlogdata = mastermenu::where('parentId',$checkauthkey)
                                ->where('status', 1)
                                ->orderby('masterMenuId','desc')
                                ->paginate($rowCount, ['*'], 'page', $page);

                               // dd($checklistlogdata);

        return response()->json($checklistlogdata);

    }

    public function categorydelete($id){

       $masterdata = mastermenu::where('masterMenuId',$id)
                                ->update(['status' => 0]);

        $msg = $masterdata ? 1 : 0;
        return $msg;              

    }






}
