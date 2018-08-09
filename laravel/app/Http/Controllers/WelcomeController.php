<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Dompdf\Dompdf;

use View;

class WelcomeController extends Controller
{
	function pdf($kab_id, $tahun) {
		$data['kabupaten'] = DB::table('kab')->where('id', $kab_id)->first();
		$data['kecamatan'] = DB::table('kec')->where('kab_id', $kab_id)->get();
		$data['tahun'] = $tahun;
		
		$view = View::make('pdf', $data);

        $html = $view->render();
		
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream($tahun . '.pdf', ['Attachment'=>0]);
	}

	function pdfall($tahun) {
		$data['kabupaten'] = DB::table('kab')->where('prop_id', '18')->get();
		$data['tahun'] = $tahun;
		// dd($data);
		// return view('pdfall', $data); die;

		$view = View::make('pdfall', $data);

        $html = $view->render();
		
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream($tahun . '.pdf', ['Attachment'=>0]);
	}

	function ajaxKabupaten() {
		?>
		<option value="0">Semua</option>
		<?php
		foreach (DB::table('kab')->where('prop_id', '18')->get() as $item) {
			?>
			<option value="<?php echo $item->id; ?>"><?php echo ucwords(strtolower($item->nama_kab)); ?></option>
			<?php
		}
	}

	function ajaxChart1($kab_id) {
		for ($i=date('Y') - 4; $i <= date('Y'); $i++) {
              $array[] = $i;
        }
        foreach ($array as $item) {
              $data['labels'][] = $item;
        }
        unset($array);

        $objPerusahaan = new \stdClass();
        $objPerusahaan->label = 'Perusahaan';
        $objPerusahaan->fillColor = "rgba(220,220,220,0.2)";
        $objPerusahaan->strokeColor = "rgba(220,220,220,1)";
        $objPerusahaan->pointColor = "rgba(220,220,220,1)";
        $objPerusahaan->pointStrokeColor = "#fff";
        $objPerusahaan->pointHighlightFill = "#fff";
        $objPerusahaan->pointHighlightStroke = "rgba(220,220,220,1)";

        $perusahaan = 'SELECT count(pe.id) total
												FROM perusahaan pe, desa de, kec ke, kab ka, prop pr, klui kl
												WHERE pe.desa_id = de.id
												AND de.kec_id = ke.id
												AND ke.kab_id = ka.id
												AND ka.prop_id = pr.id
												AND pe.kode_klui = kl.kode
												AND YEAR(DATE_ADD(berlaku_sampai, INTERVAL - 1 YEAR)) = ? ';
		if ($kab_id != 0) {
			$perusahaan .= 'AND ka.id = ' . $kab_id;
		}												

		for ($i=date('Y') - 4; $i <= date('Y'); $i++) {
              $array[] = $results = DB::select($perusahaan, [$i])[0]->total;    
        }
        foreach ($array as $item) {
              $valPerusahaan[] = $item != null ? (int)$item : 0; 
        }
        unset($array);
        

        $objPerusahaan->data = $valPerusahaan;

        $objTenagaKerja = new \stdClass();
        $objTenagaKerja->label = 'Tenaga Kerja';
        $objTenagaKerja->fillColor = "rgba(151,187,205,0.2)";
        $objTenagaKerja->strokeColor = "rgba(151,187,205,1)";
        $objTenagaKerja->pointColor = "rgba(151,187,205,1)";
        $objTenagaKerja->pointStrokeColor = "#fff";
        $objTenagaKerja->pointHighlightFill = "#fff";
        $objTenagaKerja->pointHighlightStroke = "rgba(151,187,205,1)";

        $tenaga_kerja = 'SELECT sum(tkl+tkp+tkal+tkap) total
												FROM perusahaan pe, desa de, kec ke, kab ka, prop pr, klui kl
												WHERE pe.desa_id = de.id
												AND de.kec_id = ke.id
												AND ke.kab_id = ka.id
												AND ka.prop_id = pr.id
												AND pe.kode_klui = kl.kode
												AND YEAR(DATE_ADD(berlaku_sampai, INTERVAL - 1 YEAR)) = ? ';
		if ($kab_id != 0) {
			$tenaga_kerja .= 'AND ka.id = ' . $kab_id;
		}
        
		for ($i=date('Y') - 4; $i <= date('Y'); $i++) {
              $array[] = $results = DB::select($tenaga_kerja, [$i])[0]->total;    
        }
        foreach ($array as $item) {
              $valTenagaKerja[] = $item != null ? (int)$item : 0;
        }
        unset($array);
        $objTenagaKerja->data = $valTenagaKerja;

        $data['datasets'][] = $objPerusahaan;
        $data['datasets'][] = $objTenagaKerja;

        echo json_encode($data);
	}

	function ajaxChart11($kab_id, $tahun) {
		$faker = \Faker\Factory::create();
		$kecamatan = DB::table('kec')->where('kab_id', $kab_id)->get();
		$data = [];

		foreach ($kecamatan as $item) {
			$objPerusahaan = new \stdClass();

      		$perusahaan = 'SELECT count(pe.id) total
							FROM perusahaan pe, desa de, kec ke, kab ka, prop pr, klui kl
							WHERE pe.desa_id = de.id
							AND de.kec_id = ke.id
							AND ke.kab_id = ka.id
							AND ka.prop_id = pr.id
							AND pe.kode_klui = kl.kode
							AND YEAR(DATE_ADD(berlaku_sampai, INTERVAL - 1 YEAR)) = ' . $tahun . ' 
							AND ke.id = ?';
      		$objPerusahaan->value = DB::select($perusahaan, [$item->id])[0]->total;
      		$objPerusahaan->color = $faker->hexcolor;
      		$objPerusahaan->highlight = "#5AD3D1";
      		$objPerusahaan->label = ucwords(strtolower($item->nama_kec));

      		$data[] = $objPerusahaan;
  		}

  		echo json_encode($data);
	}

	function ajaxChart12($kab_id, $tahun) {
		$faker = \Faker\Factory::create();
		$kecamatan = DB::table('kec')->where('kab_id', $kab_id)->get();
		$data = [];

		foreach ($kecamatan as $item) {
			$objTenagaKerja = new \stdClass();

      		$tenagaKerja = 'SELECT sum(tkl+tkp+tkal+tkap) total
									FROM perusahaan pe, desa de, kec ke, kab ka, prop pr, klui kl
									WHERE pe.desa_id = de.id
									AND de.kec_id = ke.id
									AND ke.kab_id = ka.id
									AND ka.prop_id = pr.id
									AND pe.kode_klui = kl.kode
									AND YEAR(DATE_ADD(berlaku_sampai, INTERVAL - 1 YEAR)) = ' . $tahun . ' 
									AND ke.id = ?';
      		$objTenagaKerja->value = DB::select($tenagaKerja, [$item->id])[0]->total != null ? DB::select($tenagaKerja, [$item->id])[0]->total : 0;
      		$objTenagaKerja->color = $faker->hexcolor;
      		$objTenagaKerja->highlight = "#5AD3D1";
      		$objTenagaKerja->label = ucwords(strtolower($item->nama_kec));

      		$data[] = $objTenagaKerja;
  		}

  		echo json_encode($data);
	}

	function index(Request $request) {
		if (session('login') == true) {
			$data['kabupaten'] = DB::table('kab')->where('prop_id', '18')->get();
			return view('welcome.index', $data);
		} else {
			return view('template.login');
		}
	}

	function login(Request $request) {
		$username = $request->input('username');
		$password = $request->input('password');

		$select_user = DB::table('user')->where(['username' => $username])->first();
		
		if ($select_user != null && Hash::check($password, $select_user->password)) {
			$array_data_user = array(
				'id'  => $select_user->id,
				'nama'  => $select_user->nama,
				'username'  => $select_user->username,
				'level'  => $select_user->level,
				'kab_id'  => $select_user->kab_id,
				'login'  => true
			);

			session($array_data_user);
			
			echo json_encode(['login' => true]);
		} else {
			$data['header'] = "ERROR !!!";
			$data['pesan'] = "Password Salah !!!";
			$data['status'] = "error";
			
			$data['login'] = false;

			echo json_encode($data);
		}
	}

	function logout() {
		session()->flush();

		return redirect()->action('WelcomeController@index');
	}

	function profil() {
		
	}

	function ubahProfil() {
		
	}

	function gantiPassword() {
		
	}

}
