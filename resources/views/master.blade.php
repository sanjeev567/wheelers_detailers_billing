<!DOCTYPE html>
<html>

<head>
  <link rel="shortcut icon" type="image/x-icon" href="{{ config('app.app_url_prefix') }}/img/mars-logo.png"/>
  @include('partials.header')
  @yield('styles')
</head>

<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="{{ config('app.app_url_prefix') }}/" class="logo">
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Wheelers Detailers Pvt Ltd </b></span>
        <span class="logo-mini"><b>W</b>D</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            @include('partials.user_account')
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    @include('partials.sidebar')

    <input type="hidden" value="{{ config('app.app_url_prefix') }}" id="app_url_prefix">
    @yield('content')

    <footer class="main-footer">
      <strong>Copyright &copy; 2019 Wheelers Detailers Pvt Ltd.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- Ajax loader -->
  <div class="loader-backdrop" id="loader" style="display:none;">
    <div class="loader"></div>
  </div>
  <!-- Ajax loader -->

  <!-- Flash Alerts -->
  <div class="alert alert-success custom-alert" role="alert" style="display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong class="custom-alert-content">Success!</strong>
  </div>
  <div class="alert alert-danger custom-alert" role="alert" style="display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong class="custom-alert-content">Error!</strong>
  </div>
  <!-- Flash Alerts ends -->

  @include('partials.footer_scripts')
  @yield('body_scripts')
</body>

</html>