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
  <table id="customer-list-table" class="stripe">
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
            <td>{{ \Carbon\Carbon::parse($customer->joined_on)->format('d-M-Y') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </section>
  <!-- /.content -->
</div>
@endsection

@section ('body_scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ config('app.app_public_path') }}js/customer-list.js"></script>
@endsection

@section ('styles')
  <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="{{ config('app.app_public_path') }}/css/main.css"  media="all">
@endsection