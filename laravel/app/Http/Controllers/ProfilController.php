<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
	function __construct() {
	    $this->middleware('CustomAuth:a,k');
	}

	function index() {
		$data['user'] = DB::table('user')->where('id', session('id'))->first();

        return view('profil.index', $data);
	}

	function ubah(Request $request) {
		DB::table('user')->update(['nama' => $request->input('nama')]);

		session(['nama' => $request->input('nama')]);

		if ($_FILES['foto']['size'] != 0) {
			$tmpName = 'uploads/temp/' . session('id') . strtotime(now());

			move_uploaded_file($_FILES['foto']['tmp_name'], $tmpName);

			$image = new \Gumlet\ImageResize($tmpName);
			$image->crop(64, 64);
			$image->save('uploads/userimage/' . session('id'));

			unlink($tmpName);
		}

		return redirect(action('WelcomeController@index'));
	}

	function gantiPassword(Request $request) {
		DB::table('user')->where('id', session('id'))->update(['password' => hash::make($request->input('password'))]);

		return redirect(action('WelcomeController@index'));
	}
}
