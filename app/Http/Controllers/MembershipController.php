<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberships = Membership::all();
        return view('admin/membership', ['data' => $memberships]);
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
            'diskon' => 'required|numeric',
            'min_profit' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid Input'], 400);
        };

        $membership = new Membership();
        $membership->nama = strtolower($request->input('nama'));
        $membership->diskon = $request->input('diskon');
        $membership->min_profit = $request->input('min_profit');
        $membership->save();

        return response()->json($membership,200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $membership = Membership::where('id', '=', $id)->first()    ;
        if(!$membership) return response()->json(['message'=> 'not foudn']);
        return response()->json($membership, 200);
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
        $membership = Membership::where('id', $id)->first();
        if(!$membership) {
            return response()->json(['message'=> 'Membership not found'], 404);
        };

        $validator = Validator::make($request->all(), [
            'nama' => 'string|min:4',
            'diskon' => 'numeric',
            'min_profit' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid Input'], 400);
        };

        $membership->nama = $request->input('nama');
        $membership->diskon = $request->input('diskon');
        $membership->min_profit = $request->input('min_profit');
        $membership->save();

        return response()->json($membership, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $membership = Membership::where('id', $id)->first();
        if(!$membership) {
            return response()->json(['message'=> 'Membership not found'], 404);
        };

        $membership->delete();
        return response('', 204);
    }
}
