<?php $__env->startSection('page_heading','Generate Invoice'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="curr_month">
      <?php if(!empty($invoice)): ?>
        Edit Stock
      <?php else: ?>
        Add Stock
      <?php endif; ?>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="#" name="invoice-form" id="invoice-form" style="margin-bottom:15px;display:inline-block;">
      <div style="width:20%;float:left;margin-bottom:20px;margin-right:12px;">
        <label for="invoice-type" style="display:block;">Select Type</label>
        <select class="form-control" id="invoice-type" name="type" data-placeholder="Invoice Type">
          <option value="invoice" <?php echo e((!empty($invoice) && $invoice->type == 'invoice')? 'selected="selected"' :''); ?>> Invoice</option>
          <option value="challan" <?php echo e((!empty($invoice) && $invoice->type == 'challan')? 'selected="selected"' :''); ?>> Challan</option>
        </select>
      </div>
      <?php echo e(csrf_field()); ?>

      <input type="hidden" name="id" id="id" value="<?php echo e(!empty($invoice)?$invoice->id:''); ?>">
      <div style="width:20%;margin-bottom:30px;">
      <label for="customer" style="display:block;">Select Party</label>
        <select class="form-control advisor-custom-select" id="customer" name="name" data-placeholder="Select Party">
          <option value=''></option>
          <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($customer->id); ?>" <?php echo e((!empty($invoice) && $invoice->seller_id == $customer->id)? 'selected="selected"' :''); ?>> <?php echo e($customer->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div style="width:20%;float:left;margin-bottom:20px;">
        <label for="invoice-number" style="display:block;">Invoice/Challan Number</label>
        <input type="text" name="invoice_number" id="invoice-number" class="form-control" style="min-height: 44px;" placeholder="Invoice Number"
        value="<?php echo e(!empty($invoice)? $invoice->invoice_number:''); ?>">
      </div>

      <div style="width:20%;float:left;margin-bottom:20px;margin-left:20px;margin-right:12px;">
        <label for="invoice-date" style="display:block;">Invoice/Challan Date</label>
        <input type="date" name="invoice_date" id="invoice-date" class="form-control" style="min-height: 44px;" placeholder="Invoice Date"
        value="<?php echo e(!empty($invoice)? $invoice->invoice_date:''); ?>">
      </div>

      <div class="form-row">
        <div class="col-md-6">
          <label for="mobile">Invoice/Challan Images (multiple)</label>
          <input type="file" class="form-control" name="images[]" placeholder="Document Images" multiple>
        </div>
        </div>
        <?php if(isset($invoice)): ?>
        <div id="document-images">
          <?php $__currentLoopData = $invoiceImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="user-docs-images-wrapper">
            <img  class="user-docs-images" alt="<?php echo e($image->image); ?>"
            src="<?php echo e(asset( config('app.user_doc_image_path') .'/'. $image->image)); ?>"
            onerror="this.onerror=null; this.src='<?php echo e(asset( config('app.app_public_path') .'/img/not_found.png')); ?>' ">
            <span class="close user-doc-delete-image" data-id="<?php echo e($image->id); ?>">x</span>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>


      <div style="width:20%;float:left;clear:left;">
      <label for="new_item" style="display:block;">Select Item</label>
        <select class="form-control advisor-custom-select" id="new_item" name="name" data-placeholder="Select Item" style="width: 100% !important;">
          <option value=''></option>
          <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($item->id); ?>" data-price="<?php echo e($item->price_without_tax); ?>">
            <?php echo e($item->name); ?> - <?php echo e(($item->size == 's')?'Small':(($item->size =='m')?'Medium':(($item->size == 'l')?'Large':''))); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div style="width:14%;float:left;margin-left:30px;">
        <label for="buying_price" style="display:block;">Buying Price</label>
        <input type="number" name="buying_price" id="buying_price" class="form-control" placeholder="Buying Price">
      </div>
      <div style="width:10%;float:left;margin-left:30px;">
        <label for="selling_price" style="display:block;">Selling Price</label>
        <input type="number" name="" id="selling_price" class="form-control" placeholder="Price" readonly>
      </div>
      <div style="width:10%;float:left;margin-left:30px;">
        <label for="new-quantity" style="display:block;">Quantity</label>
        <input type="number" name="quantity" id="new-quantity" min="1" class="form-control" placeholder="Quantity" value="1">
      </div>
      <div style="width:15%;float:left;margin-left:30px;margin-bottom:30px;">
        <input type="submit" class="btn btn-info add-item-btn" value="Add" style="margin-top:31px;">
      </div>
    </form>

    <table id="item-list-table" class="stripe">
      <thead>
        <td>Item ID</td>
        <td>Item</td>
        <td>Buying Price</td>
        <td>Selling Price</td>
        <td>Quantity</td>
        <td>Total</td>
        <td>Action</td>
      </thead>
      <tbody>
        <?php $__currentLoopData = $invoiceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="dark"><?php echo e($item->item_id); ?></td>
            <td class="dark"><?php echo e($item->item_name); ?></td>
            <td><?php echo e($item->item_cost_without_tax); ?></td>
            <td>
            <?php echo e($items->first(function($itemDetail) use ($item) {
                return $itemDetail->id == $item->item_id;
              })->price_without_tax); ?>

            </td>
            <td><?php echo e($item->quantity); ?></td>
            <td><?php echo e(($item->item_cost * $item->quantity) - ($item->item_cost * $item->quantity * $item->discount/100)); ?></td>
            <td class="dark"><button class="btn btn-danger delete_btn">Remove</button></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
    <button type="button" class="btn btn-info" style="margin-top:20px;" id="generate_invoice_btn">Save</button>
  </section>
  <!-- /.content -->
</div>
<div id="img-cover"></div>
    <div id="img-container">HEY</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body_scripts'); ?>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="<?php echo e(config('app.app_public_path')); ?>/js/lib/jquery.validate.min.js"></script>
<script src="<?php echo e(config('app.app_public_path')); ?>/js/add-stock-invoice.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo e(config('app.app_public_path')); ?>/css/add-stock-invoice.css"  media="all">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>