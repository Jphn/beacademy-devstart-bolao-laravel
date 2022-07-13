@extends('template.bootstrap')

@section('title', $participant->name)

@section('body')
	<section class="container">
		<h1 class="mb-3">EDIÇÃO - {{ $participant->name }}</h1>

		<hr>

		<form action="{{ route('participants.update', $participant->id) }}" method="post">
			@csrf
			@method('PUT')
			<div class="mb-3">
				<label for="name" class="form-label">Nome</label>
				<input value="{{ $participant->name }}" type="text" class="form-control" id="name" name="name" required>
			</div>
			<div class="mb-3">
				<label for="phone" class="form-label">Telefone</label>
				<input value="{{ $participant->phone }}" type="text" class="form-control" id="phone" name="phone"
					maxlength="11" minlength="11" required>
			</div>
			<div class="mb-3">
				<label for="points" class="form-label">Pontos</label>
				<input value="{{ $participant->points }}" type="number" class="form-control" id="points" name="points"
					required readonly disabled>
			</div>
			<div class="mb-3">
				<label for="update_number" class="form-label">Concurso</label>
				<input value="{{ $participant->update_number }}" type="number" class="form-control" id="update_number"
					name="update_number" required readonly disabled>
			</div>
			<div class="mb-3">
				<label for="dozens" class="form-label">Dezenas</label>
				<input value="{{ $participant->string_dozens }}" type="text" class="form-control" id="dozens" name="dozens"
					required readonly disabled>
			</div>
			<div class="mb-3 form-check form-switch">
				<label class="form-check-label" for="active">Status</label>
				<input class="form-check-input" type="checkbox" role="switch" id="active" name="active"
					{{ $participant->active ? 'checked' : '' }}>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Nova Senha</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Digite a senha..."
					maxlength="12" minlength="6">
			</div>

			<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Voltar</a>
			<button type="submit" class="btn btn-primary">Salvar</button>
		</form>
	</section>
@endsection
