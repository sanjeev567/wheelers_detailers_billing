<!DOCTYPE html>
<html lang="en">
<head>
	<title>Wheelers Detailers Pvt Ltd</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ config('app.app_public_path') }}/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ config('app.app_public_path') }}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ config('app.app_public_path') }}/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ config('app.app_public_path') }}/css/util.css">
	<link rel="stylesheet" type="text/css" href="{{ config('app.app_public_path') }}/css/main.css">
<!--===============================================================================================-->
</head>
<body>
<input type="hidden" value="{{ config('app.app_url_prefix') }}" id="app_url_prefix">
	<div class="limiter">
		<div class="container-login100" style="background-image: url('{{ config('app.app_public_path') }}/images/bg-01.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" id="login-form"  method="post">
       	 {{ csrf_field() }}
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter Mobile">
						<input class="input100" type="text" name="mobile" placeholder="Mobile">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<!-- <div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div> -->

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" id="login-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-90">
						<a class="txt1" href="#">
							Forgot Password?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="{{ config('app.app_public_path') }}/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ config('app.app_public_path') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="{{ config('app.app_public_path') }}/js/main.js"></script>
  <script src="{{ config('app.app_public_path') }}/js/lib/jquery.validate.min.js"></script>

  <script src="{{ config('app.app_public_path') }}/js/login.js"></script>

</body>
</html>
