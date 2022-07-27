@extends('template.bootstrap')

@section('title', $user->name)

@section('body')
	<section class="container">
		<h1 class="mb-3">EDIÇÃO - {{ $user->name }}</h1>

		@include('partial.error')

		<hr>

		<form action="{{ route('users.update', $user->id) }}" method="post">
			@csrf
			@method('PUT')

			<div class="mb-3">
				<label for="name" class="form-label">Nome</label>
				<input value="{{ $user->name }}" type="text" class="form-control" id="name" name="name" required>
			</div>

			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input value="{{ $user->email }}" type="text" class="form-control" id="email" name="email" required>
			</div>

			<div class="mb-3">
				<label for="password" class="form-label">Nova Senha</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Nova senha..." maxlength="12"
					minlength="6">
			</div>

			<a href="{{ route('admin.list') }}" class="btn btn-outline-secondary">
				<i class="fa-solid fa-arrow-left fa-lg"></i>
				Voltar
			</a>
			<button type="submit" class="btn btn-primary">Salvar</button>
		</form>
	</section>
@endsection
