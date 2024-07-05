<?php $__env->startSection('page_heading','Invoice List'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<section class="content-header">
    <h1 class="curr_month">
    Invoice List
    </h1>
  </section>


  <!-- Main content -->
  <section class="content">
    <div style="display: inline-block;">
    <input type="hidden" name="user_doc_image_path" id="user_doc_image_path" value="<?php echo e(config('app.user_doc_image_path')); ?>">
      <form id="invoice-list-dump-form" method="post" action="invoice-list-dump">
        <?php echo e(csrf_field()); ?>

        <div style="float:left;margin-right:20px;">
          <input type="Submit" class="btn btn-info" value="Export" id="invoice-list-dump-btn">
        </div>
      </form>
    </div>
    <?php echo e(csrf_field()); ?>

  <table id="invoice-list-table" class="stripe">
      <thead>
        <td>ID</td>
        <td>Invoice Number</td>
        <td>Date</td>
        <td>Buyer Name</td>
        <td>Amount</td>
        <td>Action</td>
      </thead>
      <tbody>
        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($invoice->id); ?></td>
            <td><?php echo e($invoice->invoice_number); ?></td>
            <td data-order="<?php echo e(\Carbon\Carbon::parse($invoice->created_at)->format('U')); ?>"><?php echo e(\Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y')); ?></td>
            <td><?php echo e($invoice->customer_name); ?></td>
            <td><?php echo e($invoice->total); ?></td>
            <td>
              <?php if(empty($invoice->deleted_at)): ?>
              <a class="btn btn-info" href="<?php echo e(config('app.app_url_prefix')); ?>/invoice/<?php echo e($invoice->id); ?>">View</a>
              | <a class="btn btn-warning" href="<?php echo e(config('app.app_url_prefix')); ?>/invoice-edit/<?php echo e($invoice->id); ?>">Edit</a>
              <?php if($invoice->image_count > 0): ?>
                | <a class="btn btn-success upload-invoice-image-btn" data-id="<?php echo e($invoice->id); ?>" style="color:#fff">Upload Image</a>
                <?php else: ?>
                | <a class="btn btn-danger upload-invoice-image-btn" data-id="<?php echo e($invoice->id); ?>" style="color:#fff">Upload Image</a>
              <?php endif; ?>
              | <a class="btn btn-danger invoice-cancel-btn" data-id="<?php echo e($invoice->id); ?>" style="color:#fff;">Cancel</a>
              <?php else: ?>
                <a class="btn btn-info" href="<?php echo e(config('app.app_url_prefix')); ?>/invoice/<?php echo e($invoice->id); ?>">View</a>
                | <div class="btn btn-info disabled" style="cursor:not-allowed !important;">Invoice Cancelled</div>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </section>
  <!-- /.content -->
</div>

<!-- Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="width: 540px;max-width:540px;">
      <div class="modal-header">
        <h4 class="modal-title">Upload Invoice Image</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="current-invoice-id" id="current-invoice-id" value="">
        <div id="invoice-images-wrapper">

        </div>
        <!-- Form -->
        <form method='post' action='' enctype="multipart/form-data">
          Select file : <input type='file' class="form-control" name='images' id='file' class='form-control'><br>
          <input type='button' class='btn btn-info' value='Upload' id='btn_upload'>
        </form>

        <!-- Preview-->
        <div id='preview'></div>
      </div>
    </div>
  </div>
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