@extends('template.bootstrap')
@section('title', 'Todos os participantes')
@section('body')
<section>
	<h1>Tabela de participantes</h1>
	
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Nome</th>
				<th>Pontos</th>
				<th>Dezenas</th>
			</tr>
		</thead>
		<tbody>
			@foreach($participants as $key => $participant)
			<tr>
				<th>{{ $key + 1 }}</th>
				<td>{{ $participant->name }}</td>
				<td>{{ $participant->points }}</td>
				<td>{{ $participant->dozens }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>
@endsection