<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\Valas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * @return Transaksi
     * @param int $id
     */
    public function findOne($id) {
        $t = Transaksi::where('id', '=', $id)->first();
        return $t;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::all();
        foreach($transaksi as $t) {
            $t->detail;
            $t->customer;
        };
        $customer = Customer::all();
        $valas = Valas::whereDate('tanggal_rate', DB::raw('CURDATE()'))->get();
        return view('superadmin/transaksi', ['data' => $transaksi, 'customer'=> $customer, 'valas' => $valas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor' => 'required|string|min:4',
            'customer_id' => 'required|numeric|min:1',
            'valas_id' => 'required|numeric|min:1',
            'qty' => 'required|numeric|min:1'
        ]);

        if($validator->fails()) {
            return response()->json(['message' => 'Missing required fields'], 400);
        };

        $customer = Customer::where('id', '=', $request->input('customer_id'))->first();
        $valas = Valas::where('id', '=', $request->input('valas_id'))->first();
        if(!$customer || !$valas) {
            return response()->json(['message' => 'Invalid Customer or Valas Id'], 404);
        };
        //populate
        $customer->membership;
        //validasi jual dan beli
        $jenis = explode("-", $request->input('nomor'))[1];
        $rate = 0;
        $appliedDiscount = 0;
        if(strtolower($jenis) === 'jual') {
            $rate = $valas->nilai_jual;
        } else {
            $rate = $valas->nilai_beli;
            $appliedDiscount = $customer->membership->diskon;
        };

        $tagihan = $rate * $request->input('qty');
        $t = new Transaksi();
        $t->nomor = $request->input('nomor');
        $t->customer_id = $request->input('customer_id');
        $t->diskon = $appliedDiscount * $tagihan;
        $t->save();

        $dt = new DetailTransaksi();
        $dt->transaksi_id= $t->id;
        $dt->nama_valas = $valas->nama_valas;
        $dt->rate = $rate;
        $dt->qty = $request->input('qty');
        $dt->save();

        $t->detail;

        return $t;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $t = self::findOne($id);
        if(!$t) return response()->json(['message'=> 'not found'], 404);
        $t->detail;
        $t->customer;
        return response()->json($t);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'nomor' => 'required|string|min:4',
            'customer_id' => 'required|numeric|min:1',
            'qty' => 'required|numeric|min:1'
        ]);

        if($validator->fails()) {
            return response()->json(['message' => 'Missing required fields'], 400);
        };

        $t = self::findOne($id);
        if(!$t) return response()->json(['message' => 'not found'], 404);
        $t->detail;
        $t->nomor = $request->input('nomor');
        $t->customer_id = $request->input('customer_id');
        $t->detail->qty = $request->input('qty');
        //Saving
        $t->save();
        $t->detail->save();

        return $t;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $t = self::findOne($id);
        if(!$t) return response()->json(['message'=> 'not found']);
        $t->delete();
        return response('', 204);
    }
}
