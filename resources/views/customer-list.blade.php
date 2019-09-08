@extends('master')
@section('page_heading','Invoice View')
@section ('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<section class="content-header">
    <h1 class="curr_month">
      Customer List
    </h1>
  </section>


  <!-- Main content -->
  <section class="content">
  <table id="zone-list-table" class="stripe">
      <thead>
        <td>Name</td>
        <td>Mobile</td>
        <td>Email</td>
        <td>Gender</td>
        <td>Joined On</td>
      </thead>
      <tbody>
        @foreach ($customers as $customer)
          <tr>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->mobile }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->gender }}</td>
            <td>{{ $customer->joined_on }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </section>
  <!-- /.content -->
</div>
@endsection

@section ('body_scripts')
    <script src="{{ config('app.app_public_path') }}/vendor/datepicker/moment.min.js"></script>
    <script src="{{ config('app.app_public_path') }}/vendor/datepicker/daterangepicker.js"></script>
    <script src="{{ config('app.app_public_path') }}/vendor/select2/select2.min.js"></script>

    <!-- Main JS-->
    <script src="{{ config('app.app_public_path') }}js/add-customer.js"></script>
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
