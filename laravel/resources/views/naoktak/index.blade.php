<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h3>{{ $nis }}</h3>
	<table border="1">
		<thead>
			<tr>
				<th>Mapel</th>
				<th>Tugas</th>
				<th>UH</th>
				<th>UAS</th>
				<th>NA</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tabel as $item)
			<tr>
				<td>{{ $item->mapel }}</td>
				<td>{{ $item->tugas }}</td>
				<td>{{ $item->uh }}</td>
				<td>{{ $item->uas }}</td>
				<td>{{ $item->na }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>