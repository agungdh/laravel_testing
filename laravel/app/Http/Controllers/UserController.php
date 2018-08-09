<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function __construct() {
        $this->middleware('CustomAuth:a');
    }   

    function gantiPassword(Request $request, $id) {
        DB::table('user')->where('id', $id)->update(['password' => hash::make($request->input('password'))]);

        return redirect(action('UserController@index'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $data['tabel'] = [];

        foreach (DB::table('user')->get() as $item) {
            $objData = new \stdClass();

            $objData->id = $item->id;  
            $objData->username = $item->username;  
            $objData->nama = $item->nama;  
            $objData->level = $item->level == 'a' ? 'Administrator' : 'Kabupaten';  
            $objData->kabupaten = $item->kab_id != null ? ucwords(strtolower(DB::table('kab')->where('id', $item->kab_id)->first()->nama_kab)) : '-';

            $data['tabel'][] = $objData;
        }

        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $data['kabupaten'] = DB::table('kab')->where('prop_id', '18')->get();

        return view('user.tambah', $data);
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
                case 'password':
                  $data[$key] = hash::make($value);
                  break;
                default:
                    $data[$key] = $value;
                    break;
            }
        }

        if ($data['level'] == 'a') {
          $data['kab_id'] = null;
        }

        DB::table('user')->insert($data);

        return redirect(action('UserController@index'));
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
    public function edit(Request $request, $id)
    {
        $data['kabupaten'] = DB::table('kab')->where('prop_id', '18')->get();
        $data['user'] = DB::table('user')->where('id', $id)->first();    
        
        return view('user.ubah', $data);
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
        foreach ($request->input('data') as $key => $value) {
            switch ($key) {
                case 'password':
                  $data[$key] = hash::make($value);
                  break;
                default:
                    $data[$key] = $value;
                    break;
            }
        }

        if ($data['level'] == 'a') {
          $data['kab_id'] = null;
        }

        DB::table('user')->where('id', $id)->update($data);

        return redirect(action('UserController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('user')->where('id', $id)->delete();

        return redirect(action('UserController@index'));
    }
}
