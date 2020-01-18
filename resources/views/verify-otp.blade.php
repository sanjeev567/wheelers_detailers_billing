<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="{{ config('app.app_public_path') }}/css/login.css">

  <script src="{{ config('app.app_public_path') }}/js/lib/jquery-3.1.1.js"></script>
  <title>Verify OTP</title>
</head>

<body>
  <div class="main">
  <input type="hidden" value="{{ config('app.app_url_prefix') }}" id="app_url_prefix">
    <p class="logo">
      <img src="{{ config('app.app_public_path') }}/img/mars-logo.png">
	</p>
	<form action="{{ config('app.app_url_prefix') }}/verify-otp" method="post" id="verify-otp-form" novalidate>
		{{ csrf_field() }}
		<input type="hidden" name="mobile" value="{{ $mobile }}">
		<input type="hidden" name="reset-token" value="{{ $token }}">
		<div>
			<input class="pass" type="password" align="center" placeholder="OTP" name="otp">
		</div>
		<button class="submit" align="center" id="login-btn">Verify</button>
	</form>

	@if(isset($masked_mobile))
		<p class="alert alert-info" style="text-align:center; color:#666;">An OTP has been sent to <b>{{ $masked_mobile }}</b></p>
	@endif

	@if(isset($error))
		<p class="alert alert-warning" style="text-align:center;color:red;">{{ $error }}</p>
	@endif
  </div>
  <!-- Ajax loader -->
  <div class="loader-backdrop" id="loader" style="display:none;">
    <div class="loader"></div>
  </div>
  <!-- Ajax loader -->
  <script src="{{ config('app.app_public_path') }}/js/lib/jquery.validate.min.js"></script>
  <script src="{{ config('app.app_public_path') }}/js/app.js"></script>
</body>

</html>