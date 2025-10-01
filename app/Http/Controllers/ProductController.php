<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\masterdata;
use App\Models\mstproduct;
use App\Models\mastermenu;


class ProductController extends BaseController
{

    public function addproduct()
    {

        return view('product.addproduct');
    }

    public function index()
    {

        return view('product.productlist');
    }

    public function dopmop()
    {

        return view('product.dop_mop');
    }


    public function addproductsubmit(Request $req)
    {

        $currentDateTime = now();
        $parentcategory = $req->parentcategory;
        $cat_number = $req->cat_number;
        $branddata = $req->branddata;
        $mrp = $req->mrp;
        $colordata = $req->colordata;
        $Product = $req->Product;
        $mrp = $req->mrp;
        $productpiece = $req->productpiece;
        $boxpack = $req->boxpack;
        $boxmrp = $req->boxmrp;
        $productCode = $req->productCode;
        $product_description = $req->product_description;
        $dop_netprice = $req->dop_netprice;
        $mop_netprice = $req->mop_netprice;
        $start_date = strtotime($req->start_date);
        $end_date =  strtotime($req->end_date);


        $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
        $accessAuthKey  = sha1($Product . '' . $currentDateTime->toDateTimeString());

        if ($req->hasFile('mastermenuimage')) {
            $productimage = time() . '.' . $req->mastermenuimage->getClientOriginalExtension();
            $req->mastermenuimage->move(public_path('images'), $productimage);
        }

        $childcategory = is_numeric($req->childcategory) ? (int)$req->childcategory : null;

        $data = [
            'categoryId_fk' => $parentcategory,
            'brandId_fk' => $branddata,
            'subCategoryId_fk' => $childcategory,
            'productName' => $Product,
            'cat_number' => $cat_number,
            'mrp' => $mrp,
            'dop_netprice' => $dop_netprice,
            'mop_netprice' => $mop_netprice,
            'productDesc' => $productpiece,
            'piece' => $productpiece,
            'boxPack' => $boxpack,
            'boxMRP' => $boxmrp,
            'productColorId_fk' => $colordata,
            'productCode' => $productCode,
            'productImage' => $productimage,
            'productDesc' => $product_description,
            'startDate' => $start_date,
            'endDate' => $end_date,
            'dataEntryDate' => $dataEntrydate,
            'productAuthKey' => $accessAuthKey,
            'status' => 1,
        ];

        $mstproduct = mstproduct::create($data);

        $msg = $mstproduct ? 'Data Insert Successfully' : 'Data Not Insert Successfully';
        $resp = $mstproduct ? 1 : 2;

        return response()->json(['resp' => $resp, 'msg' => $msg]);
    }


    public function dopmoplistdata(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        $mastermenu = mstproduct::where('status', 1)
            ->where(function ($query) {
                $query->where('dop_netprice', '!=', 0)
                    ->whereNotNull('dop_netprice')
                    ->where('dop_netprice', '!=', '');
            })
            ->where(function ($query) {
                $query->where('mop_netprice', '!=', 0)
                    ->whereNotNull('mop_netprice')
                    ->where('mop_netprice', '!=', '');
            })
            //->where('dop_netprice',0)
            ->orderBy('productId', 'asc')
            ->paginate($rowCount, ['productId', 'cat_number', 'productColorId_fk', 'mrp', 'boxMRP', 'dop_netprice', 'mop_netprice', 'boxPack', 'piece', 'subCategoryId_fk', 'productCode', 'productName', 'categoryId_fk', 'brandId_fk', 'productImage', 'startDate', 'endDate', 'productAuthKey'], 'page', $page);

        $data = [];


        // dd($mastermenu);
        foreach ($mastermenu as $key => $val) {

            // dd($val->productColorId_fk);
            $category = getmastermenudatabyid($val->categoryId_fk);
            $brand = getmastermenudatabyid($val->brandId_fk);
            $series = getmastermenudatabyid($val->subCategoryId_fk);
            $color = getmastermenudatabyid($val->productColorId_fk);

            $startDate = $val->startDate > 0 ? $val->startDate : null;
            $endDate = $val->endDate > 0 ? $val->endDate : null;
            $currentDate = time(); // Current timestamp

            // Determine status based on current date
            if ($startDate && $endDate && $currentDate >= $startDate && $currentDate <= $endDate) {
                $status = 'Active';
            } else {
                $status = 'Inactive';
            }



            $entry = [
                'productId' => $val->productId,
                'productCode' => $val->cat_number,
                'productName' => $val->productName,
                'series' => $series->name,
                'categoryId_fk' => $category->name,
                'productImage' => $val->productImage,
                'brandId_fk' => $brand->name,
                'productColorId_fk' => $color->name,
                'piece' => number_format($val->piece),
                'mrp' => number_format($val->mrp),
                'dop_netprice' => number_format($val->dop_netprice),
                'mop_netprice' => number_format($val->mop_netprice),
                'mop_netprice' => number_format($val->mop_netprice),
                'mop_netprice' => number_format($val->mop_netprice),
                'mop_netprice' => number_format($val->mop_netprice),
                'startdate' => $val->startDate > 0 ? date('d-M-Y', $val->startDate) : '', // Show date if greater than 0
                'enddate' => $val->endDate > 0 ? date('d-M-Y', $val->endDate) : '', // Added a similar check for enddate
                'status_to' => $status,
                'boxPack' => number_format($val->boxPack),
                'boxMRP' => number_format($val->boxMRP),
                'productAuthKey' => $val->productAuthKey
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mastermenu->currentPage(),
            'last_page' => $mastermenu->lastPage()
        ];

        return response()->json(['data' => $response]);
    }



    public function listdata(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        $mastermenu = mstproduct::where('status', 1)
            // ->where(function ($query) {
            //     $query->where('dop_netprice', '!=', 0)
            //         ->whereNotNull('dop_netprice')
            //         ->where('dop_netprice', '!=', '');
            // })
            // ->where(function ($query) {
            //     $query->where('mop_netprice', '!=', 0)
            //         ->whereNotNull('mop_netprice')
            //         ->where('mop_netprice', '!=', '');
            // })
            //->where('dop_netprice',0)
            ->orderBy('productId', 'asc')
            ->paginate($rowCount, ['productId', 'cat_number', 'dop_netprice', 'mop_netprice', 'productColorId_fk', 'mrp', 'boxMRP', 'boxPack', 'piece', 'subCategoryId_fk', 'productCode', 'productName', 'categoryId_fk', 'brandId_fk', 'productImage', 'productAuthKey'], 'page', $page);

        $data = [];

        foreach ($mastermenu as $key => $val) {

            // dd($val->productColorId_fk);
            $category = getmastermenudatabyid($val->categoryId_fk);
            $brand = getmastermenudatabyid($val->brandId_fk);
            $series = getmastermenudatabyid($val->subCategoryId_fk);
            $color = getmastermenudatabyid($val->productColorId_fk);

          //  dd($series);

            $entry = [
                'productId' => $val->productId,
                'productCode' => $val->cat_number,
                'productName' => $val->productName,
                'series' => $series->name ?? '',
                'categoryId_fk' => $category->name,
                'productImage' => $val->productImage,
                'brandId_fk' => $brand->name,
                'productColorId_fk' => $color->name,
                'piece' => number_format($val->piece),
                'mrp' => number_format($val->mrp),
                'dop_netprice' => number_format($val->dop_netprice),
                'mop_netprice' => number_format($val->mop_netprice),
                'boxPack' => number_format($val->boxPack),
                'boxMRP' => number_format($val->boxMRP),
                'productAuthKey' => $val->productAuthKey
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mastermenu->currentPage(),
            'last_page' => $mastermenu->lastPage()
        ];

        return response()->json(['data' => $response]);
    }

    public function productdelete($id)
    {

        $productdata = mstproduct::where('productId', $id)
            ->update(['status' => 0]);

        $msg = $productdata ? 1 : 0;
        return $msg;
    }

    public function productedit($id,$type)
    {

        $productdata = mstproduct::where('productAuthKey', $id)->first();

        return view('product.editproduct', compact('productdata','type'));
    }

    public function editsubmit(Request $req)
    {

        //dd($req);
        $currentDateTime = now();
        $productid = $req->productid;
        $old_image = $req->old_image;
        $parentcategory = $req->parentcategory;
        $branddata = $req->branddata;
        $colordata = $req->colordata;
        $Product = $req->Product;
        $productpiece = $req->productpiece;
        $boxpack = $req->boxpack;
        $cat_number = $req->cat_number;
        $mrp = $req->mrp;
        $boxmrp = $req->boxmrp;
        $productCode = $req->productCode;
        $dop_netprice = $req->dop_netprice;
        $mop_netprice = $req->mop_netprice;
        $product_description = $req->product_description;
        $start_date = strtotime($req->start_date);
        $end_date =  strtotime($req->end_date);


        $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
        $accessAuthKey  = sha1($Product . '' . $currentDateTime->toDateTimeString());

        if ($req->hasFile('mastermenuimage')) {
            $productimage = time() . '.' . $req->mastermenuimage->getClientOriginalExtension();
            $req->mastermenuimage->move(public_path('images'), $productimage);
        } else {
            $productimage  =  $old_image;
        }
        $childcategory = is_numeric($req->childcategory) ? (int)$req->childcategory : null;
        $data = [
            'categoryId_fk' => $parentcategory,
            'brandId_fk' => $branddata,
            'subCategoryId_fk' => $childcategory,
            'productName' => $Product,
            'productDesc' => $productpiece,
            'piece' => $productpiece,
            'boxPack' => $boxpack,
            'boxMRP' => $boxmrp,
            'mrp' => $mrp,
            'dop_netprice' => $dop_netprice,
            'mop_netprice' => $mop_netprice,
            'cat_number' => $cat_number,
            'productColorId_fk' => $colordata,
            //'productCode' => $productCode,
            'productImage' => $productimage,
            'productDesc' => $product_description,
            'dataEntryDate' => $dataEntrydate,
            'startDate' => $start_date,
            'endDate' => $end_date,
            //'productAuthKey' => $accessAuthKey,
        ];

        $mstproduct = mstproduct::where('productId', $productid)->update($data);

        $msg = $mstproduct ? 'Data Edit Successfully' : 'Data Not Edit Successfully';
        $resp = $mstproduct ? 1 : 2;

        return response()->json(['resp' => $resp, 'msg' => $msg]);
    }




    public function productsearch(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $brand = $req->input('brand');
        $cat_code = $req->input('cat_code');
        $category = $req->input('category');
        $series = $req->input('series');
        $product_name = $req->input('product_name');
        $color = $req->input('color');


        if (!empty($category)) {
            $masterdata_category = $this->masterdata_category[0]->masterDataId;
            $query_cat =  mastermenu::where('name', 'like', '%' . $category . '%')
                ->where('masterDataId_fk', $masterdata_category)
                ->whereNull('parentId')
                ->pluck('masterMenuId')
                ->implode(',');
        }

        if (!empty($brand)) {
            $masterdata_brand = $this->masterdata_brand[0]->masterDataId;
            $query_brand =  mastermenu::where('name', 'like', '%' . $brand . '%')
                ->where('masterDataId_fk', $masterdata_brand)
                ->pluck('masterMenuId')
                ->implode(',');
        }


        if (!empty($series)) {
            $masterdata_category = $this->masterdata_category[0]->masterDataId;
            // $query_seriec =  mastermenu::where('name','like', '%' . $series . '%')
            //             ->whereNotNull('parentId')
            //             ->where('masterDataId_fk',$masterdata_category)
            //             ->first('masterMenuId');

            $query_seriec = mastermenu::where('name', 'like', '%' . $series . '%')
                ->whereNotNull('parentId')
                ->where('masterDataId_fk', $masterdata_category)
                ->pluck('masterMenuId')
                ->implode(',');


            // dd($query_seriec);
        }


        if (!empty($color)) {
            $masterdata_color = $this->masterdata_color[0]->masterDataId;
            $query_color =  mastermenu::where('name', 'like', '%' . $color . '%')
                ->where('masterDataId_fk', $masterdata_color)
                ->pluck('masterMenuId')
                ->implode(',');
        }




        $query = mstproduct::where('status', 1)
            ->select('productId', 'cat_number', 'productColorId_fk', 'mrp', 'dop_netprice', 'mop_netprice', 'boxMRP', 'boxPack', 'piece', 'subCategoryId_fk', 'productCode', 'productName', 'categoryId_fk', 'brandId_fk', 'productImage', 'productAuthKey')
            ->orderBy('productId', 'asc');


        if (!empty($cat_code)) {
            $query->where('cat_number', 'like', '%' . $cat_code . '%');
        }

        if (!empty($category)) {
            $query_catIdArray = explode(',', $query_cat);
            $query->whereIn('categoryId_fk', $query_catIdArray);
        }

        if (!empty($series)) {
            $query_seriesIdArray = explode(',', $query_seriec);
            //$query_seriesId = $query_seriec ? $query_seriec->masterMenuId : 0;
            $query->whereIn('subCategoryId_fk', $query_seriesIdArray);
        }

        if (!empty($brand)) {
            $query_brandIdArray = explode(',', $query_cat);
            // $brandId = $query_brand ? $query_brand->masterMenuId : 0;
            $query->whereIn('brandId_fk', $query_brandIdArray);
        }

        if (!empty($color)) {

            $query_colorIdArray = explode(',', $query_color);
            //  $colorId = $query_color ? $query_color->masterMenuId : 0;
            $query->whereIn('productColorId_fk', $query_colorIdArray);
        }

        if (!empty($product_name)) {
            $query->where('productName', 'like', '%' . $product_name . '%');
        }

        $mastermenu = $query->paginate($rowCount, ['*'], 'page', $page);


        $data = [];

        foreach ($mastermenu as $key => $val) {

            // dd($val->productColorId_fk);
            $category = getmastermenudatabyid($val->categoryId_fk);
            $brand = getmastermenudatabyid($val->brandId_fk);
            $series = getmastermenudatabyid($val->subCategoryId_fk);
            $color = getmastermenudatabyid($val->productColorId_fk);

            $entry = [
                'productId' => $val->productId,
                'productCode' => $val->cat_number,
                'productName' => $val->productName,
                'series' => $series->name ?? '',
                'categoryId_fk' => $category->name,
                'productImage' => $val->productImage,
                'brandId_fk' => $brand->name,
                'productColorId_fk' => $color->name,
                'piece' => number_format($val->piece),
                'mrp' => number_format($val->mrp),
                'dop_netprice' => number_format($val->dop_netprice),
                'mop_netprice' => number_format($val->mop_netprice),
                'boxPack' => number_format($val->boxPack),
                'boxMRP' => number_format($val->boxMRP),
                'productAuthKey' => $val->productAuthKey
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mastermenu->currentPage(),
            'last_page' => $mastermenu->lastPage()
        ];

        return response()->json(['data' => $response]);
    }

    public function productdopmopsearch(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $brand = $req->input('brand');
        $cat_code = $req->input('cat_code');
        $category = $req->input('category');
        $series = $req->input('series');
        $product_name = $req->input('product_name');
        $color = $req->input('color');


        if (!empty($category)) {
            $masterdata_category = $this->masterdata_category[0]->masterDataId;
            $query_cat =  mastermenu::where('name', 'like', '%' . $category . '%')
                ->where('masterDataId_fk', $masterdata_category)
                ->whereNull('parentId')
                ->pluck('masterMenuId')
                ->implode(',');
        }

        if (!empty($brand)) {
            $masterdata_brand = $this->masterdata_brand[0]->masterDataId;
            $query_brand =  mastermenu::where('name', 'like', '%' . $brand . '%')
                ->where('masterDataId_fk', $masterdata_brand)
                ->pluck('masterMenuId')
                ->implode(',');
        }


        if (!empty($series)) {
            $masterdata_category = $this->masterdata_category[0]->masterDataId;
            // $query_seriec =  mastermenu::where('name','like', '%' . $series . '%')
            //             ->whereNotNull('parentId')
            //             ->where('masterDataId_fk',$masterdata_category)
            //             ->first('masterMenuId');

            $query_seriec = mastermenu::where('name', 'like', '%' . $series . '%')
                ->whereNotNull('parentId')
                ->where('masterDataId_fk', $masterdata_category)
                ->pluck('masterMenuId')
                ->implode(',');


            // dd($query_seriec);
        }


        if (!empty($color)) {
            $masterdata_color = $this->masterdata_color[0]->masterDataId;
            $query_color =  mastermenu::where('name', 'like', '%' . $color . '%')
                ->where('masterDataId_fk', $masterdata_color)
                ->pluck('masterMenuId')
                ->implode(',');
        }




        $query = mstproduct::where('status', 1)
            ->select('productId', 'cat_number', 'productColorId_fk', 'mrp', 'mop_netprice', 'dop_netprice', 'boxMRP', 'boxPack', 'piece', 'subCategoryId_fk', 'productCode', 'productName', 'categoryId_fk', 'brandId_fk', 'productImage', 'startDate', 'endDate', 'productAuthKey')
            ->orderBy('productId', 'asc')
            ->where(function ($query) {
                $query->where('dop_netprice', '!=', 0)
                    ->whereNotNull('dop_netprice')
                    ->where('dop_netprice', '!=', '');
            })
            ->where(function ($query) {
                $query->where('mop_netprice', '!=', 0)
                    ->whereNotNull('mop_netprice')
                    ->where('mop_netprice', '!=', '');
            });


        if (!empty($cat_code)) {
            $query->where('cat_number', 'like', '%' . $cat_code . '%');
        }

        if (!empty($category)) {
            $query_catIdArray = explode(',', $query_cat);
            $query->whereIn('categoryId_fk', $query_catIdArray);
        }

        if (!empty($series)) {
            $query_seriesIdArray = explode(',', $query_seriec);
            //$query_seriesId = $query_seriec ? $query_seriec->masterMenuId : 0;
            $query->whereIn('subCategoryId_fk', $query_seriesIdArray);
        }

        if (!empty($brand)) {
            $query_brandIdArray = explode(',', $query_cat);
            // $brandId = $query_brand ? $query_brand->masterMenuId : 0;
            $query->whereIn('brandId_fk', $query_brandIdArray);
        }

        if (!empty($color)) {

            $query_colorIdArray = explode(',', $query_color);
            //  $colorId = $query_color ? $query_color->masterMenuId : 0;
            $query->whereIn('productColorId_fk', $query_colorIdArray);
        }

        if (!empty($product_name)) {
            $query->where('productName', 'like', '%' . $product_name . '%');
        }

        $mastermenu = $query->paginate($rowCount, ['*'], 'page', $page);


        $data = [];

        foreach ($mastermenu as $key => $val) {

            // dd($val->productColorId_fk);
            $category = getmastermenudatabyid($val->categoryId_fk);
            $brand = getmastermenudatabyid($val->brandId_fk);
            $series = getmastermenudatabyid($val->subCategoryId_fk);
            $color = getmastermenudatabyid($val->productColorId_fk);

            $startDate = $val->startDate > 0 ? $val->startDate : null;
            $endDate = $val->endDate > 0 ? $val->endDate : null;
            $currentDate = time(); // Current timestamp

            // Determine status based on current date
            if ($startDate && $endDate && $currentDate >= $startDate && $currentDate <= $endDate) {
                $status = 'Active';
            } else {
                $status = 'Inactive';
            }

            $entry = [
                'productId' => $val->productId,
                'productCode' => $val->cat_number,
                'productName' => $val->productName,
                'series' => $series->name,
                'categoryId_fk' => $category->name,
                'productImage' => $val->productImage,
                'brandId_fk' => $brand->name,
                'productColorId_fk' => $color->name,
                'piece' => number_format($val->piece),
                'mrp' => number_format($val->mrp),
                'dop_netprice' => number_format($val->dop_netprice),
                'mop_netprice' => number_format($val->mop_netprice),
                'startdate' => $val->startDate > 0 ? date('d-M-Y', $val->startDate) : '', // Show date if greater than 0
                'enddate' => $val->endDate > 0 ? date('d-M-Y', $val->endDate) : '', // Added a similar check for enddate
                'status_to' => $status,
                'boxPack' => number_format($val->boxPack),
                'boxMRP' => number_format($val->boxMRP),
                'productAuthKey' => $val->productAuthKey
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mastermenu->currentPage(),
            'last_page' => $mastermenu->lastPage()
        ];

        return response()->json(['data' => $response]);
    }
}
