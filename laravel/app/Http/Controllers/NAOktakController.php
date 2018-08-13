<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NAOktakController extends Controller
{
	function index() {
		$data = [];

		$data['nis'] = '15753003';

		$mapel = DB::table('na_mapel')->get();

		foreach ($mapel as $item) {
			$tabel = new \stdClass();

			$tabel->id_mapel = $item->id;
			$tabel->mapel = $item->mata_pelajaran;
			$tabel->tugas = DB::table('na_nilai')
							->where('nis', $data['nis'])
							->where('tipe_nilai', 'tugas')
							->where('mapel_id', $item->id)
							->first()->nilai;							
			$tabel->uh = DB::table('na_nilai')
							->where('nis', $data['nis'])
							->where('tipe_nilai', 'uh')
							->where('mapel_id', $item->id)
							->first()->nilai;							
			$tabel->uas = DB::table('na_nilai')
							->where('nis', $data['nis'])
							->where('tipe_nilai', 'uas')
							->where('mapel_id', $item->id)
							->first()->nilai;							
			$tabel->na = ($tabel->tugas * 25 / 100) + ($tabel->uh * 65 / 100) + ($tabel->uas * 10 / 100);

			$data['tabel'][] = $tabel;
		}

		return view('naoktak.index', $data);
	}
}
