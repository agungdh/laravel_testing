@extends('template.template')

@section('nav')
  @include('klui.nav')
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="tile-title-w-btn">
            <h3 class="title">Data KLUI</h3>
            <p><a class="btn btn-primary icon-btn" href="{{ action('KluiController@create') }}"><i class="fa fa-plus"></i>KLUI</a></p>
          </div>
          <table class="table table-hover table-bordered datatable">
            <thead>
              <tr>
                <th>Kode KLUI</th>
                <th>Klasifikasi Usaha</th>
                <th>Proses</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tabel as $item)
                <tr>
                  <td>{{ $item->kode }}</td>
                  <td>{{ $item->klasifikasi_usaha }}</td>
                  <td>
                    <div class="btn-group">
                      <a class="btn btn-primary" href="{{ action('KluiController@edit', $item->kode) }}" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></a>
                      <form method="post" id="form_hapus_{{ $item->kode }}" action="{{ action('KluiController@destroy', $item->kode) }}">
                        @method('delete')
                        @csrf
                      <a class="btn btn-primary" href="#" onclick="hapus('{{ $item->kode }}')" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script type="text/javascript">
$(".datatable").DataTable({
    "scrollX": true,
    "autoWidth": false,
});

function hapus(id) {
    swal({
        title: 'Apakah anda yakin?',
        text: "Data akan dihapus!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus!'
    }).then(function(result) {
        if (result.value) {
            $("#form_hapus_" + id).submit();
        }
    });
};
</script>
@endsection