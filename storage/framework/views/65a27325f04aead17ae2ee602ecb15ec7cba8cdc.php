<?php $__env->startSection('page_heading','Invoice List'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<section class="content-header">
    <h1 class="curr_month">
    Stock Invoice List
    </h1>
  </section>


  <!-- Main content -->
  <section class="content">
  <table id="customer-list-table" class="stripe">
      <thead>
        <td>ID</td>
        <td>Type</td>
        <td>Invoice/Challan Number</td>
        <td>Customer Name</td>
        <td>Customer Mobile</td>
        <td>Total</td>
        <td>Invoice/Challan Date</td>
        <td>Action</td>
      </thead>
      <tbody>
        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($invoice->id); ?></td>
            <td><?php echo e(ucfirst($invoice->type)); ?></td>
            <td><?php echo e(($invoice->type =="invoice")?strtoupper($invoice->invoice_number):strtoupper($invoice->challan_number)); ?></td>
            <td><?php echo e($invoice->seller_name); ?></td>
            <td><?php echo e($invoice->seller_mobile); ?></td>
            <td><?php echo e($invoice->total); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d-M-Y')); ?></td>
            <td><a class="btn btn-warning" href="<?php echo e(config('app.app_url_prefix')); ?>/add-stock/<?php echo e($invoice->id); ?>">Edit</a></td>
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