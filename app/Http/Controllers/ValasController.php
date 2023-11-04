<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valas;
use Illuminate\Support\Facades\Validator;

class ValasController extends Controller
{
    /**
     * @param int $id
     * @return Valas
     */
    public function findOne($id) {
        $v = Valas::where('id', '=', $id)->first();
        return $v;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $v = Valas::all();
        $userRole = $req->user()->role;
        $userName = $req->user()->name;
        return view('admin/valas', ['valas' => $v, 'role' => $userRole, 'nama' => $userName]);
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
        $validator = Validator::make($request->all(),[
            'nama_valas' => 'string|required|min: 4',
            'nilai_jual' => 'numeric|required|min:1',
            'nilai_beli' => 'numeric|required|min:1',
            'tanggal_rate' => 'string|required|size:10  '
        ]);
        if($validator->fails()) {
            return response()->json(['message' => 'Missing required fields'], 400);
        };

        $v = new Valas();
        $v->nama_valas = $request->input('nama_valas');
        $v->nilai_jual = $request->input('nilai_jual');
        $v->nilai_beli = $request->input('nilai_beli');
        $v->tanggal_rate = $request->input('tanggal_rate');
        $v->save();
        return response()->json($v, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return self::findOne($id);
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
        $v = self::findOne($id);
        if(!$v) {
            return response()->json(['message' => 'Not Found'], 404);
        };
        $validator = Validator::make($request->all(),[
            'nama_valas' => 'string|required|min: 4',
            'nilai_jual' => 'numeric|required|min:1',
            'nilai_beli' => 'numeric|required|min:1',
            'tanggal_rate' => 'string|required|size:10'
        ]);
        if($validator->fails()) {
            return response()->json(['message' => 'Missing required fields'], 400);
        };

        $v->nama_valas = $request->input('nama_valas');
        $v->nilai_jual = $request->input('nilai_jual');
        $v->nilai_beli = $request->input('nilai_beli');
        $v->tanggal_rate = $request->input('tanggal_rate');
        $v->save();

        return $v;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $v = self::findOne($id);
        if(!$v) {
            return response()->json(['message' => 'Not Found'], 404);
        };
        $v->delete();
        return response('', 204);
    }
}
