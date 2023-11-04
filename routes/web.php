<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ValasController;
use App\Models\Customer;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resources([
    'customer' => CustomerController::class,
    'membership' => MembershipController::class,
    'valas' => ValasController::class,
    'transaksi' => TransaksiController::class 
]);

Route::put('/change-membership', function(Request $request) {
    $validator = Validator::make($request->all(), [
        'customer_id' => 'numeric|required|min:1',
        'membership_id' => 'numeric|required|min:1'
    ]);

    if($validator->fails()) return response()->json(['message' => 'Missing required fields'], 400);

    $membership = Membership::where('id', '=', $request->input('membership_id'))->first();
    if(!$membership) return response()->json(['message' => 'Invalid Member'], 404);

    $customer = Customer::where('id', '=', $request->input('customer_id'))->first();
    if(!$customer) return response()->json(['message' => 'Invalid Customer'], 404);

    $customer->tipe_member = $membership->id;
    $customer->save();

    return response()->json($customer, 200);
});

Route::get('/change-membership', function() {
    $customers = Customer::all();
    foreach($customers as $c) {
        $c->membership;
    };
    $memberships = Membership::all();
    return view('superadmin/change-membership', ['customers' => $customers, 'memberships' => $memberships]);
});

Route::get('/', function () {
    $valas = DB::table('valas')->select('nama_valas')->groupBy('nama_valas')->get();
    return view('index', ['valas' =>$valas]);
})->middleware('auth');

require __DIR__.'/auth.php';
