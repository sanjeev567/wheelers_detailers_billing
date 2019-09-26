@extends('master')
@section('page_heading','Invoice View')
@section ('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<section class="content-header">
    <h1 class="curr_month">
      Item List
    </h1>
  </section>
  {{ csrf_field() }}

  <!-- Main content -->
  <section class="content">
  <table id="customer-list-table" class="stripe">
      <thead>
        <td>Name</td>
        <td>Price</td>
        <td>Size</td>
        <td>Actions</td>
      </thead>
      <tbody>
        @foreach ($items as $item)
          <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->price_without_tax }}</td>
            <td>{{ ($item->size == 's')?'Small':(($item->size =='m')?'Medium':(($item->size == 'l')?'Large':'-NA-')) }}</td>
            <td> <a href="{{ config('app.app_url_prefix') }}/add-item/{{ $item->id }}" class="btn btn-info">Edit</a>
            | <a class="btn btn-danger delete-item-btn" href="#" data-id="{{ $item->id }}">Delete</a></td>
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
