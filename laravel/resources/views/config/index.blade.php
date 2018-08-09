@extends('template.template')

@section('nav')
  @include('config.nav')
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Config</h3>
      <div class="tile-body">
        <form method="post" action="{{ action('ConfigController@update') }}" enctype="multipart/form-data">
          @method('put')
          @csrf

          <div class="form-group">
            <label class="control-label">Judul Aplikasi</label>
            <input class="form-control" type="text" value="{{ $config->judul_aplikasi }}" required placeholder="Masukan Judul Aplikasi" name="judul_aplikasi">
          </div>

          <div class="form-group">
            <label class="control-label">Judul Menu</label>
            <input class="form-control" type="text" value="{{ $config->judul_menu }}" required placeholder="Masukan Judul Menu" name="judul_menu">
          </div>

          <div class="form-group">
            <label class="control-label">Foto</label>
            <input class="form-control" type="file" name="foto">
          </div>
          
          </div>
          <div class="tile-footer">
            <button id="simpan" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="{{ action('WelcomeController@index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
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
</script>
@endsection