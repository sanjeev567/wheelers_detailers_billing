@extends('master')
@section('page_heading','Invoice List')
@section ('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<section class="content-header">
    <h1 class="curr_month">
    Invoice List
    </h1>
  </section>


  <!-- Main content -->
  <section class="content">
  <table id="customer-list-table" class="stripe">
      <thead>
        <td>Customer Name</td>
        <td>Customer Mobile</td>
        <td>Total</td>
        <td>Invoice Date</td>
        <td>Action</td>
      </thead>
      <tbody>
        @foreach ($invoices as $invoice)
          <tr>
            <td>{{ $invoice->customer_name }}</td>
            <td>{{ $invoice->customer_mobile }}</td>
            <td>{{ $invoice->total }}</td>
            <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y h:i A') }}</td>
            <td><a class="btn btn-info" href="/invoice/{{ $invoice->id }}">View</a></td>
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
