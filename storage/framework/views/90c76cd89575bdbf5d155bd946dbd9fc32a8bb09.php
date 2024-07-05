<?php $__env->startSection('page_heading','Invoice View'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="">
    <h1>Coming Soon</h1>
  </section>
  <!-- /.content -->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body_scripts'); ?>
    <script src="<?php echo e(config('app.app_public_path')); ?>/vendor/datepicker/moment.min.js"></script>
    <script src="<?php echo e(config('app.app_public_path')); ?>/vendor/datepicker/daterangepicker.js"></script>
    <script src="<?php echo e(config('app.app_public_path')); ?>/vendor/select2/select2.min.js"></script>

    <!-- Main JS-->
    <script src="<?php echo e(config('app.app_public_path')); ?>js/add-customer.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />

<!-- Icons font CSS-->
    <link href="<?php echo e(config('app.app_public_path')); ?>/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="<?php echo e(config('app.app_public_path')); ?>/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="<?php echo e(config('app.app_public_path')); ?>/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?php echo e(config('app.app_public_path')); ?>/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link rel="stylesheet" href="<?php echo e(config('app.app_public_path')); ?>/css/add-customer.css"  media="all">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>