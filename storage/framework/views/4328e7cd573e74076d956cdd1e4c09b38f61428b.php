<?php $__env->startSection('page_heading','Generate Invoice'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="curr_month">
      Generate Invoice
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="#" name="invoice-form" id="invoice-form" style="margin-bottom:15px;display:inline-block;">
      <?php echo e(csrf_field()); ?>

      <input type="hidden" name="id" id="id" value="<?php echo e(!empty($invoice)?$invoice->id:''); ?>">

      <div style="width:50%;margin-bottom:30px;">
        <label for="customer" style="display:block;">Select Customer</label>
        <select class="form-control advisor-custom-select" id="customer" name="name" data-placeholder="Select Customer">
          <option value=''></option>
          <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($customer->id); ?>" <?php echo e(($selectedCustomer == $customer->id)?'selected':''); ?>

          <?php echo e((!empty($invoice) && $invoice->customer_id == $customer->id)? 'selected="selected"' :''); ?>> <?php echo e($customer->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div style="width:20%;float:left;">
      <label for="new_item" style="display:block;">Select Item</label>
        <select class="form-control advisor-custom-select" id="new_item" name="name" data-placeholder="Select Item" style="width: 100% !important;">
          <option value=''></option>
          <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($item->id); ?>" data-type="<?php echo e($item->type); ?>" data-price="<?php echo e($item->price_without_tax); ?>"> <?php echo e($item->name); ?> <?php echo e(($item->type=="treatment")?($item->size == 's')?'- Small':(($item->size =='m')?'- Medium':(($item->size == 'l')?'- Large':'')):''); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div style="width:10%;float:left;margin-left:30px;">
        <label for="new-price" style="display:block;">Price</label>
        <input type="number" name="" id="new-price" class="form-control" placeholder="Price" readonly>
      </div>
      <div style="width:10%;float:left;margin-left:30px;">
        <label for="new-quantity" style="display:block;">Quantity</label>
        <input type="number" name="quantity" id="new-quantity" min="1" class="form-control" placeholder="Quantity" value="1">
      </div>
      <div style="width:10%;float:left;margin-left:30px;">
        <label for="new-discount" style="display:block;">Discount %</label>
        <input type="number" name="discount" id="new-discount" class="form-control" min="0" placeholder="Discount" value="0.0">
      </div>
      <div style="width:15%;float:left;margin-left:30px;margin-bottom:30px;">
        <input type="submit" class="btn btn-info add-item-btn" value="Add" style="margin-top:31px;">
      </div>
    </form>

    <table id="item-list-table" class="stripe">
      <thead>
        <td>Item ID</td>
        <td>Item</td>
        <td>Price</td>
        <td>Quantity</td>
        <td>Disocunt %</td>
        <td>Total</td>
        <td>Action</td>
      </thead>
      <tbody>
        <?php $__currentLoopData = $invoiceDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="dark"><?php echo e($item->item_id); ?></td>
            <td class="dark"><?php echo e($item->item_name); ?> </td>
            <td><?php echo e($item->item_cost_without_tax); ?></td>
            <td><?php echo e($item->quantity); ?></td>
            <td><?php echo e($item->discount); ?></td>
            <td><?php echo e(($item->item_cost * $item->quantity) - ($item->item_cost * $item->quantity * $item->discount/100)); ?></td>
            <td class="dark"><button class="btn btn-danger delete_btn">Remove</button></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>

    <button type="button" class="btn btn-info" style="margin-top:20px;" id="generate_invoice_btn">Generate Invoice</button>
  </section>
  <!-- /.content -->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body_scripts'); ?>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/jquery.validate.min.js"></script>
<script src="<?php echo e(config('app.app_public_path')); ?>/js/invoice-view.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>