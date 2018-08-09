<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KluiController extends Controller
{
    function __construct() {
        $this->middleware('CustomAuth:a');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['tabel'] = [];
     
        foreach (DB::table('klui')->get() as $item) {
            $objData = new \stdClass();

            $objData->kode = $item->kode;
            $objData->klasifikasi_usaha = $item->klasifikasi_usaha;

            $data['tabel'][] = $objData;
        }

        return view('klui.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];

        return view('klui.tambah', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->input('data') as $key => $value) {
            switch ($key) {
                default:
                    $data[$key] = $value;
                    break;
            }
        }

        DB::table('klui')->insert($data);

        return redirect(action('KluiController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $kode)
    {
        $data['klui'] = DB::table('klui')->where('kode', $kode)->first();    

        return view('klui.ubah', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode)
    {
        foreach ($request->input('data') as $key => $value) {
            switch ($key) {
                default:
                    $data[$key] = $value;
                    break;
            }
        }

        DB::table('klui')->where('kode', $kode)->update($data);

        return redirect(action('KluiController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode)
    {
        DB::table('klui')->where('kode', $kode)->delete();

        return redirect(action('KluiController@index'));
    }
}
