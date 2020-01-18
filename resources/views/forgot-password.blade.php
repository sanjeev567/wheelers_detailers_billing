<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="{{ config('app.app_public_path') }}/css/login.css">

  <script src="{{ config('app.app_public_path') }}/js/lib/jquery-3.1.1.js"></script>
  <title>Forgot Password</title>
</head>

<body>
  <div class="main">
  <input type="hidden" value="{{ config('app.app_url_prefix') }}" id="app_url_prefix">
    <p class="logo">
      <img src="{{ config('app.app_public_path') }}/img/mars-logo.png">
	</p>
	@if(isset($error))
		<p class="alert alert-warning" style="text-align:center;color:red;">{{ $error }}</p>
	@endif
    <form class="form1" id="login-form" method="post" action="{{ config('app.app_url_prefix') }}/forgot-password">
      {{ csrf_field() }}
      <div>
        <input class="un " type="text" align="center" placeholder="Mobile" name="mobile" required>
      </div>
      <button class="submit" align="center" id="login-btn">Send OTP </button>
      <p class="forgot" align="center"><a href="{{ config('app.app_url_prefix') }}/login">Login Here</p>
	</form>
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