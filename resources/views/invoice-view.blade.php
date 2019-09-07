@extends('master')
@section('page_heading','Invoice View')
@section ('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="curr_month">
      Invoice View
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="#" name="invoice-form" id="invoice-form" style="margin-bottom:15px;display:inline-block;">
      {{ csrf_field() }}

      <div style="width:25%;float:left;">
      <label for="new_item" style="display:block;">Select Item</label>
        <select class="form-control advisor-custom-select" id="new_item" name="name" data-placeholder="Select Item">
          <option value=''></option>
          @foreach ($items as $item)
          <option value="{{ $item->id }}" data-price="{{ $item->price }}"> {{ $item->name }}</option>
          @endforeach
        </select>
      </div>
      <div style="width:15%;float:left;margin-left:30px;">
        <label for="new-price" style="display:block;">Price</label>
        <input type="number" name="" id="new-price" class="form-control" placeholder="Price" readonly>
      </div>
      <div style="width:15%;float:left;margin-left:30px;">
        <label for="new-quantity" style="display:block;">Quantity</label>
        <input type="number" name="quantity" id="new-quantity" class="form-control" placeholder="Quantity" value="1">
      </div>
      <div style="width:15%;float:left;margin-left:30px;">
        <label for="new-discount" style="display:block;">Discount</label>
        <input type="number" name="discount" id="new-discount" class="form-control" placeholder="Discount" value="0.0">
      </div>
      <div style="width:15%;float:left;margin-left:30px;">
        <input type="submit" class="btn btn-info add-item-btn" value="Add" style="margin-top:31px;">
      </div>
    </form>

    <table id="item-list-table" class="stripe">
      <thead>
        <td>Item</td>
        <td>Price</td>
        <td>Quantity</td>
        <td>Disocunt</td>
        <td>Total</td>
        <td>Action</td>
      </thead>
      <tbody>
      </tbody>
    </table>

    <button type="button" class="btn btn-info" id="generate_invoice_btn">Generate Invoice</button>
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