<!DOCTYPE html>
<html lang="en">

<head>
	
	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"> --}}

	<meta charset="utf-8">
	<title>SISERAM</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="description" content="Avenxo Admin Theme">
	<meta name="author" content="KaijuThemes">
	<link rel="shortcut icon" sizes="114x114" href="{{ asset('assets/img/favicon.ico') }}">
	<link type='text/css' href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600'
		rel='stylesheet'>

	<link type="text/css" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	<!-- Font Awesome -->
	<link type="text/css" href="{{ asset('assets/fonts/themify-icons/themify-icons.css') }}" rel="stylesheet"> <!-- Themify Icons -->
	<link type="text/css" href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"> <!-- Core CSS with all styles -->

	<link type="text/css" href="{{ asset('assets/plugins/codeprettifier/prettify.css') }}" rel="stylesheet"> <!-- Code Prettifier -->
	<link type="text/css" href="{{ asset('assets/plugins/iCheck/skins/minimal/blue.css') }}" rel="stylesheet"> <!-- iCheck -->

	<!--[if lt IE 10]>
        <script type="text/javascript" src="assets/js/media.match.min.js"></script>
        <script type="text/javascript" src="assets/js/respond.min.js"></script>
        <script type="text/javascript" src="assets/js/placeholder.min.js"></script>
    <![endif]-->
	<!-- The following CSS are included as plugins and can be removed if unused-->

	<link type="text/css" href="{{ asset('assets/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet"> <!-- FullCalendar -->
	<link type="text/css" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
	<!-- jVectorMap -->
	<link type="text/css" href="{{ asset('assets/plugins/switchery/switchery.css') }}" rel="stylesheet"> <!-- Switchery -->

</head>

<body class="animated-content">
	

	<header id="topnav" class="navbar navbar-default navbar-fixed-top" role="banner">

		<div class="logo-area">
			<span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
				<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
					<span class="icon-bg">
						<i class="ti ti-menu"></i>
					</span>
				</a>
			</span>

			<a class="navbar-brand" href="/">SISERAM</a>

			

		</div><!-- logo-area -->

		<ul class="nav navbar-nav toolbar pull-right">

			

			<li class="dropdown toolbar-icon-bg">
				<a href="#" class="dropdown-toggle username" data-toggle="dropdown">
					<img class="img-circle" src="http://placehold.it/300&text=Placeholder" alt="" />
				</a>
				<ul class="dropdown-menu userinfo arrow">
					<li><a href="#/"><i class="ti ti-user"></i><span>Profile</span></a></li>
					<li><a href="#/"><i class="ti ti-settings"></i><span>Settings</span></a></li>
					{{-- <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search">
						@csrf
						@method('DELETE')
						<button <i class="ti ti-shift-right" type="submit"></i>Logout</button>
					</form> --}}
				<li><a href="{{ route('logout') }}"><i class="ti ti-shift-right"></i><span>Logout</span></a></li>
				</ul>
			</li>

		</ul>

	</header>
	
	<div id="wrapper">
		<div id="layout-static">
			<div class="static-sidebar-wrapper sidebar-default">
				<div class="static-sidebar">
					<div class="sidebar">
						<div class="widget">
							<div class="widget-body">
								<div class="userinfo">
									<div class="avatar">
										<img src="http://placehold.it/300&text=Placeholder"
											class="img-responsive img-circle">
									</div>
									<div class="info">
										<span class="username">Hi,{{ Auth::user()->username}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="widget stay-on-collapse" id="widget-sidebar">
							<nav role="navigation" class="widget-body">
								<ul class="acc-menu">
									<li class="nav-separator"><span>Explore</span></li>
									<li><a href="/"><i class="ti ti-home"></i><span>Dashboard</span></a></li>
									<li><a href="javascript:;"><i class="ti ti-settings"></i><span>Setting</span></a>
										<ul class="acc-menu">
											<li><a href="/parfum">Tabel Parfum</a></li>
											<li><a href="/agen">Tabel Agen</a></li>
										</ul>
									</li>
									<li><a href="javascript:;"><i class="ti ti-notepad"></i><span>Transaksi</span></a>
										<ul class="acc-menu">
											<li><a href="/transaksi">Gudang Pusat</a></li>
											<li><a href="/">Agen</a></li>
										</ul>
									</li>
									<li>

									</li>
									
									<li><a href="javascript:;"><i class="ti ti-file"></i><span>Report</span></a>
										<ul class="acc-menu">
											<li><a href="/lapor/transaksi">Transaksi</a></li>
											<li><a href="/lapor/stok">Stok</a></li>
											
										</ul>
									</li>

								</ul>
							</nav>
						</div>


					</div>
				</div>
			</div>
			<div class="static-content-wrapper">
				<div class="static-content">
					<div class="page-content">
						<ol class="breadcrumb">
							<li class=""><a href="index.html">Home</a></li>
						</ol>
						<div class="container-fluid">
							{{-- @include('sweetalert::alert') --}}
							@yield('isi')
						</div> <!-- .container-fluid -->
					</div> <!-- #page-content -->
				</div>
				<footer role="contentinfo">
					<div class="clearfix">
						<ul class="list-unstyled list-inline pull-left">
							<li>
								<h6 style="margin: 0;">&copy; 2023 MINU</h6>
							</li>
						</ul>
						<button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i
								class="ti ti-arrow-up"></i></button>
					</div>
				</footer>

			</div>
		</div>
	</div>


	<!-- Switcher -->

	<!-- /Switcher -->
	<!-- Load site level scripts -->

	{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> --}}
{{-- <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> --}}

	<script type="text/javascript" src="{{ asset('assets/js/jquery-1.10.2.min.js') }}"></script> <!-- Load jQuery -->
	<script type="text/javascript" src="{{ asset('assets/js/jqueryui-1.10.3.min.js') }}"></script> <!-- Load jQueryUI -->
	<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script> <!-- Load Bootstrap -->
	<script type="text/javascript" src="{{ asset('assets/js/enquire.min.js') }}"></script> <!-- Load Enquire -->

	<script type="text/javascript" src="{{ asset('assets/plugins/velocityjs/velocity.min.js') }}"></script>
	<!-- Load Velocity for Animated Content -->
	<script type="text/javascript" src="{{ asset('assets/plugins/velocityjs/velocity.ui.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('assets/plugins/wijets/wijets.js') }}"></script> <!-- Wijet -->

	<script type="text/javascript" src="{{ asset('assets/plugins/codeprettifier/prettify.js') }}"></script> <!-- Code Prettifier  -->
	<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-switch/bootstrap-switch.js') }}"></script>
	<!-- Swith/Toggle Button -->

	<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}"></script>
	<!-- Bootstrap Tabdrop -->

	<script type="text/javascript" src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script> <!-- iCheck -->

	<script type="text/javascript" src="{{ asset('assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js') }}"></script>
	<!-- nano scroller -->

	<script type="text/javascript" src="{{ asset('assets/js/application.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/demo/demo.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/demo/demo-switcher.js') }}"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

{{-- <script type="text/javascript" src="{{ asset('assets/plugins/form-daterangepicker/daterangepicker.js') }}"></script>     				<!-- Date Range Picker -->
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>      			<!-- Datepicker -->
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>      			<!-- Timepicker -->
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script> <!-- DateTime Picker --> --}}
	
@stack('alert')
@stack('notif')
@stack('date')
</body>


</html>