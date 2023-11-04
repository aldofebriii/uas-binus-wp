<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * @param int $id
     * @return Customer
     */
    public function findOne($id) {
        $customer = Customer::where('id', '=', $id)->first();
        return $customer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        foreach($customers as $c) {
            $c->membership;
        };
        return view('admin/customer', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nama' => 'required|string|min:4',
            'alamat' => 'required|string|min:5'
        ]);
        
        if($validator->fails()) {
            return response()->json(['message' => 'Missing required fields'], 400);
        };

        $customer = new Customer();
        $customer->nama = $request->input('nama');
        $customer->alamat = $request->input('alamat');
        $m = Membership::where('diskon', '=', 0)->first();
        if(!$m) {
            return response()->json(['message' => 'Invalid Membership'], 400);
        };
        $customer->tipe_member = $m->id;
        $customer->save();

        return response()->json($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = self::findOne($id);
        if(!$customer) {
            return response()->json(['message' => 'Invalid Id'], 404);
        };
        $customer->membership;
        return $customer;
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
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:4',
            'alamat' => 'required|string|min:5',
            "tipe_member" => 'numeric|min:1'
        ]);

        if($validator->fails()) {
            return response()->json(['message' => 'Missing required fields'], 400);
        };

        $customer = self::findOne($id);
        if(!$customer) {
            return response()->json(['message' => 'Invalid Id'], 404);
        };
        if($request->input('tipe_member')){
            if(!Membership::where('id', '=', $request->input('tipe_member'))->first()) return response()->json(['message' => 'not found membership'], 404);
            $customer->tipe_member = $request->input('tipe_member');

        };
        $customer->nama = $request->input('nama');
        $customer->alamat = $request->input('alamat');
        $customer->save();
        
        return response()->json($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = self::findOne($id);
        if(!$customer) {
            return response()->json(['message' => 'Invalid Id'], 404);
        };

        $customer->membership;
        $customer->delete();
        return response('', 204);
    }
};
