@extends('template.template')

@section('nav')
  @include('perusahaan.nav')
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Tambah Perusahaan</h3>
      <div class="tile-body">
        <form method="post" action="{{ action('PerusahaanController@store') }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label class="control-label">Nama</label>
            <input class="form-control" type="text" required placeholder="Masukan Nama" name="data[nama]">
          </div>

          <div class="form-group">
            <label class="control-label">Alamat</label>
            <input class="form-control" type="text" required placeholder="Masukan Alamat" name="data[alamat]">
          </div>

          <div class="form-group">
            <label for="provinsi">Provinsi</label>
                <select required class="form-control" id="provinsi" name="provinsi">    
                </select>      
          </div>

          <div class="form-group">
            <label for="kabupaten">Kabupaten</label>
                <select required class="form-control" id="kabupaten" name="kabupaten">    
                </select>      
          </div>

          <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
                <select required class="form-control" id="kecamatan" name="kecamatan">    
                </select>      
          </div>

          <div class="form-group">
            <label for="kelurahan">Kelurahan</label>
                <select required class="form-control" id="kelurahan" name="data[desa_id]">    
                </select>      
          </div>

          <div class="form-group">
            <label class="control-label">Pemilik</label>
            <input class="form-control" type="text" required placeholder="Masukan Pemilik" name="data[pemilik]">
          </div>

          <div class="form-group">
            <label class="control-label">KLUI</label>
            <select class="form-control select2" required name="data[kode_klui]">
              @foreach ($klui as $item) {
                <option value="{{ $item->kode }}">{{ '[' . $item->kode . '] ' . $item->klasifikasi_usaha }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label class="control-label">Tenaga Kerja Laki-Laki</label>
            <input class="form-control" type="number" min="0" required placeholder="Masukan Tenaga Kerja Laki-Laki" name="data[tkl]">
          </div>

          <div class="form-group">
            <label class="control-label">Tenaga Kerja Perempuan</label>
            <input class="form-control" type="number" min="0" required placeholder="Masukan Tenaga Kerja Perempuan" name="data[tkp]">
          </div>

          <div class="form-group">
            <label class="control-label">Tenaga Kerja Asing Laki-Laki</label>
            <input class="form-control" type="number" min="0" required placeholder="Masukan Tenaga Kerja Asing Laki-Laki" name="data[tkal]">
          </div>

          <div class="form-group">
            <label class="control-label">Tenaga Kerja Asing Perempuan</label>
            <input class="form-control" type="number" min="0" required placeholder="Masukan Tenaga Kerja Asing Perempuan" name="data[tkap]">
          </div>

          <div class="form-group">
            <label class="control-label">Upah Terendah</label>
            <input class="form-control uang" type="text" required placeholder="Masukan Upah Terendah" name="data[upah_terendah]">
          </div>

          <div class="form-group">
            <label class="control-label">Status Perusahaan</label>
            <select class="form-control select2" required name="data[status_perusahaan]">
              <option value="p">Pusat</option>
              <option value="c">Cabang</option>
            </select>
          </div>

          <div class="form-group">
            <label class="control-label">Berlaku Sampai</label>
            <input class="form-control datepicker" type="text" required placeholder="Masukan Berlaku Sampai" name="data[berlaku_sampai]">
          </div>

          <div class="form-group">
            <label class="control-label">Berkas</label>
            <input class="form-control" type="file" name="berkas" id="berkas">
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="{{ action('PerusahaanController@index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
          </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$('form').submit(function() {
  if ($("#berkas").val() != '') {
      var berkas = $("#berkas").val().split(".");
      if (berkas[berkas.length - 1] != 'pdf') {
       // alert('gagal !!!');
       swal('ERROR !!!', 'Hanya file PDF yang boleh diupload', 'error');
       return false;
      } else {
       // alert('good !!!');
       return true;
      }
  }
});

$( '.uang' ).mask('0.000.000.000.000', {reverse: true});

$('.datepicker').datepicker({
  format: "dd-mm-yyyy",
  autoclose: true,
  todayHighlight: true
});

$('#simpan').click(function(){
  $("input[type='submit']").click();
});

$('.select2').select2();

$(function() {
    $("#provinsi").prop('disabled', true);
    $("#kabupaten").prop('disabled', true);
    $("#kecamatan").prop('disabled', true);
    $("#kelurahan").prop('disabled', true);

    $.ajax({
      url: "{{ action('PerusahaanController@index') . '/' . 'ajaxprovinsi' }}",
      success: function(result){
          $("#provinsi").html(result);
          $("#provinsi").val("18");
          $("#provinsi").select2();

          $.ajax({
            url: "{{ action('PerusahaanController@index') . '/' . 'ajaxkabupaten/' }}" + $("#provinsi").val(),
            success: function(result){
                $("#kabupaten").html(result);
                $("#kabupaten").prop('disabled', false);
                $("#kabupaten").select2();
            }
          });
      }
    });
  });

  $("#kabupaten").change(function() {
    $.ajax({
      url: "{{ action('PerusahaanController@index') . '/' . 'ajaxkecamatan/' }}" + $("#kabupaten").val(),
      success: function(result){
          $("#kecamatan").html(result);
          $("#kecamatan").prop('disabled', false);
          $("#kecamatan").select2();
      }
    });
  });

  $("#kecamatan").change(function() {
    $.ajax({
      url: "{{ action('PerusahaanController@index') . '/' . 'ajaxkelurahan/' }}" + $("#kecamatan").val(),
      success: function(result){
          $("#kelurahan").html(result);
          $("#kelurahan").prop('disabled', false);
          $("#kelurahan").select2();
      }
    });
  });
</script>
@endsection