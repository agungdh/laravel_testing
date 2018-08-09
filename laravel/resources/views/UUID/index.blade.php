@extends('template.main')

@section('content')
<center>
	<h2>UUID Generator</h2>
	@if($uuid->success == true)
		@foreach($uuid as $key => $value)
			@if($key != 'success')
				<p>{{ $key }}: {{ $value }}</p>
			@endif
		@endforeach
	@else
	<p>{{ $uuid->message }}</p>
	@endif
</center>
@endsection