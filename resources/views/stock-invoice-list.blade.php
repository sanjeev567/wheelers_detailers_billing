@extends('master')
@section('page_heading','Invoice List')
@section ('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<section class="content-header">
    <h1 class="curr_month">
    Stock Invoice List
    </h1>
  </section>


  <!-- Main content -->
  <section class="content">
  <table id="customer-list-table" class="stripe">
      <thead>
        <td>Type</td>
        <td>Customer Name</td>
        <td>Customer Mobile</td>
        <td>Total</td>
        <td>Invoice/Challan Date</td>
        <td>Action</td>
      </thead>
      <tbody>
        @foreach ($invoices as $invoice)
          <tr>
            <td>{{ ucfirst($invoice->type) }}</td>
            <td>{{ $invoice->seller_name }}</td>
            <td>{{ $invoice->seller_mobile }}</td>
            <td>{{ $invoice->total }}</td>
            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-M-Y') }}</td>
            <td><a class="btn btn-warning" href="{{ config('app.app_url_prefix') }}/add-stock/{{ $invoice->id }}">Edit</a></td>
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
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
  <script src="{{ config('app.app_public_path') }}js/customer-list.js"></script>
@endsection

@section ('styles')
  <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="{{ config('app.app_public_path') }}/css/main.css"  media="all">
@endsection
