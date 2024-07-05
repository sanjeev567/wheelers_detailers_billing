<?php $__env->startSection('page_heading','Invoice View'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="">
  <div class="page-wrapper bg-color-warapper p-t-180 p-b-100 font-robo">
        <div class="cust-wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Customer Registration</h2>
                    <form method="POST" id="customer-form">
                        <input type="hidden" name="id"  id="id" value="<?php echo e(!empty($customer)?$customer->id:''); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="row row-space">
                            <div class="col-6">
                                <div class="input-group">
                                <input class="input--style-2" type="text" placeholder="Name" name="name" value="<?php echo e(!empty($customer)?$customer->name:''); ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="GST Number" name="gst_number" value="<?php echo e(!empty($customer)?$customer->gst_number:''); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-4">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Mobile" name="mobile" value="<?php echo e(!empty($customer)?$customer->mobile:''); ?>">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Email" name="email" value="<?php echo e(!empty($customer)?$customer->email:''); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-7">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Address" name="address" value="<?php echo e(!empty($customer)?$customer->address:''); ?>">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <div style="width:100%;"class="rs-select2 js-select-simple padd-4">
                                        <select name="state" class="padd-4">
                                            <option disabled="disabled" selected>State</option>
                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($state->code); ?>" <?php echo e((!empty($state) && !empty($customer) && $state->code == $customer->state)? 'selected="selected"' :''); ?>><?php echo e($state->state); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-t-30">
                            <button class="btn btn--radius btn--green"  id="add-customer-btn" type="submit">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body_scripts'); ?>
    <script src="<?php echo e(config('app.app_public_path')); ?>/vendor/datepicker/moment.min.js"></script>
    <script src="<?php echo e(config('app.app_public_path')); ?>/vendor/datepicker/daterangepicker.js"></script>
    <script src="<?php echo e(config('app.app_public_path')); ?>/vendor/select2/select2.min.js"></script>
    <script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/jquery.validate.min.js"></script>

    <!-- Main JS-->
    <script src="<?php echo e(config('app.app_public_path')); ?>/js/add-customer.js"></script>
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