@extends('master')
@section('page_heading','Generate Invoice')
@section ('content')
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
      {{ csrf_field() }}

      <div style="width:50%;margin-bottom:30px;">
        <label for="customer" style="display:block;">Select Customer</label>
        <select class="form-control advisor-custom-select" id="customer" name="name" data-placeholder="Select Customer">
          <option value=''></option>
          @foreach ($customers as $customer)
          <option value="{{ $customer->id }}" {{ ($selectedCustomer == $customer->id)?'selected':'' }}> {{ $customer->name }}</option>
          @endforeach
        </select>
      </div>
      <div style="width:20%;float:left;">
      <label for="new_item" style="display:block;">Select Item</label>
        <select class="form-control advisor-custom-select" id="new_item" name="name" data-placeholder="Select Item" style="width: 100% !important;">
          <option value=''></option>
          @foreach ($items as $item)
          <option value="{{ $item->id }}" data-type="{{ $item->type }}" data-price="{{ $item->price_without_tax }}"> {{ $item->name }} {{
            ($item->type=="treatment")?($item->size == 's')?'- Small':(($item->size =='m')?'- Medium':(($item->size == 'l')?'- Large':'')):''
          }}</option>
          @endforeach
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
      </tbody>
    </table>

    <button type="button" class="btn btn-info" style="margin-top:20px;" id="generate_invoice_btn">Generate Invoice</button>
  </section>
  <!-- /.content -->
</div>
@endsection

@section ('body_scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="{{ config('app.app_public_path') }}/js/lib/jquery.validate.min.js"></script>
<script src="{{ config('app.app_public_path') }}js/invoice-view.js"></script>
@endsection

@section ('styles')
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
@endsection