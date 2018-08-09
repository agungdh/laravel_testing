@extends('template.main')

@section('content')
<center>
	<h2>Laravel Testing</h2>
	@foreach($data as $item)
		<p>{{ $item->name }}: <a href="{{ $item->action }}">{{ $item->action }}</a></p>
	@endforeach
</center>
@endsection