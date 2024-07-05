<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="<?php echo e(config('app.app_public_path')); ?>/css/login.css">

  <script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/jquery-3.1.1.js"></script>
  <title>Forgot Password</title>
</head>

<body>
  <div class="main">
  <input type="hidden" value="<?php echo e(config('app.app_url_prefix')); ?>" id="app_url_prefix">
    <p class="logo">
      <img src="<?php echo e(config('app.app_public_path')); ?>/img/mars-logo.png">
	</p>
	<?php if(isset($error)): ?>
		<p class="alert alert-warning" style="text-align:center;color:red;"><?php echo e($error); ?></p>
	<?php endif; ?>
    <form class="form1" id="login-form" method="post" action="<?php echo e(config('app.app_url_prefix')); ?>/forgot-password">
      <?php echo e(csrf_field()); ?>

      <div>
        <input class="un " type="text" align="center" placeholder="Mobile" name="mobile" required>
      </div>
      <button class="submit" align="center" id="login-btn">Send OTP </button>
      <p class="forgot" align="center"><a href="<?php echo e(config('app.app_url_prefix')); ?>/login">Login Here</p>
	</form>
  </div>
  <!-- Ajax loader -->
  <div class="loader-backdrop" id="loader" style="display:none;">
    <div class="loader"></div>
  </div>
  <!-- Ajax loader -->
  <script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/jquery.validate.min.js"></script>
  <script src="<?php echo e(config('app.app_public_path')); ?>/js/app.js"></script>
</body>

</html>