<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Apfelbox\FileDownload\FileDownload;

class PerusahaanController extends Controller
{
    function __construct() {
        $this->middleware('CustomAuth:a,k');
    }

    function showPdf($id) {
        $perusahaan = DB::table('perusahaan')->where('id', $id)->first();

        $data['title'] = $perusahaan->berkas;
        $data['body'] = '<object data="' . action('WelcomeController@index') . '/uploads/perusahaan/' . $perusahaan->id . '"></object>';

        echo json_encode($data);
    }

    function download($id) {
        $perusahaan = DB::table('perusahaan')->where('id', $id)->first();

        $fileDownload = FileDownload::createFromFilePath('uploads/perusahaan/' . $perusahaan->id);
        $fileDownload->sendDownload($perusahaan->berkas);
    }

      function ajaxProvinsi() {
        ?>
        <option value="">Silahkan Pilih</option>
        <?php
        foreach (DB::table('prop')->get() as $item) {
          ?>
          <option value="<?php echo $item->id; ?>"><?php echo ucwords(strtolower($item->nama_prop)); ?></option>
          <?php
        }
      }

      function ajaxKabupaten($prop_id) {
        ?>
        <option value="">Silahkan Pilih</option>
        <?php
        foreach (DB::table('kab')->where('prop_id', $prop_id)->get() as $item) {
          ?>
          <option value="<?php echo $item->id; ?>"><?php echo ucwords(strtolower($item->nama_kab)); ?></option>
          <?php
        }
      }

      function ajaxKecamatan($kab_id) {
        ?>
        <option value="">Silahkan Pilih</option>
        <?php 
        foreach (DB::table('kec')->where('kab_id', $kab_id)->get() as $item) {
          ?>
          <option value="<?php echo $item->id; ?>"><?php echo ucwords(strtolower($item->nama_kec)); ?></option>
          <?php
        }
      }

      function ajaxKelurahan($kec_id) {
        ?>
        <option value="">Silahkan Pilih</option>
        <?php 
        foreach (DB::table('desa')->where('kec_id', $kec_id)->get() as $item) {
          ?>
          <option value="<?php echo $item->id; ?>"><?php echo ucwords(strtolower($item->nama_desa)); ?></option>
          <?php
        }
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $data['tabel'] = [];

      if (session('kab_id') != null) {
        $kab_id = session('kab_id');
      } else {
        if ($request->input('kab_id') != null && $request->input('kab_id') == '0') {
          $kab_id = null;
        } else {
          $kab_id = $request->input('kab_id');
        }
      }

        if ($request->input('tahun') != null) {
          $perusahaan = 'SELECT *, pe.id perusahaan_id, DATE_ADD(berlaku_sampai, INTERVAL - 1 YEAR) tanggal_daftar
                  FROM perusahaan pe, desa de, kec ke, kab ka, prop pr, klui kl
                  WHERE pe.desa_id = de.id
                  AND de.kec_id = ke.id
                  AND ke.kab_id = ka.id
                  AND ka.prop_id = pr.id
                  AND pe.kode_klui = kl.kode
                  AND YEAR(DATE_ADD(berlaku_sampai, INTERVAL - 1 YEAR)) = ?';
          if ($kab_id != null) {
            $perusahaan .= ' AND ka.id = ' . $kab_id;
          }
          $perusahaan = DB::select($perusahaan, [$request->input('tahun')]);
        } else {
          $perusahaan = 'SELECT *, pe.id perusahaan_id, DATE_ADD(berlaku_sampai, INTERVAL - 1 YEAR) tanggal_daftar
                  FROM perusahaan pe, desa de, kec ke, kab ka, prop pr, klui kl
                  WHERE pe.desa_id = de.id
                  AND de.kec_id = ke.id
                  AND ke.kab_id = ka.id
                  AND ka.prop_id = pr.id
                  AND pe.kode_klui = kl.kode';
          if ($kab_id != null) {
            $perusahaan .= ' AND ka.id = ' . $kab_id;
          }
          $perusahaan = DB::select($perusahaan, []);
        }

        foreach ($perusahaan as $item) {
            $objData = new \stdClass();

            $objData->id = $item->perusahaan_id;  
            $objData->no = str_pad($item->perusahaan_id, 5, '0', STR_PAD_LEFT);
            $objData->nama = $item->nama;
            $objData->alamat = $item->alamat;
            $objData->desa_id = $item->desa_id;
            $objData->desa = DB::table('desa')->where('id', $item->desa_id)->first();
            $objData->kecamatan = DB::table('kec')->where('id', $objData->desa->kec_id)->first();
            $objData->kabupaten = DB::table('kab')->where('id', $objData->kecamatan->kab_id)->first();
            $objData->provinsi = DB::table('prop')->where('id', $objData->kabupaten->prop_id)->first();
            $objData->desa = ucwords(strtolower($objData->desa->nama_desa));
            $objData->kecamatan = ucwords(strtolower($objData->kecamatan->nama_kec));
            $objData->kabupaten = ucwords(strtolower($objData->kabupaten->nama_kab));
            $objData->provinsi = ucwords(strtolower($objData->provinsi->nama_prop));
            $objData->pemilik = $item->pemilik;
            $objData->tanggal_daftar = tanggalIndo($item->tanggal_daftar);
            $objData->klasifikasi_usaha = DB::table('klui')->where('kode', $item->kode_klui)->first()->klasifikasi_usaha;
            $objData->kode_klui = $item->kode_klui;
            $objData->tkl = number_format($item->tkl,0,',','.');
            $objData->tkp = number_format($item->tkp,0,',','.');
            $objData->tkal = number_format($item->tkal,0,',','.');
            $objData->tkap = number_format($item->tkap,0,',','.');
            $objData->upah_terendah = "Rp " . number_format($item->upah_terendah,2,',','.');
            $objData->status_perusahaan = $item->status_perusahaan == 'c' ? 'Cabang' : 'Pusat';
            $objData->berlaku_sampai = tanggalIndo($item->berlaku_sampai);
            $objData->berkas = $item->berkas;

            $data['tabel'][] = $objData;
        }

        $data['tahun'] = $request->input('tahun');
        $data['kab_id'] = $request->input('kab_id');

        $data['kabupaten'] = DB::table('kab')->where('prop_id', '18')->get();

        return view('perusahaan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $data['klui'] = DB::table('klui')->get();

        return view('perusahaan.tambah', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $berkas = $_FILES['berkas'];

        if ($berkas['size'] != 0) {
            $data['berkas'] = $berkas['name'];
        }

        foreach ($request->input('data') as $key => $value) {
            switch ($key) {
                case 'berlaku_sampai':
                    $date=date_create($value);
                    $data[$key] = date_format($date,"Y-m-d");
                    break;
                case 'upah_terendah':
                    $data[$key] = str_replace(".","",$value);
                    break;
                default:
                    $data[$key] = $value;
                    break;
            }
        }

        $id = DB::table('perusahaan')->insertGetId($data);

        if ($berkas['size'] != 0) {
            move_uploaded_file($berkas['tmp_name'], 'uploads/perusahaan/' . $id);
        }

        return redirect(action('PerusahaanController@index'));
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
        $data['klui'] = DB::table('klui')->get();
        $data['perusahaan'] = DB::table('perusahaan')->where('id', $id)->first();    
        
        $data['kelurahan'] = DB::table('desa')->where('id', $data['perusahaan']->desa_id)->first();    
        $data['kecamatan'] = DB::table('kec')->where('id', $data['kelurahan']->kec_id)->first();    
        $data['kabupaten'] = DB::table('kab')->where('id', $data['kecamatan']->kab_id)->first();    
        $data['provinsi'] = DB::table('prop')->where('id', $data['kabupaten']->prop_id)->first();    

        $data['kelurahan'] =  $data['kelurahan']->id;
        $data['kecamatan'] =  $data['kecamatan']->id;
        $data['kabupaten'] =  $data['kabupaten']->id;
        $data['provinsi'] =  $data['provinsi']->id;

        return view('perusahaan.ubah', $data);
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
        $berkas = $_FILES['berkas'];

        if ($berkas['size'] != 0) {
            $data['berkas'] = $berkas['name'];
        }

        foreach ($request->input('data') as $key => $value) {
            switch ($key) {
                case 'berlaku_sampai':
                    $date=date_create($value);
                    $data[$key] = date_format($date,"Y-m-d");
                    break;
                case 'upah_terendah':
                    $data[$key] = str_replace(".","",$value);
                    break;
                default:
                    $data[$key] = $value;
                    break;
            }
        }

        DB::table('perusahaan')->where('id', $id)->update($data);

        if ($berkas['size'] != 0) {
            move_uploaded_file($berkas['tmp_name'], 'uploads/perusahaan/' . $id);
        }

        return redirect(action('PerusahaanController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('perusahaan')->where('id', $id)->delete();

        if (file_exists('uploads/perusahaan/' . $id)) {
            unlink('uploads/perusahaan/' . $id);
        }

        return redirect(action('PerusahaanController@index'));
    }
}
