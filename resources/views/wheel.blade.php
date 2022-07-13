<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />

	<title>Volante Virtual</title>

	<link href="{{ asset('./assets/css/reset.css') }}" rel="stylesheet" />
	<link href="{{ asset('./assets/css/pattern.css') }}" rel="stylesheet" />
	<link href="{{ asset('./assets/css/style.css') }}" rel="stylesheet" />
	<link href="{{ asset('./assets/css/responsive.css') }}" rel="stylesheet" />
</head>

<body>
	<main>
		<div class="v-container">
			<section class="wheel">
				<div class="w-head">
					<h2>Preencha sua aposta</h2>
					<p>
						Selecione 10 números de 01 à 60, confirme suas
						escolhas e finalize sua aposta. Você pode clicar nos
						números ou digitá-los no campo ao lado do volante
						digital.
					</p>
				</div>
				<div class="w-numbers">
					@for ($i = 1; $i <= 60; $i++)
						<div class="btn-dzn" onclick="toggleDozenValue(this, {{ $i }})">{{ $i }}</div>
					@endfor
				</div>
			</section>
			<section class="panel">
				<div class="w-head">
					<h2>Suas escolhas</h2>
				</div>
				<div class="w-chosen">
					@for ($i = 1; $i <= 10; $i++)
						<div class="btn-dzn outline">00</div>
					@endfor
				</div>
				<div class="w-info">
					<p>
						Por favor verifique seus números antes de confirmar
						a aposta. Não nos responsabilizamos por qualquer
						tipo de erro por parte do usuário na seleção dos
						valores.
					</p>
				</div>
				<div class="w-counters">
					<p>Selecionados: <span id="counterSelected">00</span></p>
					<hr />
					<p>Restantes: <span id="counterRemaining">10</span></p>
				</div>
				<form action="{{ route('participants.update.dozens', $id) }}" class="w-input" id="postDozensForm" method="POST">
					@csrf
					@method('PUT')
					<input hidden type="text" id="dozensInput" name="dozens" required>

					<input id="passwordInput" name="password" placeholder="Digite sua senha..." required type="password" minlength="6"
						maxlength="12">

					<button hidden id="postDozensFormSubmitButton" type="submit"></button>
				</form>
				<div class="w-buttons">
					<button class="btn outline">Limpar Volante</button>
					<button class="btn" onclick="submitDozensForm()">Concluir Aposta</button>
				</div>
			</section>
		</div>
	</main>

	<script src="{{ asset('./assets/js/script.js') }}"></script>
</body>

</html>
