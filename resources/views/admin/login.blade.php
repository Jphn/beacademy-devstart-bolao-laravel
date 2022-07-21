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
							<h3 class="mb-3">Painel de controle</h3>

							<div class="form-floating mb-2">
								<input type="email" class="form-control" id="emailInput" placeholder="name@example.com" name="email" require>
								<label for="emailInput">Email</label>
							</div>
							<div class="form-floating mb-3">
								<input type="password" class="form-control" id="passwordInput" placeholder="Password" name="password" required>
								<label for="passwordInput">Senha</label>
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
