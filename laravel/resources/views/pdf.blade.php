<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.content {
		    max-width: 500px;
		    margin: auto;
		}
	</style>
</head>
<body class="content">
	<center>
		<h3>{{ ucwords(strtolower($kabupaten->nama_kab)) }}</h3>
		<h3>Tahun {{ $tahun }}</h3>
	</center>
	<table border="1">
		<thead>
			<tr>
				<th>Kecamatan</th>
				<th>Jumlah Perusahaan</th>
				<th>Jumlah Tenaga Kerja</th>
			</tr>
		</thead>
		<tbody>
			@php
			$totalPerusahaan = 0;
			$totalTenagaKerja = 0;
			@endphp
			@foreach($kecamatan as $item)
	      		@php
	      		$perusahaan = 'SELECT count(pe.id) total
								FROM perusahaan pe, desa de, kec ke, kab ka, prop pr, klui kl
								WHERE pe.desa_id = de.id
								AND de.kec_id = ke.id
								AND ke.kab_id = ka.id
								AND ka.prop_id = pr.id
								AND pe.kode_klui = kl.kode
								AND YEAR(DATE_ADD(berlaku_sampai, INTERVAL - 1 YEAR)) = ' . $tahun . ' 
								AND ke.id = ?';

				$tenaga_kerja = 'SELECT sum(tkl+tkp+tkal+tkap) total
									FROM perusahaan pe, desa de, kec ke, kab ka, prop pr, klui kl
									WHERE pe.desa_id = de.id
									AND de.kec_id = ke.id
									AND ke.kab_id = ka.id
									AND ka.prop_id = pr.id
									AND pe.kode_klui = kl.kode
									AND YEAR(DATE_ADD(berlaku_sampai, INTERVAL - 1 YEAR)) = ' . $tahun . ' 
									AND ke.id = ?';
	      		@endphp
	      		<tr>
					<td>{{ ucwords(strtolower($item->nama_kec)) }}</td>
					<td>{{ DB::select($perusahaan, [$item->id])[0]->total }}</td>
							@php
							$totalPerusahaan += DB::select($perusahaan, [$item->id])[0]->total;
							@endphp
					<td>{{ DB::select($tenaga_kerja, [$item->id])[0]->total != null ? DB::select($tenaga_kerja, [$item->id])[0]->total : 0 }}</td>
							@php
							$totalTenagaKerja += DB::select($tenaga_kerja, [$item->id])[0]->total != null ? DB::select($tenaga_kerja, [$item->id])[0]->total : 0;
							@endphp
				</tr>
      		@endforeach
      		<tr>
      			<th>Jumlah</th>
      			<th>{{ $totalPerusahaan }}</th>
      			<th>{{ $totalTenagaKerja }}</th>
      		</tr>
		</tbody>
	</table>
</body>
</html>