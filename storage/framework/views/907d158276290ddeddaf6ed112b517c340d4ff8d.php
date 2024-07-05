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
                    <?php if(!empty($item)): ?>
                        <h2 class="title">Edit Item</h2>
                    <?php else: ?>
                        <h2 class="title">Add Item</h2>
                    <?php endif; ?>
                    <form method="POST" id="item-form">
                        <input type="hidden" name="id" value="<?php echo e(!empty($item)?$item->id:''); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="row row-space">
                            <div class="col-8">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Name" name="name" value="<?php echo e(!empty($item)?$item->name:''); ?>">
                                </div>
                            </div>
                            <div class="col-4">
                            <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search padd-4">
                                        <select id="new-type" name="type" class="padd-4">
                                            <option disabled="disabled" <?php echo e((empty($item) || $item->type == '' || $item->type == null)? 'selected="selected"' :''); ?>>Type</option>
                                            <option value="material" <?php echo e((!empty($item) && $item->type == 'material')? 'selected="selected"' :''); ?>>Material</option>
                                            <option value="treatment" <?php echo e((!empty($item) && $item->type == 'treatment')? 'selected="selected"' :''); ?>>Treatment</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-3">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search padd-4 type_treatment">
                                        <select id="new-size" name="size" class="padd-4">
                                            <option disabled="disabled" <?php echo e((empty($item) || $item->size == '' || $item->size == null)? 'selected="selected"' :''); ?>>Size</option>
                                            <option value="s" <?php echo e((!empty($item) && $item->size == 's')? 'selected="selected"' :''); ?>>Small</option>
                                            <option value="m" <?php echo e((!empty($item) && $item->size == 'm')? 'selected="selected"' :''); ?>>Medium</option>
                                            <option value="l" <?php echo e((!empty($item) && $item->size == 'l')? 'selected="selected"' :''); ?>>Large</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>

                                    <div class="rs-select2 js-select-simple select--no-search padd-4 type_material">
                                        <input class="input--style-2" type="text" placeholder="HSN Number" name="hsn_number" value="<?php echo e(!empty($item)?$item->hsn_number:''); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input class="input--style-2" type="number" placeholder="Price" name="price" value="<?php echo e(!empty($item)?$item->price_without_tax:''); ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input class="input--style-2" type="number" placeholder="Tax" name="tax" value="<?php echo e(!empty($item)?$item->tax_percent:''); ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Stock" name="stock" value="<?php echo e(!empty($item)?$item->stock:''); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="p-t-30">
                            <button class="btn btn--radius btn--green"  id="add-item-btn" type="submit">Add</button>
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
    <script src="<?php echo e(config('app.app_public_path')); ?>/js/add-item.js"></script>
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