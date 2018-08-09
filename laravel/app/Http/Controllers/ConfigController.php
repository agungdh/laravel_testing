<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
	function __construct() {
	    $this->middleware('CustomAuth:a');
	}

	function index() {
		$data['config'] = DB::table('config')->first();

        return view('config.index', $data);
	}

	function update(Request $request) {
		DB::table('config')->update(['judul_aplikasi' => $request->input('judul_aplikasi'),
										'judul_menu' => $request->input('judul_menu')]);

		if ($_FILES['foto']['size'] != 0) {
			$tmpName = 'uploads/temp/' . session('id') . strtotime(now());

			move_uploaded_file($_FILES['foto']['tmp_name'], $tmpName);

			$image = new \Gumlet\ImageResize($tmpName);
			$image->crop(64, 64);
			$image->save('uploads/favicon');

			unlink($tmpName);
		}

		return redirect(action('WelcomeController@index'));
	}
}
