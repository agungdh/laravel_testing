@extends('template.template')

@section('nav')
  @include('klui.nav')
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Tambah KLUI</h3>
      <div class="tile-body">
        <form method="post" action="{{ action('KluiController@store') }}">
          @csrf

          <div class="form-group">
            <label class="control-label">Kode</label>
            <input class="form-control" type="text" required placeholder="Masukan Kode" name="data[kode]">
          </div>

          <div class="form-group">
            <label class="control-label">Klasifikasi Usaha</label>
            <input class="form-control" type="text" required placeholder="Masukan Klasifikasi Usaha" name="data[klasifikasi_usaha]">
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="{{ action('KluiController@index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
          </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$('#simpan').click(function(){
  $("input[type='submit']").click();
});

$('.select2').select2();
</script>
@endsection