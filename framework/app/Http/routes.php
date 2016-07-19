<?php
use Illuminate\Support\Str;
use App\Models\Category;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/', function () {
    return view('login');
    });

Route::post('authenticate', ['as'=>'login.process', 'uses'=>'Sentinel\AuthController@authenticate']);
Route::get('logout', ['uses'=>'Sentinel\AuthController@logout'])->middleware(['webAuth']);

Route::group(['middleware' => ['web']], function () {
    Route::get('login', function() {
            return view('login');
    });

    Route::get('sendmail', ['as'=>'sendmail', 'uses'=>'SendMailController@sendMail']);

    Route::get('dashboard', ['as'=>'dashboard', 'uses'=>'DashboardController@index']);
    
    Route::group(['middleware' => ['pageAccess']], function () {
        Route::get('users/list', ['as'=>'user.list', 'uses'=>'Sentinel\UserController@index']);
        Route::get('users/create', ['as'=>'user.create', 'uses'=>'Sentinel\UserController@create']);
        Route::post('users/store', ['as'=>'user.store', 'uses'=>'Sentinel\UserController@store']);
        Route::get('users/edit/{id}', ['as'=>'user.edit', 'uses'=>'Sentinel\UserController@edit']);
        Route::post('users/update/{id}', ['as'=>'user.update', 'uses'=>'Sentinel\UserController@update']);
        Route::get('users/history', ['as'=>'user.history', 'uses'=>'Sentinel\UserController@historyIndex']);
        Route::get('users/history/list', ['as'=>'user.history.list', 'uses'=>'Sentinel\UserController@getAllHistory']);
        
        Route::get('role', array('as'=>'role', 'uses'=>'Sentinel\UserController@createRole'));
        Route::get('role/create', ['as'=>'role.create', 'uses'=>'Sentinel\UserController@roleIndex']);
        Route::get('role/edit/{id}', ['as'=>'role.edit', 'uses'=>'Sentinel\UserController@editRole']);
        Route::post('role/update/{id}', ['as'=>'role.update', 'uses'=>'Sentinel\UserController@updateRole']);
        Route::post('role/store', ['as'=>'role.store', 'uses'=>'Sentinel\UserController@storeRole']);
        

        /*Route Product*/
        Route::get('product', ['as' => 'product', 'uses' => 'ProductController@index']);
        Route::get('product/data', ['as' => 'product.data', 'uses' => 'ProductController@data']);
        Route::get('product/create', ['as' => 'product.create', 'uses' => 'ProductController@create']);
        Route::post('product/store', ['as' => 'product.store', 'uses' => 'ProductController@store']);
        Route::get('product/edit/{id}', ['as' => 'product.edit', 'uses' => 'ProductController@edit']);
        Route::post('product/update/{id}', ['as' => 'product.update', 'uses' => 'ProductController@update']);
        Route::get('product/delete/{id}', ['as' => 'product.delete', 'uses' => 'ProductController@destroy']);
        Route::get('product/upload', ['as' => 'product.upload', 'uses' => 'ProductController@upload']);
        Route::get('product/download', ['as' => 'product.download', 'uses' => 'ProductController@generateExcelTemplate']);
        Route::post('product/import', ['as' => 'product.import', 'uses' => 'ProductController@importExcel']);

        /*End Route Product*/

        /*Route Category*/
        Route::get('category', ['as'=>'category', 'uses'=>'CategoryController@index']);
        Route::get('category/data', ['as' => 'category.data', 'uses' => 'CategoryController@data']);
        Route::get('category/create', ['as'=>'category.create', 'uses'=>'CategoryController@create']);
        Route::post('category/store', ['as'=>'category.store', 'uses'=>'CategoryController@store']);
        Route::get('category/edit/{id}', ['as'=>'category.edit', 'uses'=>'CategoryController@edit']);
        Route::post('category/update/{id}', ['as'=>'category.update', 'uses'=>'CategoryController@update']);
        Route::get('category/delete/{id}', ['as'=>'category.delete', 'uses'=>'CategoryController@destroy']);
        Route::get('search/category', ['as' => 'autocomplete.category', 'uses' => 'CategoryController@autocomplete']);
        /*End Route Category*/

        /*Route Supplier*/
        Route::get('supplier', ['as'=>'supplier', 'uses'=>'SupplierController@index']);
        Route::get('supplier/data', ['as'=>'supplier.data', 'uses'=>'SupplierController@data']);
        Route::get('supplier/create', ['as'=>'supplier.create', 'uses'=>'SupplierController@create']);
        Route::post('supplier/store', ['as'=>'supplier.store', 'uses'=>'SupplierController@store']);
        Route::get('supplier/edit/{id}', ['as'=>'supplier.edit', 'uses'=>'SupplierController@edit']);
        Route::post('supplier/update/{id}', ['as'=>'supplier.update', 'uses'=>'SupplierController@update']);
        Route::get('supplier/delete/{id}', ['as'=>'supplier.delete', 'uses'=>'SupplierController@destroy']);
        /*End Route Supplier*/

        /*Route Customer*/
        Route::get('customer', ['as' => 'customer', 'uses' => 'CustomerController@index']);
        Route::get('customer/data', ['as' => 'customer.data', 'uses' => 'CustomerController@data']);
        Route::get('customer/create', ['as'=>'customer.create', 'uses'=>'CustomerController@create']);
        Route::post('customer/store', ['as' => 'customer.store', 'uses' => 'CustomerController@store']);
        Route::get('customer/edit/{id}', ['as' => 'customer.edit', 'uses' => 'CustomerController@edit']);
        Route::post('customer/update/{id}', ['as' => 'customer.update', 'uses' => 'CustomerController@update']);
        Route::post('customer/delete', ['as' => 'customer.delete', 'uses' => 'CustomerController@destroy']);
        Route::get('customer/upload', ['as' => 'customer.upload', 'uses' => 'CustomerController@upload']);
        Route::get('customer/download', ['as' => 'customer.download', 'uses' => 'CustomerController@generateExcelTemplate']);
        Route::post('customer/import', ['as' => 'customer.import', 'uses' => 'CustomerController@importExcel']);
        /*End Route Customer*/

        /*Route Employee*/
        Route::get('employee', ['as' => 'employee', 'uses' => 'EmployeeController@index']);
        Route::post('employee/store', ['as' => 'employee.store', 'uses' => 'EmployeeController@store']);
        Route::get('employee/edit/{id}', ['as' => 'employee.edit', 'uses' => 'EmployeeController@edit']);
        Route::post('employee/update/{id}', ['as' => 'employee.update', 'uses' => 'EmployeeController@update']);
        Route::get('employee/delete/{id}', ['as' => 'employee.delete', 'uses' => 'EmployeeController@destroy']);
        Route::get('employee/upload', ['as' => 'employee.upload', 'uses' => 'EmployeeController@upload']);
        Route::get('employee/download', ['as' => 'employee.download', 'uses' => 'EmployeeController@generateExcelTemplate']);
        Route::post('employee/import', ['as' => 'employee.import', 'uses' => 'EmployeeController@importExcel']);
        /*End Route Employee*/

        /*Route Menu*/
        Route::get('menu', ['as' => 'menu', 'uses' => 'MenuController@index']);
        Route::get('menu/create', ['as' => 'menu.create', 'uses' => 'MenuController@create']);
        Route::get('menu/delete/{id}', ['as' => 'menu.delete', 'uses' => 'MenuController@destroy']);
        Route::get('menu/edit/{id}', ['as' => 'menu.edit', 'uses' => 'MenuController@edit']);
        Route::post('menu/store', ['as' => 'menu.store', 'uses' => 'MenuController@store']);
        Route::post('menu/update/{id}', ['as' => 'menu.update', 'uses' => 'MenuController@update']);
        /*End Route Menu*/

        /*Route Branch*/
        Route::get('branch', ['as' => 'branch', 'uses' => 'BranchController@index']);
        Route::get('branch/create', ['as' => 'branch.create', 'uses' => 'BranchController@create']);
        Route::post('branch/store', ['as' => 'branch.store', 'uses' => 'BranchController@store']);
        Route::get('branch/edit/{id}', ['as' => 'branch.edit', 'uses' => 'BranchController@edit']);
        Route::post('branch/update/{id}', ['as' => 'branch.update', 'uses' => 'BranchController@update']);
        Route::post('branch/delete', ['as' => 'branch.delete', 'uses' => 'BranchController@destroy']);
        
        /*Route Sale*/
        Route::get('sale', ['as' => 'sale', 'uses' => 'SalesController@index']);
        Route::get('sale/invoice/{id}', ['as' => 'sale.invoice', 'uses' => 'SalesController@invoice']);
        Route::get('sale/create', ['as' => 'sale.create.new', 'uses' => 'SalesController@create']);
        Route::get('search/item', ['as' => 'autocomplete.product', 'uses' => 'SalesController@auto_item']);
        Route::post('sale/additem', ['as' => 'sale.additem', 'uses' => 'SalesController@addItem']);
        Route::post('sale/store', ['as' => 'sale.store', 'uses' => 'SalesController@store']);
        Route::get('sale/deleteitem/{id}', ['as'=>'sale.deleteitem', 'uses'=>'SalesController@destroy']);
        Route::post('sale/action', ['as' => 'sale.action', 'uses' => 'SalesController@action']);
        Route::post('sale/reset', ['as' => 'sale.reset', 'uses' => 'SalesController@clearsale']);
        Route::post('sale/cancel/retur/{id}', ['as' => 'sale.cancel.retur', 'uses' => 'SalesController@cancelreturn']);
        /*End Route Sale*/

        /*Route Payment*/
        Route::get('payment', ['as' => 'payment', 'uses' => 'PaymentController@index']);
        Route::get('payment/create/{id}', ['as' => 'payment.create', 'uses' => 'PaymentController@create']);
        Route::get('payment/revision', ['as' => 'payment.revision', 'uses' => 'PaymentController@revision']);
        Route::post('payment/store', ['as' => 'payment.store', 'uses' => 'PaymentController@store']);
        Route::post('payment/store/revision', ['as' => 'payment.store.revision', 'uses' => 'PaymentController@storeRevision']);

        Route::get('deposit', ['as' => 'deposit', 'uses' => 'DepositController@index']);
        Route::get('deposit/create', ['as' => 'deposit.create', 'uses' => 'DepositController@create']);
        Route::post('deposit/store', ['as' => 'deposit.store', 'uses' => 'DepositController@store']);
        Route::get('deposit/edit/{id}', ['as' => 'deposit.edit', 'uses' => 'DepositController@edit']);

        /*Route PO*/
        Route::get('po', ['as' => 'po', 'uses' => 'POController@index']);
        Route::get('po/print/{id}', ['as' => 'po.print', 'uses' => 'POController@invoice']);
        Route::get('po/create', ['as' => 'po.create', 'uses' => 'POController@create']);
        Route::post('po/additem', ['as' => 'po.additem', 'uses' => 'POController@addItem']);
        Route::post('po/store', ['as' => 'po.store', 'uses' => 'POController@store']);
        Route::get('po/deleteitem/{id}', ['as'=>'po.deleteitem', 'uses'=>'POController@destroy']);
        

        /*Route Receiving*/
        Route::controller('receiving', 'ReceivingController', [
            'anyData'       => 'receiving.data',
            'anyDataPO'     => 'po2.data',
            'getIndex'      => 'receiving'
        ]);

        Route::get('receiving_no/{id}', 'ReceivingController@invoice');
        Route::get('addreceiving/{id}', 'ReceivingController@create_receive');
        Route::get('edit_receiving/{id}', 'ReceivingController@editreceiving');
        Route::post('additem_receiving', 'ReceivingController@add_item');
        Route::post('insert_receiving', 'ReceivingController@store');
        Route::post('updater_eceiving', 'ReceivingController@update');
        Route::post('deletere_ceiving/{id}', 'ReceivingController@destroy');

        Route::get('request_transfer', ['as'=>'request.transfer', 'uses'=>'ReceivingController@invoice']);
        Route::get('process_transfer', ['as'=>'process.transfer', 'uses'=>'ReceivingController@invoice']);
        Route::get('stock_adjustment', ['as'=>'stock.adjustment', 'uses'=>'ReceivingController@invoice']);
        Route::get('stock_opname', ['as'=>'stock.opname', 'uses'=>'ReceivingController@invoice']);

        /*Route Settings*/
        Route::get('setting/general', ['as'=>'setting.general', 'uses'=>'SettingController@general']);
        Route::post('setting/general/store', ['as'=>'setting.general.store', 'uses'=>'SettingController@storeGeneral']);
        Route::get('setting/system', ['as'=>'setting.system', 'uses'=>'SettingController@system']);
        Route::post('setting/system/store', ['as'=>'setting.system.store', 'uses'=>'SettingController@storeSystem']);
        /*End Route Settings*/

        /*Route Report*/
        Route::get('report/sales', ['as'=>'report.sales', 'uses'=>'ReportController@sales']);
        Route::get('report/product', ['as'=>'report.product', 'uses'=>'ReportController@product']);
        /*End Route Supplier*/

        Route::post('change-password', 'Sentinel\UserController@updatePassword');
        Route::get('myprofile', array('as' => 'myprofile', 'uses' => 'Sentinel\UserController@myprofile'));
        Route::post('myprofile', 'Sentinel\UserController@postprofile');
        Route::post('change-avatar', 'Sentinel\UserController@postavatar');

    });

});

