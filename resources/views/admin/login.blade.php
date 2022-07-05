@extends('template.bootstrap')
@section('title', 'Login')
@section('body')
	<section class="vh-100" style="background-color: #508bfc">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-8 col-lg-6 col-xl-5">
					<div class="card shadow-2-strong" style="border-radius: 1rem">
						<form method="POST" class="card-body p-5 text-center">
							@csrf
							<h3 class="mb-5">Painel de controle</h3>

							<div class="form-outline mb-4">
								<input name="email" type="email" id="typeEmailX-2" class="form-control form-control-lg" required />
								<label class="form-label" for="typeEmailX-2">Email</label>
							</div>

							<div class="form-outline mb-4">
								<input name="password" type="password" id="typePasswordX-2" class="form-control form-control-lg" required />
								<label class="form-label" for="typePasswordX-2">Senha</label>
							</div>

							<!-- Checkbox -->
							<div class="form-check d-flex justify-content-start mb-4">
								<input class="form-check-input" type="checkbox" value="" id="form1Example3" />
								<label class="form-check-label" for="form1Example3">
									Lembre de mim
								</label>
							</div>

							<button class="btn btn-primary btn-lg btn-block" type="submit">
								Entrar
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
