@extends('template.bootstrap')

@section('title', 'Administradores')

@section('body')
	<div class="container">
		<section>
			<h1 class="mb-2">Administradores do Sistema</h1>

			<div>
				<a href="{{ route('admin.dashboard') }}" class="btn btn-md btn-outline-dark">
					<i class="fa-solid fa-arrow-left fa-lg"></i>
					Voltar
				</a>
				<button class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#newUserModal">
					Novo Administrador
					<i class="fa-solid fa-plus fa-lg"></i>
				</button>
			</div>
		</section>

		<hr>

		<section>
			<h2>Lista</h2>

			<div class="table-responsive">
				<table class="table table-light table-striped table-hover mt-3">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Nome</th>
							<th scope="col">Email</th>
							<th scope="col">Cadastrado em</th>
							<th scope="col">Ações</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($users as $user)
							<tr>
								<th scope="row">{{ $user->id }}</th>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
								<td>
									<a class="btn btn-sm btn-warning" href="{{ route('user.edit', $user->id) }}">
										<i class="fa-solid fa-pen-to-square fa-xl"></i>
									</a>

									<button class="btn btn-sm btn-danger"
										onclick="event.preventDefault(); document.getElementById('deleteUserForm').action = '{{ route('users.delete', $user->id) }}'; document.getElementById('deleteUserForm').submit()">
										<i class="fa-solid fa-trash-can fa-xl"></i>
									</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

		</section>
	</div>

	<div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newUserModalLabel">Novo Administrador</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="{{ route('users.create') }}" method="POST" id="newUserForm">
						@csrf

						<div class="mb-3">
							<label for="name" class="form-label">Nome</label>
							<input type="text" class="form-control" id="name" name="name" required>
						</div>

						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" required>
						</div>

						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="12" required>
						</div>

						<button id="newUserFormSubmitButton" type="submit" hidden>submit</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary"
						onclick="event.preventDefault(); document.getElementById('newUserFormSubmitButton').click();">
						Salvar
					</button>
				</div>
			</div>
		</div>
	</div>

	<form id="deleteUserForm" method="POST">
		@method('DELETE')
		@csrf
	</form>
@endsection
