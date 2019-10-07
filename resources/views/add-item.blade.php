@extends('master')
@section('page_heading','Invoice View')
@section ('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="">
  <div class="page-wrapper bg-color-warapper p-t-180 p-b-100 font-robo">
        <div class="cust-wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading"></div>
                <div class="card-body">
                    @if (!empty($item))
                        <h2 class="title">Edit Item</h2>
                    @else
                        <h2 class="title">Add Item</h2>
                    @endif
                    <form method="POST" id="item-form">
                        <input type="hidden" name="id" value="{{ !empty($item)?$item->id:'' }}">
                        {{ csrf_field() }}
                        <div class="row row-space">
                            <div class="col-8">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Name" name="name" value="{{ !empty($item)?$item->name:'' }}">
                                </div>
                            </div>
                            <div class="col-4">
                            <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search padd-4">
                                        <select name="type" class="padd-4">
                                            <option disabled="disabled" {{ (empty($item) || $item->size == '' || $item->size == null)? 'selected="selected"' :'' }}>Type</option>
                                            <option value="material" {{ (!empty($item) && $item->size == 's')? 'selected="selected"' :'' }}>Material</option>
                                            <option value="treatment" {{ (!empty($item) && $item->size == 'l')? 'selected="selected"' :'' }}>Treatment</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-3">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search padd-4">
                                        <select name="size" class="padd-4">
                                            <option disabled="disabled" {{ (empty($item) || $item->size == '' || $item->size == null)? 'selected="selected"' :'' }}>Size</option>
                                            <option value="s" {{ (!empty($item) && $item->size == 's')? 'selected="selected"' :'' }}>Small</option>
                                            <option value="m" {{ (!empty($item) && $item->size == 'm')? 'selected="selected"' :'' }}>Medium</option>
                                            <option value="l" {{ (!empty($item) && $item->size == 'l')? 'selected="selected"' :'' }}>Large</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input class="input--style-2" type="number" placeholder="Price" name="price" value="{{ !empty($item)?$item->price_without_tax:'' }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input class="input--style-2" type="number" placeholder="Tax" name="tax" value="{{ !empty($item)?$item->tax_percent:'' }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Stock" name="stock" value="{{ !empty($item)?$item->stock:'' }}">
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
@endsection

@section ('body_scripts')
    <script src="{{ config('app.app_public_path') }}/vendor/datepicker/moment.min.js"></script>
    <script src="{{ config('app.app_public_path') }}/vendor/datepicker/daterangepicker.js"></script>
    <script src="{{ config('app.app_public_path') }}/vendor/select2/select2.min.js"></script>
    <script src="{{ config('app.app_public_path') }}/js/lib/jquery.validate.min.js"></script>

    <!-- Main JS-->
    <script src="{{ config('app.app_public_path') }}/js/add-item.js"></script>
@endsection

@section ('styles')
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />

<!-- Icons font CSS-->
    <link href="{{ config('app.app_public_path') }}/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="{{ config('app.app_public_path') }}/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="{{ config('app.app_public_path') }}/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="{{ config('app.app_public_path') }}/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link rel="stylesheet" href="{{ config('app.app_public_path') }}/css/add-customer.css"  media="all">
@endsection
