<?php

namespace App\Http\Controllers;
use App\Models\masterdata;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
  //  protected $masterdata_appmenu;
    public function __construct() 
    {
        // Fetch the Site Settings object
        
        $this->masterdata_appmenu = masterdata::select('masterDataId')->where('groupName',1)->get();
        $this->masterdata_customertype = masterdata::select('masterDataId')->where('groupName',9)->get();
        $this->masterdata_dealertype = masterdata::select('masterDataId')->where('groupName',4)->get();
        $this->masterdata_gallerytype = masterdata::select('masterDataId')->where('groupName',8)->get();
        $this->masterdata_billingtype = masterdata::select('masterDataId')->where('groupName',11)->get();
        $this->masterdata_distributortype = masterdata::select('masterDataId')->where('groupName',12)->get();
        $this->masterdata_businesstype = masterdata::select('masterDataId')->where('groupName',13)->get();
        $this->masterdata_banktype = masterdata::select('masterDataId')->where('groupName',7)->get();
        $this->masterdata_salesuser = masterdata::select('masterDataId')->where('groupName',3)->get();
        $this->masterdata_mainheads = masterdata::select('masterDataId')->where('groupName',5)->get();
        $this->masterdata_cluster = masterdata::select('masterDataId')->where('groupName',6)->get();
        $this->masterdata_transproter = masterdata::select('masterDataId')->where('groupName',14)->get();
        $this->masterdata_category = masterdata::select('masterDataId')->where('groupName',15)->get();
        $this->masterdata_color = masterdata::select('masterDataId')->where('groupName',16)->get();
        $this->masterdata_brand = masterdata::select('masterDataId')->where('groupName',17)->get();
        $this->masterdata_ordertype = masterdata::select('masterDataId')->where('groupName',20)->get();
        $this->masterdata_paymentmode = masterdata::select('masterDataId')->where('groupName',21)->get();
        $this->masterdata_purchasereturn = masterdata::select('masterDataId')->where('groupName',23)->get();
       // View::share('masterdata_appmenu', $this->masterdata_appmenu);
    }
 
}
