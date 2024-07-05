<?php $__env->startSection('page_heading','Customer List'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<section class="content-header">
    <h1 class="curr_month">
      Customer List
    </h1>
  </section>

  <?php echo e(csrf_field()); ?>

  <!-- Main content -->
  <section class="content">
  <table id="customer-list-table" class="stripe">
      <thead>
        <td>Name</td>
        <td>Mobile</td>
        <td>Email</td>
        <td>GST Number</td>
        <td>Joined On</td>
        <td>Actions</td>
      </thead>
      <tbody>
        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($customer->name); ?></td>
            <td><?php echo e($customer->mobile); ?></td>
            <td><?php echo e($customer->email); ?></td>
            <td><?php echo e($customer->gst_number); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($customer->joined_on)->format('d-M-Y')); ?></td>
            <td> <a href="<?php echo e(config('app.app_url_prefix')); ?>/add-customer/<?php echo e($customer->id); ?>" class="btn btn-info">Edit</a>
            | <a class="btn btn-danger delete-customer-btn" href="#" data-id="<?php echo e($customer->id); ?>">Delete</a></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </section>
  <!-- /.content -->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body_scripts'); ?>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="<?php echo e(config('app.app_public_path')); ?>js/customer-list.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
  <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="<?php echo e(config('app.app_public_path')); ?>/css/main.css"  media="all">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>