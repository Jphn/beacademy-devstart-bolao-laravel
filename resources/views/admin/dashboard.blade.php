@extends('template.bootstrap')
@section('title', 'Painel de Controle')
@section('body')
	<div class="container">
		<section class="mt-3">
			<h1>Bem-vindo {{ Auth::user()->name }}!</h1>

			<div>
				<a href="{{ route('admin.list') }}" class="btn btn-info">
					Administradores
					&ensp;
					<i class="fa-solid fa-lock"></i>
				</a>
				<a class="btn btn-secondary" href="{{ route('admin.logout') }}">
					Sair
					&ensp;
					<i class="fa-solid fa-arrow-right-from-bracket"></i>
				</a>
			</div>
		</section>

		<hr />

		<section>
			<h2>Opções Gerais</h2>

			<button type="button" class="btn btn-primary"
				onclick="event.preventDefault(); document.getElementById('updateSweepstakeForm').submit();">
				Atualizar Concurso
				&ensp;
				<i class="fa-solid fa-arrows-rotate"></i>
			</button>

			<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#approveResetModal">
				Reiniciar Bolão
				&ensp;
				<i class="fa-solid fa-power-off"></i>
			</button>
		</section>

		<hr />

		<section>
			<h2>Gerenciar Participantes</h2>

			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newParticipantModal">
				Adicionar
				&ensp;
				<i class="fa-solid fa-plus"></i>
			</button>

			<a href="{{ route('participants.csv') }}" class="btn btn-info">
				Gerar planilha
				&ensp;
				<i class="fa-solid fa-file-csv"></i>
			</a>

			<form class="mt-4" method="GET">
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Pesquisar..." aria-label="Pesquisar..."
						aria-describedby="searchAddon" name="search" value="{{ $search }}">
					<button class="btn btn-outline-success" type="submit" id="searchAddon">
						Pesquisar
						<i class="fa-solid fa-magnifying-glass"></i>
					</button>
				</div>
			</form>

			<div class="table-responsive mt-1">
				<table class="table table-light table-striped table-hover">
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
						@foreach ($participants as $participant)
							@php
								$selectDozensPhrase = 'Ol%C3%A1+' . str_replace(' ', '+', $participant->name) . '%2C+aqui+est%C3%A1+o+seu+link+para+selecionar+suas+dezenas.+Link%3A+https%3A%2F%2Fseudominio.com%2Fvolante%2F' . $participant->id;
								$checkInfosPhrase = "Sua+pontua%C3%A7%C3%A3o+agora+%C3%A9+{$participant->points}%2C+entre+no+site+para+conferir+os+%C3%BAltimos+resultados.+Link%3A+https%3A%2F%2Fseudominio";
							@endphp
							<tr>
								<th scope="row">{{ $participant->id }}</th>
								<td>{{ $participant->name }}</td>
								<td>
									<a
										href="https://wa.me/{{ $participant->phone }}?text={{ $participant->dozens != [0, 0, 0, 0, 0, 0, 0, 0, 0, 0] ? $checkInfosPhrase : $selectDozensPhrase }}"
										target="_blank">{{ $participant->phone }}</a>
								</td>
								<td>{{ $participant->points }}</td>
								<td>{{ $participant->update_number }}</td>
								<td>
									{{ $participant->active ? 'Ativo' : 'Inativo' }}
									<i
										class="fa-solid fa-{{ $participant->active ? 'circle-check text-success' : 'circle-xmark text-danger' }}"></i>
								</td>
								<td>{{ $participant->string_dozens }}</td>
								<td>
									<a class="btn btn-sm btn-warning" href="{{ route('participant.edit', $participant->id) }}">
										<i class="fa-solid fa-pen-to-square fa-xl"></i>
									</a>

									<button class="btn btn-sm btn-danger"
										onclick="event.preventDefault(); document.getElementById('deleteParticipantForm').action = '{{ route('participants.delete', $participant->id) }}'; document.getElementById('deleteParticipantForm').submit()">
										<i class="fa-solid fa-trash-can fa-xl"></i>
									</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	</div>

	<form action="{{ route('sweepstakes.update') }}" id="updateSweepstakeForm" method="POST">
		@method('PUT')
		@csrf
	</form>

	<div class="modal fade" id="newParticipantModal" tabindex="-1" aria-labelledby="newParticipantModalLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newParticipantModalLabel">Novo Participante</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="{{ route('participants.create') }}" method="POST" id="newParticipantForm">
						@csrf
						<div class="mb-3">
							<label for="name" class="form-label">Nome</label>
							<input type="text" class="form-control" id="name" name="name" required>
						</div>
						<div class="mb-3">
							<label for="phone" class="form-label">Telefone</label>
							<input type="text" class="form-control" id="phone" name="phone" minlength="11" maxlength="11" required>
						</div>
						<div class="mb-3 form-check form-switch">
							<label class="form-check-label" for="active">Status</label>
							<input class="form-check-input" type="checkbox" role="switch" id="active" name="active">
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Senha</label>
							<input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="12"
								placeholder="Digite a senha...">
						</div>

						<button id="newParticipantFormSubmitButton" type="submit" hidden>submit</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary"
						onclick="event.preventDefault(); document.getElementById('newParticipantFormSubmitButton').click();">
						Salvar
					</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="approveResetModal" tabindex="-1" role="dialog"
		aria-labelledby="approveResetModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="approveResetModalLabel">Deseja mesmo continuar?</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					Esta ação é <strong>irreversível</strong>, e irá <strong>formatar</strong> os valores de <strong>todos
						os
						participantes</strong> cadastrados.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
					<button type="button" class="btn btn-danger"
						onclick="event.preventDefault(); document.getElementById('putResetParticipants').submit()">
						Confirmar
					</button>
				</div>
			</div>
		</div>
	</div>

	<form id="deleteParticipantForm" method="POST">
		@method('DELETE')
		@csrf
	</form>

	<form id="putResetParticipants" method="POST" action="{{ route('participants.reset') }}">
		@method('PUT')
		@csrf
	</form>
@endsection
