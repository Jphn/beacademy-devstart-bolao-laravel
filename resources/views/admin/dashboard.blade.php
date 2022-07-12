@extends('template.bootstrap')
@section('title', 'Dashboard')
@section('body')
	<div class="container">
		<section class="mt-3">
			<h1>Painel de controle</h1>
		</section>
		<hr />
		<section>
			<h2>Gerais</h2>

			<button type="button" class="btn btn-primary"
				onclick="event.preventDefault(); document.getElementById('updateSweepstakeForm').submit();">
				Atualizar Concurso&ensp;
				<i class="fa-solid fa-arrows-rotate"></i>
			</button>
			<button type="button" class="btn btn-warning">
				Reiniciar Bolão&ensp;
				<i class="fa-solid fa-power-off"></i>
			</button>
			<button type="button" class="btn btn-info">
				Administradores&ensp;
				<i class="fa-solid fa-lock"></i>
			</button>
			<a class="btn btn-secondary" href="{{ route('admin.logout') }}">
				Sair&ensp;
				<i class="fa-solid fa-arrow-right-from-bracket"></i>
			</a>
		</section>
		<hr />
		<section>
			<h2>Gerenciar Participantes</h2>

			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newParticipantModal">
				Adicionar&ensp;
				<i class="fa-solid fa-plus"></i>
			</button>
			<a href="{{ route('participants.csv') }}" type="button" class="btn btn-info">
				Gerar planilha&ensp;
				<i class="fa-solid fa-file-csv"></i>
			</a>
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
									<a
										href="https://wa.me/{{ $participant->phone }}?text=Ol%C3%A1+{{ str_replace(' ', '+', $participant->name) }}%2C+aqui+est%C3%A1+o+seu+link+para+selecionar+suas+dezenas.+Link%3A+https%3A%2F%2Fseudominio.com%2Fdezenas%2F{{ $participant->id }}"
										target="_blank">{{ $participant->phone }}</a>
								</td>
								<td>{{ $participant->points }}</td>
								<td>{{ $participant->update_number }}</td>
								<td>{{ $participant->active ? 'Ativo' : 'Inativo' }}</td>
								<td>{{ $participant->dozens }}</td>
								<td>
									<a class="btn btn-sm btn-warning" href="{{ route('participant.edit', $participant->id) }}">Editar</a>
									<button class="btn btn-sm btn-danger"
										onclick="event.preventDefault(); document.getElementById('deleteParticipantForm').action = '{{ route('participants.delete', $participant->id) }}'; document.getElementById('deleteParticipantForm').submit()">Deletar</button>
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
						onclick="event.preventDefault(); document.getElementById('newParticipantFormSubmitButton').click();">Salvar</button>
				</div>
			</div>
		</div>
	</div>

	<form id="deleteParticipantForm" method="post">
		@method('DELETE')
		@csrf
	</form>
@endsection
