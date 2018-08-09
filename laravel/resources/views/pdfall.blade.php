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
		<h3>Provinsi Lampung</h3>
		<h3>Tahun {{ $tahun }}</h3>
	</center>
	<table border="1">
		<thead>
			<tr>
				<th>Kabupaten</th>
				<th>Jumlah Perusahaan</th>
				<th>Jumlah Tenaga Kerja</th>
			</tr>
		</thead>
		<tbody>
			@php
			$totalPerusahaan = 0;
			$totalTenagaKerja = 0;
			@endphp

			@foreach($kabupaten as $item)
				@php
				$perusahaanKabupaten = 0;
				$tenagaKerjaKabupaten = 0;
				@endphp
				<tr>
					<td>{{ ucwords(strtolower($item->nama_kab)) }}</td>
					@foreach(DB::table('kec')->where('kab_id', $item->id)->get() as $item)
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

						$perusahaanKabupaten += DB::select($perusahaan, [$item->id])[0]->total;
						$totalPerusahaan += DB::select($perusahaan, [$item->id])[0]->total;
						$tenagaKerjaKabupaten += DB::select($tenaga_kerja, [$item->id])[0]->total != null ? DB::select($tenaga_kerja, [$item->id])[0]->total : 0;
						$totalTenagaKerja += DB::select($tenaga_kerja, [$item->id])[0]->total != null ? DB::select($tenaga_kerja, [$item->id])[0]->total : 0;
			      		@endphp
		      		@endforeach
					<td>{{ $perusahaanKabupaten }}</td>
					<td>{{ $tenagaKerjaKabupaten }}</td>
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