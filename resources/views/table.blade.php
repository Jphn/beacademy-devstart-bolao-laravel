<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Table Page</title>

	<link rel="stylesheet" href="./assets/css/tablePage/reset.css" />
	<link rel="stylesheet" href="./assets/css/tablePage/pattern.css" />
	<link rel="stylesheet" href="./assets/css/tablePage/style.css" />
	<link rel="stylesheet" href="./assets/css/tablePage/responsive.css" />
</head>

<body>
	<main class="container">
		<section class="sweepstake">
			<div class="w-header">
				<h2>Último Concurso</h2>
			</div>

			<div class="w-numbers">
				@foreach ($sweepstake->dozens as $dozen)
					<div class="number">{{ $dozen }}</div>
				@endforeach
			</div>

			<div class="w-infos">
				<p>
					Os valores são atualizados pelo administrador do
					sistema, com base nos resultados oficiais da Mega-Sena. Contate-o caso haja algum erro na atualização dos dados.
				</p>
			</div>

			@if ($pastSweepstakes ?? false)
				<div class="w-past">
					<div class="w-header">
						<h3>Concursos Anteriores</h3>
					</div>

					<div class="w-content">
						<div class="past">
							<div class="w-header">
								<h4>Nº 0000</h4>
							</div>

							<div class="w-numbers">
								<div class="number">00</div>
								<div class="number">00</div>
								<div class="number">00</div>
								<div class="number">00</div>
								<div class="number">00</div>
								<div class="number">00</div>
							</div>
						</div>
					</div>
				</div>
			@endif
		</section>

		<hr />

		<section class="table">
			<div class="w-header">
				<h2>Tabela de Pontuações</h2>
				<p>
					Tabela completa com a pontuação de todos os
					participantes ativosdeste bolão.
				</p>
				<p>
					Caso não encontre seu nome, utilize a ferramenta de
					pesquisa <strong>(CTRL + F)</strong>, digite seu nome e
					a mesma o levará até o participante desejado. Se a
					ocorrência persistir entre em contato com o
					administrador.
				</p>
			</div>

			<table>
				<thead>
					<tr>
						<th abbr="Posição">#</th>
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
	</main>
</body>

</html>
