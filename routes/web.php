<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\MastermenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GetController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DSRController;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\ImsController;


Route::get('/login-form', [LoginController::class, 'index'])->name('login');
Route::post('/login-form-submit',[LoginController::class,'loginformsubmit'])->name('login.indexformsubmit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware([CheckLogin::class])->group(function(){

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('home');

    Route::get('/', [CustomerController::class, 'distributorlist'])->name('home');

    Route::get('/getmasterroles', [GetController::class, 'getmasterroles'])->name('get.masterroles');
    Route::get('/roles/{roleTypeId}', [GetController::class, 'getroles'])->name('roles.byType');
    Route::get('/customer/type', [GetController::class, 'getcustomertype'])->name('customer.type');
    Route::get('/dealer/type', [GetController::class, 'getdealertype'])->name('dealer.type');
    Route::get('/gallery/type', [GetController::class, 'getgallerytype'])->name('gallery.type');
    Route::get('/billing/type', [GetController::class, 'getbillingtype'])->name('billing.type');
    Route::get('/distributor/type', [GetController::class, 'getdistributortype'])->name('distributor.type');
    Route::get('/business/type', [GetController::class, 'getbusinesstype'])->name('business.type');
    Route::get('/bank/type', [GetController::class, 'getbanktype'])->name('bank.type');
    Route::get('/mainhead/type', [GetController::class, 'getmainheads'])->name('mainheads.type');
    Route::get('/cluster/all', [GetController::class, 'getallcluster'])->name('cluster.all');
    Route::get('/transproter/all', [GetController::class, 'gettransproter'])->name('transproter.all');
    Route::get('/salesuser/all', [GetController::class, 'getallusers'])->name('salesuser.all');
    Route::get('/parent/category/all', [GetController::class, 'getallparentcategory'])->name('parentcategory.all');
    Route::get('/child/category/{id}', [GetController::class, 'getallchildcategory'])->name('childcategory.all');
    Route::get('/brand/all', [GetController::class, 'getallbrand'])->name('brand.all');
    Route::get('/color/all', [GetController::class, 'getcolor'])->name('color.all');
    Route::get('/sales/user/all', [GetController::class, 'getsalesuser'])->name('sales.all');
    Route::get('/distributor/all', [GetController::class, 'getdistributor'])->name('distributor.all');
    Route::get('/order/type', [GetController::class, 'ordertype'])->name('order.type');
    Route::get('/payment/mode', [GetController::class, 'payment_mode'])->name('payment.mode');
    Route::get('/product/import',[GetController::class, 'productimport'])->name('product.import');
    Route::get('/customer/import',[GetController::class, 'customerimport'])->name('customer.import');
    Route::get('/user/import',[GetController::class, 'userimport'])->name('customer.import');
    Route::get('/product/image/import',[GetController::class, 'productimageimport'])->name('product.imageimport');
    Route::get('/purchase/return/all', [GetController::class, 'purchasereturnall'])->name('purchasereturn.all');
    Route::get('/inventory/update', [GetController::class, 'inventoryupdate'])->name('inventory.update');

    Route::group(['prefix' => 'master'], function () {
        Route::get('/form', [MasterController::class, 'index'])->name('master.index');
        Route::post('/formsubmit', [MasterController::class, 'masterformsubmit'])->name('master.indexformsubmit');
        Route::get('/getdata', [MasterController::class, 'getmasterdata'])->name('master.getmasterdata');
        Route::get('/series', [MastermenuController::class, 'seriesform'])->name('master.series');
        Route::get('/menuform', [MastermenuController::class, 'index'])->name('mastermenu.index');
        Route::post('/menuformsubmit', [MastermenuController::class, 'mastermenuformsubmit'])->name('mastermenu.indexformsubmit');
        Route::post('/series/submit', [MastermenuController::class, 'seriesformsubmit'])->name('mastermenu.seriesformsubmit');
        Route::get('/getmainmenu', [MastermenuController::class, 'getmainmenu'])->name('mastermenu.getmainmenu');
        Route::get('/list', [MastermenuController::class, 'listdata'])->name('mastermenu.listdata');
        Route::get('/series/list', [MastermenuController::class, 'serieslistdata'])->name('mastermenu.seriesdata');
        Route::get('/delete/{id}', [MastermenuController::class, 'masterdelete'])->name('mastermenu.delete');
        Route::get('/inventory', [MastermenuController::class, 'masterinventory'])->name('master.inventory');
        Route::get('/inventory/listdata', [MastermenuController::class, 'inventorylistdata'])->name('master.listdata');
        Route::get('/inventory/search', [MastermenuController::class, 'masterinventorysearch'])->name('master.inventorysearch');
        Route::get('/ledger', [MastermenuController::class, 'masterledger'])->name('master.ledger');
        Route::get('/ledger/listdata', [MastermenuController::class, 'ledgerlistdata'])->name('master.ledgerlistdata');
        Route::get('/ledger/search', [MastermenuController::class, 'masterledgersearch'])->name('master.ledgersearch');
    });

    Route::group(['prefix' => 'location'], function () {
        Route::get('/form', [MasterController::class, 'locationadd'])->name('location.index');
        Route::post('/form/submit', [MasterController::class, 'locationsubmit'])->name('location.submit');
        Route::get('/state', [GetController::class, 'getlocation'])->name('location.state');
        Route::get('/city/{stateid}', [GetController::class, 'getcity'])->name('location.city');
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get('/form', [UserController::class, 'index'])->name('user.index');
        Route::post('/form/submit', [UserController::class, 'userformsubmit'])->name('user.formsubmit');
        Route::get('/list', [UserController::class, 'userlist'])->name('user.list');
        Route::get('/list/data', [UserController::class, 'listdata'])->name('user.listdata');
        Route::get('/edit/{id}', [UserController::class, 'useredit'])->name('user.edit');
        Route::post('/edit/submit', [UserController::class, 'editsubmit'])->name('user.editsubmit');
        Route::get('/delete/{id}', [UserController::class, 'userdelete'])->name('user.delete');
        Route::get('/search', [UserController::class, 'usersearch'])->name('user.search');
        Route::get('/add/target',[UserController::class,'usertarget'])->name('user.target');
        Route::get('/target/append',[UserController::Class, 'targetappend'])->name('user.targetappend');
        Route::POST('/target/submit',[UserController::Class, 'targetsubmit'])->name('user.targetsubmit');
        Route::get('/target/list',[UserController::Class, 'targetlist'])->name('user.targetlist');
        Route::get('/check/target',[UserController::Class, 'checktarget'])->name('check.target');
        Route::get('/check/empcode',[UserController::Class, 'checkempcode'])->name('check.empcode');
        Route::get('/target/search', [UserController::Class, 'usertargetsearch'])->name('user.targetsearch');
        Route::get('/target/delete', [UserController::Class, 'usertargetdelete'])->name('user.targetdelete');

    });

    Route::group(['prefix' => 'customer'], function() {
        Route::get('/add', [CustomerController::class, 'index'])->name('customer.index');
        Route::post('/form/submit', [CustomerController::class, 'FormSubmit'])->name('customer.formsubmit');
        Route::get('/edit/{id}', [CustomerController::class, 'CustomerEdit'])->name('customer.edit');
        Route::post('/edit/submit', [CustomerController::class, 'editsubmit'])->name('customer.editsubmit');
        Route::get('/delete/{id}', [CustomerController::class, 'deltesubmit'])->name('customer.delete');
        Route::get('/list/distributor', [CustomerController::class, 'distributorlist'])->name('customer.distributorlist');
        Route::get('/list/dealer', [CustomerController::class, 'dealerlist'])->name('customer.dealerlist');
        Route::get('/list/retailer', [CustomerController::class, 'retailerlist'])->name('customer.retailerlist');
        Route::get('/list/ubs', [CustomerController::class, 'ubslist'])->name('customer.ubslist');
        Route::get('/list/data', [CustomerController::class, 'listdata'])->name('customer.listdata');
        Route::get('/search', [CustomerController::class, 'customersearch'])->name('customer.search');

    });

    Route::group(['prefix' => 'category'], function() {
        Route::get('/list', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/list/data', [CategoryController::class, 'listdata'])->name('category.listdata');
        Route::post('/edit/submit', [CategoryController::class, 'editsubmit'])->name('category.editsubmit');
        Route::get('/child/list/{id}', [CategoryController::class, 'childlist'])->name('category.childlist');
        Route::get('/child/listdata', [CategoryController::class, 'childlistdata'])->name('category.childdata');
        Route::get('/delete/{id}', [CategoryController::class, 'categorydelete'])->name('category.delete');
    });


    Route::group(['prefix' => 'product'], function() {
        Route::get('/', [ProductController::class, 'addproduct'])->name('product.add');
        Route::post('/add/submit', [ProductController::class, 'addproductsubmit'])->name('product.addsubmit');
        Route::get('/list', [ProductController::class, 'index'])->name('product.list');
        Route::get('/dop/mop', [ProductController::class, 'dopmop'])->name('dop_mop.list');
        Route::get('/list/data', [ProductController::class, 'listdata'])->name('product.listdata');
        Route::get('/dop/mop/data', [ProductController::class, 'dopmoplistdata'])->name('product.dopmoplistdata');
        Route::get('/delete/{id}', [ProductController::class, 'productdelete'])->name('product.delete');
        Route::get('/edit/{id}/{type}', [ProductController::class, 'productedit'])->name('product.edit');
        Route::post('/edit/submit', [ProductController::class, 'editsubmit'])->name('product.editsubmit');
        Route::get('/search', [ProductController::class, 'productsearch'])->name('product.search');
        Route::get('/dop/mop/search', [ProductController::class, 'productdopmopsearch'])->name('product.dopmopsearch');
    });

    Route::group(['prefix' => 'order'], function(){
        Route::get('/form', [OrderController::Class,'index'])->name('order.index');
        Route::post('/form/data', [OrderController::Class,'orderformdata'])->name('order.formdata');
        Route::post('/form/submit', [OrderController::Class,'ordersubmit'])->name('order.submit');
        Route::get('/list/primary', [OrderController::Class,'orderlist'])->name('order.list');
        Route::get('/list/data', [OrderController::Class,'orderlistdata'])->name('order.listdata');
        Route::get('/list/secondary', [OrderController::Class,'orderlistsecondary'])->name('order.listsecondary');
        Route::get('/list/data/secondary', [OrderController::Class,'orderlistdatasecondary'])->name('order.listdatasecondary');
        Route::get('/edit/{id}', [OrderController::Class,'orderedit'])->name('order.edit');
        Route::post('/edit/submit', [OrderController::Class,'ordereditsubmit'])->name('order.editsubmit');
        Route::get('/search', [OrderController::class, 'ordersearch'])->name('order.search');
        Route::get('/search/secondary', [OrderController::class, 'ordersearchsecondary'])->name('order.searchsecondary');
        Route::get('/delete/{id}', [OrderController::class, 'orderdelete'])->name('order.delete');
        Route::get('/dispatch/{id}', [OrderController::class, 'orderdispatch'])->name('order.dispatch');
        Route::get('/customer/discount', [OrderController::Class,'OrderCustomerDiscount'])->name('order.customerdiscount');
        Route::get('/consignee/{id}', [OrderController::class, 'orderconsignee'])->name('order.consignee');
        Route::post('/consignee/data', [OrderController::class, 'consigneedata'])->name('order.consigneedata');
        Route::get('/scheme', [OrderController::class, 'scheme'])->name('order.scheme');
        Route::post('/scheme/submit', [OrderController::class, 'schemesubmit'])->name('order.schemesubmit');
        Route::get('/scheme/list', [OrderController::class, 'schemelist'])->name('order.schemelist');
        Route::get('/scheme/list-data', [OrderController::class, 'schemelistdata'])->name('order.schemelistdata');
        Route::get('/scheme/delete/{id}', [OrderController::class, 'sechmedelete'])->name('scheme.delete');
        Route::post('/scheme/calculation',[OrderController::Class, 'schemecalculation'])->name('scheme.calculation');
        Route::get('/scheme/search',[OrderController::Class, 'schemesearch'])->name('scheme.search');
        Route::get('/date/search',[OrderController::Class, 'orderdatesearch'])->name('order.datesearch');
        Route::get('/export-orders', [OrderController::class, 'export'])->name('orders.export');
        Route::post('/invoice/detail', [OrderController::class, 'orderInvoicedetail'])->name('orders.invoice');
        Route::post('/upload/invoice', [OrderController::class, 'uploadInvoice'])->name('upload.invoices');


    });

    Route::group(['prefix' => 'dispatch'], function(){
        Route::get('/pending', [DispatchController::Class, 'pendingdispatch'])->name('pending.dispatch');
        Route::get('/complete', [DispatchController::Class, 'completedispatch'])->name('complete.dispatch');
        Route::get('/listdata', [DispatchController::Class, 'dispatchlistdata'])->name('dispatch.listdata');
        Route::get('/detail/{id}', [DispatchController::Class, 'dispatchdetail'])->name('dispatch.detail');
        Route::post('/submit', [DispatchController::Class, 'dispatchsubmit'])->name('dispatch.submit');
        Route::get('/pending/search', [DispatchController::Class, 'pendingdispathsearch'])->name('dispatch.pendingsearch');
        Route::get('/complete/search', [DispatchController::Class, 'completedispathsearch'])->name('dispatch.completesearch');
        Route::get('/complete/detail/{id}', [DispatchController::Class, 'completedispatchdetail'])->name('dispatch.completedetail');
    });

    Route::group(['prefix' => 'attendance'], function(){
        Route::get('/list',[AttendanceController::Class, 'index'])->name('attendance.index');
        Route::post('/submit', [AttendanceController::Class, 'submit'])->name('attendance.submit');
        Route::post('/checkout', [AttendanceController::class, 'checkout'])->name('attendance.chekout');
        Route::get('/listdata', [AttendanceController::class, 'listdata'])->name('attendance.listdata');
        Route::get('/day/detail/{id}',[AttendanceController::class, 'daydetail'])->name('attendance.daydetail');
        Route::get('/day/detaildata',[AttendanceController::class, 'daydetaildata'])->name('attendance.daydetaildata');
        Route::get('/sheet/export/{from}/{to}',[AttendanceController::class, 'attendancesheetexport'])->name('attendance.export');
        Route::post('/data/sheet/export',[AttendanceController::class, 'attendancedatasheetexport'])->name('attendancedata.export');
        Route::post('/data/sheet/export/search',[AttendanceController::class, 'attendancedatasheetexportsearch'])->name('attendancedata.exportsearch');
    });

    Route::group(['prefix' => 'dsr'], function(){

        Route::get('/list',[DSRController::Class, 'index'])->name('dsr.index');
        Route::get('/new/list',[DSRController::Class, 'dsrnewindex'])->name('dsr.newindex');
        Route::post('/checkin/submit', [DSRController::Class, 'checkinsumbit'])->name('dsr.checkinsubmit');
        Route::post('/checkout/submit', [DSRController::class, 'checkoutsumbit'])->name('dsr.checkoutsubmit');
        Route::get('/listdata', [DSRController::class, 'listdata'])->name('dsr.listdata');
        Route::get('/new/listdata', [DSRController::class, 'newlistdata'])->name('dsr.newlistdata');
        Route::get('/sheet/export/{from}/{to}', [DSRController::class, 'dsrsheetexport'])->name('dsr.export');
        Route::post('/data/sheet/export', [DSRController::class, 'dsrdatasheetexport'])->name('dsr.dataexport');
        Route::post('/data/sheet/export/search', [DSRController::class, 'dsrdatasheetexportsearch'])->name('dsr.dataexportsearch');

    });

    Route::group(['prefix' => 'report'], function(){
        Route::get('/attendance/hr',[DSRController::Class, 'attendancereport'])->name('attendancereport.hr');
        Route::get('detail/hr',[DSRController::Class, 'detailreport'])->name('detailreport.hr');

    });



    Route::group(['prefix' => 'ims'], function(){

        Route::post('/form/data', [ImsController::Class,'imsformdata'])->name('ims.formdata');
        Route::get('/add/inward',[ImsController::Class, 'addinward'])->name('ims.addinward');
        Route::post('/form/submit', [ImsController::Class,'imsformdatasubmit'])->name('ims.formdatasubmit');
        Route::get('/inward/list',[ImsController::Class, 'index'])->name('ims.inwardlist');
        Route::get('/inward/list/data',[ImsController::Class, 'inwardlistdata'])->name('ims.inwardlistdata');
        Route::get('/list', [ImsController::Class, 'imslist'])->name('ims.list');
        Route::get('/list/data', [ImsController::Class, 'imslistdata'])->name('ims.listdata');
        Route::post('/data/save', [ImsController::Class, 'openingdatasave'])->name('ims.openingdatasave');
        Route::get('/product/search', [ImsController::Class, 'imsproductsearch'])->name('ims.productsearch');
        Route::post('/get/totalinward',[ImsController::Class, 'gettotalinward'])->name('ims.gettotalinward');
        Route::get('/dataupload',[ImsController::Class, 'datauploadform'])->name('ims.dataupload');

    });


});


Route::get('/jasondecode', [OrderController::class,'jasondecode']);

Route::get('/pdf/{id}',[OrderController::class,'generatePDF'])->name('order.pdf');




