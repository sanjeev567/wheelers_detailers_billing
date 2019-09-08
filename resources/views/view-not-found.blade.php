@extends('master')
@section ('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="curr_month">
      Error
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <h1 class="curr_month">{{ $viewName }} not found</h1>
  </section>
  <!-- /.content -->
</div>
@endsection