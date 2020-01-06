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
    {{ csrf_field() }}
  <table id="customer-list-table" class="stripe">
      <thead>
        <td>ID</td>
        <td>Invoice Number</td>
        <td>Date</td>
        <td>Buyer Name</td>
        <td>Buyer Address</td>
        <td>Amount</td>
        <td>Action</td>
      </thead>
      <tbody>
        @foreach ($invoices as $invoice)
          <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->invoice_number }}</td>
            <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y h:i A') }}</td>
            <td>{{ $invoice->customer_name }}</td>
            <td style="text-transform:capitalize;">{{ $invoice->customer_address }}</td>
            <td>{{ $invoice->total }}</td>
            <td>
              @if (empty($invoice->deleted_at))
              <a class="btn btn-info" href="{{ config('app.app_url_prefix') }}/invoice/{{ $invoice->id }}">View</a>
              | <a class="btn btn-danger invoice-cancel-btn" data-id="{{ $invoice->id }}" style="color:#fff;">Cancel Invoice</a>
              @else
                <div class="btn btn-info disabled" style="cursor:not-allowed !important;">Invoice Cancelled</div>
              @endif
            </td>
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
