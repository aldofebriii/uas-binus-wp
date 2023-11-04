<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('report-transaksi', function() {
    //Untung per membership
    $jual_member = DB::table('detail_transaksi')->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')->join('customers', 'transaksi.customer_id', '=', 'customers.id')->join('membership', 'customers.tipe_member', '=', 'membership.id')->select('membership.nama AS membership', DB::raw("SUM(CASE WHEN LEFT(nomor, 4) = 'jual' THEN rate ELSE -rate END) AS profit"))->groupBy('membership.nama')->get(); 

    $total_untung = DB::table('detail_transaksi')->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')->select(DB::raw("SUM(CASE WHEN LEFT(nomor, 4) = 'jual' THEN rate ELSE -rate END) AS profit"))->first();
    return response()->json(['member' => $jual_member, 'total' => $total_untung]);
});

Route::get('report-valas/{nama_valas}', function(string $nama_valas) {
    $valas = DB::table('valas')->where('nama_valas', '=', $nama_valas)->orderBy('tanggal_rate', 'asc')->get();
    return $valas;
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
