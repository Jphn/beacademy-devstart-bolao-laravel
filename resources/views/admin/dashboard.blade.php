@extends('template.bootstrap')
@section('title', 'Login')
@section('body')
	<div class="container">
		<section class="mt-3">
			<h1>Painel de controle</h1>
		</section>
		<hr />
		<section>
			<h2>Gerais</h2>
			<button type="button" class="btn btn-primary" onclick="">
				Atualizar concurso
				<i class="fa-solid fa-arrows-rotate"></i>
			</button>
			<button type="button" class="btn btn-info">
				Administradores
				<i class="fa-solid fa-lock"></i>
			</button>
			<a class="btn btn-primary" href="{{ route('admin.logout') }}">
				Sair
				<i class="fa-solid fa-arrow-right-from-bracket"></i>
			</a>
		</section>
		<hr />
		<section>
			<h2>Gerenciar Participantes</h2>
			<button type="button" class="btn btn-primary">
				Adicionar
				<i class="fa-solid fa-plus"></i>
			</button>
			<button type="button" class="btn btn-info">
				Gerar planilha
				<i class="fa-solid fa-file-csv"></i>
			</button>
			<div class="table-responsive">
				<table class="table table-light table-striped table-hover mt-3">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nome</th>
							<th scope="col">Telefone</th>
							<th scope="col">Pontos</th>
							<th scope="col">Concurso</th>
							<th scope="col">Status</th>
							<th scope="col">Dezenas</th>
							<th scope="col">Ações</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($participants as $key => $participant)
							<tr>
								<th scope="row">{{ $key + 1 }}</th>
								<td>{{ $participant->name }}</td>
								<td>
									<a href="https://wa.me/{{ $participant->phone }}" target="_blank">{{ $participant->phone }}</a>
								</td>
								<td>{{ $participant->points }}</td>
								<td>{{ $participant->update_number }}</td>
								<td>{{ $participant->is_active }}</td>
								<td>{{ $participant->dozens }}</td>
								<td>
									<a class="btn btn-sm btn-warning" href="">Editar</a>
									<button class="btn btn-sm btn-danger" onclick="event.preventDefault();">Deletar</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	</div>
	<form action="" id="updateSweepstake">
		@method('PUT')
		@csrf
	</form>
@endsection
