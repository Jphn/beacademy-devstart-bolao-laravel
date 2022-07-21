@extends('template.bootstrap')
@section('title', 'Todos os participantes')
@section('body')
	<section class="container">
		<h1>Tabela de participantes</h1>

		<button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#sweepstakeCollapse"
			aria-expanded="false" aria-controls="sweepstakeCollapse">
			Último Concurso
		</button>
		</p>
		<div class="collapse" id="sweepstakeCollapse">
			<div class="card card-body">
				<p><strong>Concurso Nº:</strong> {{ $sweepstake->id ?? '0000' }}.</p>
				<p><strong>Dezenas:</strong> {{ $sweepstake->string_dozens ?? 'Nenhuma' }}.</p>
			</div>
		</div>

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
				@foreach ($participants as $key => $participant)
					<tr>
						<th>{{ $key + 1 }}</th>
						<td>{{ $participant->name }}</td>
						<td>{{ $participant->points }}</td>
						<td>{{ $participant->string_dozens }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</section>
@endsection
