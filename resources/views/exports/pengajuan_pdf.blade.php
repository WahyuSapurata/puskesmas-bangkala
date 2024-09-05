<!DOCTYPE html>
<html>
<head>
	<title>Data Pengajuan</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h4>Data Pengajuan</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Email</th>
				<th>Nomor Surat</th>
				<th>Created Date</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $item)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{$item->user->name}}</td>
				<td>{{$item->user->email}}</td>
				<td>{{$item->nomor_surat}}</td>
				<td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y'); }}</td>
				<td>{{$item->status}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>