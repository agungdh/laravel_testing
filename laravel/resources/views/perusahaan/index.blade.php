@extends('template.template')

@section('nav')
  @include('perusahaan.nav')
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="tile-title-w-btn">
            <h3 class="title">Data Perusahaan</h3>
            @if(session('level') == 'a')
            <p><a class="btn btn-primary icon-btn" href="{{ action('PerusahaanController@create') }}"><i class="fa fa-plus"></i>Perusahaan</a></p>
            @endif
          </div>
          <form>
            <div class="form-group">
          @if(session('level') == 'a')
              <label class="control-label">Kabupaten</label>
              <select class="form-control select2" name="kab_id">
                <option {{ '0' == $kab_id ? 'selected' : null }} value="0">Semua</option>
                @foreach($kabupaten as $item)
                <option {{ $item->id == $kab_id ? 'selected' : null }} value="{{ $item->id }}">{{ ucwords(strtolower($item->nama_kab)) }}</option>
                @endforeach
              </select>
              <br>
              <br>
          @endif
              <label class="control-label">Tahun</label>
              <input class="form-control" type="number" min="1900" max="2900" name="tahun" value="{{ $tahun }}">
              <br>
              <input type="submit" class="btn btn-success">
            </div>
          </form>
          <table class="table table-hover table-bordered datatable">
            <thead>
              <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Alamat</th>
                <th rowspan="2">Provinsi</th>
                <th rowspan="2">Kabupaten</th>
                <th rowspan="2">Kecamatan</th>
                <th rowspan="2">Kelurahan</th>
                <th rowspan="2">Pemilik</th>
                <th rowspan="2">Tanggal Daftar</th>
                <th rowspan="2">KLUI</th>
                <th rowspan="2">Klasifikasi Usaha</th>
                <th colspan="2">Tenaga Kerja</th>
                <th colspan="2">Tenaga Kerja Asing</th>
                <th rowspan="2">Upah Terendah</th>
                <th rowspan="2">Status Perusahaan</th>
                <th rowspan="2">Berlaku Sampai</th>
                <th rowspan="2">Berkas</th>
                @if(session('level') == 'a')
                <th rowspan="2">Proses</th>
                @endif
              </tr>
              <tr>
                <td>L</td>
                <td>P</td>
                <td>L</td>
                <td>P</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($tabel as $item)
                <tr>
                  <td>{{ $item->no }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->alamat }}</td>
                  <td>{{ $item->provinsi }}</td>
                  <td>{{ $item->kabupaten }}</td>
                  <td>{{ $item->kecamatan }}</td>
                  <td>{{ $item->desa }}</td>
                  <td>{{ $item->pemilik }}</td>
                  <td>{{ $item->tanggal_daftar }}</td>
                  <td>{{ $item->kode_klui }}</td>
                  <td>{{ $item->klasifikasi_usaha }}</td>
                  <td>{{ $item->tkl }}</td>
                  <td>{{ $item->tkp }}</td>
                  <td>{{ $item->tkal }}</td>
                  <td>{{ $item->tkap }}</td>
                  <td>{{ $item->upah_terendah }}</td>
                  <td>{{ $item->status_perusahaan }}</td>
                  <td>{{ $item->berlaku_sampai }}</td>
                  <td>
                    @if($item->berkas != null)
                    <a href="{{ action('WelcomeController@index') . '/uploads/perusahaan/' . $item->id }}" target="_blank">{{ $item->berkas }}</a>
                    {{-- <a href="{{ action('PerusahaanController@download', $item->id) }}">{{ $item->berkas }}</a> --}}
                    {{-- <a href="#" data-toggle="modal" data-target="#pdfModal" onclick="pdf('{{ $item->id }}')">{{ $item->berkas }}</a> --}}
                    @else
                    -
                    @endif
                  </td>
                  @if(session('level') == 'a')
                  <td>
                    <div class="btn-group">
                      <a class="btn btn-primary" href="{{ action('PerusahaanController@edit', $item->id) }}" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></a>
                      <form method="post" id="form_hapus_{{ $item->id }}" action="{{ action('PerusahaanController@destroy', $item->id) }}">
                        @method('delete')
                        @csrf
                      <a class="btn btn-primary" href="#" onclick="hapus('{{ $item->id }}')" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                      </form>
                    </div>
                  </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
function pdf(id) {
  $.get("{{ action('PerusahaanController@index') }}/showpdf/" + id, function(data) {
    var jsondata = JSON.parse(data);
    $("#modalTitle").html(jsondata.title);
    $("#modalBody").html(jsondata.body);
  }); 
}

$(".select2").select2();

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