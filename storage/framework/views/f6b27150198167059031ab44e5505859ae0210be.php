<!-- jQuery 3 -->
<script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/jquery-3.1.1.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/adminlte.min.js"></script>
<!-- jQuery Validator Plugin -->
<script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/jquery.validate.min.js"></script>

<script src="<?php echo e(config('app.app_public_path')); ?>/js/app.js"></script>