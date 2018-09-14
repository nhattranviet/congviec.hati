<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
	<meta name="author" content="Coderthemes">
	<!-- App Favicon -->
	<link rel="shortcut icon" href="{{asset('/assets/images/favicon.ico')}}">
	<!-- App title -->
	<title>Trang chủ - Hệ thống quản lý hộ khẩu </title>
	<!-- Switchery css -->
	<link href="{{asset('/assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet" />

	<!-- Plugins css -->
	<link href="{{asset('/assets/plugins/toastr/toastr.min.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/plugins/mjolnic-bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/plugins/multiselect/css/multi-select.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

	<!-- App CSS -->
	<link href="{{asset('/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
	@yield('css')
	<link href="{{asset('/css/app.css')}}?v=1.0.0" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.has-danger ~ .select2 .select2-selection {
		border: 1px solid #ff5d48;
		}
		.profile-dropdown {
			width: 250px;
		}

		.center{
			text-align: center;
		}

	</style>
	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	<!-- Modernizr js -->
	<script src="{{asset('/assets/js/modernizr.min.js')}}"></script>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script>
	var bare_url = "{{ URL::to('/') }}";
	</script>
</head>
<body>
	{{-- <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='demo_wait.gif' width="64" height="64" /><br>Loading..</div> --}}
	<img id="wait" style="display:none; position: absolute; left: 45%; top: 40%; z-index: 100000;" src="/img/loading.gif" />
	<!-- Begin page -->
	<div id="wrapper" class="enlarged forced">
	<!-- Top Bar Start -->
	@include('commons.topBar')
	<!-- Top Bar End -->
	<!-- ========== Left Sidebar Start ========== -->
	@include('commons.leftBar')
	<!-- Left Sidebar End -->
	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	@yield('content')
	<!-- End content-page -->
	<!-- ============================================================== -->
	<!-- End Right content here -->
	<!-- ============================================================== -->
	<!-- Right Sidebar -->
	{{-- @include('commons.rightBar') --}}
	<!-- /Right-bar -->
	<footer class="footer text-right">
		@php
			echo date('Y', time());
		@endphp © {{ Session::get('userinfo')->tendonvi }}
	</footer>
	</div>
	<!-- END wrapper -->
	<!-- jQuery  -->
	<script>
	var resizefunc = [];
	</script>
	<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/assets/js/tether.min.js') }}"></script>
	<!-- Tether for Bootstrap -->
	<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/assets/js/detect.js') }}"></script>
	<script src="{{ asset('/assets/js/fastclick.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery.blockUI.js') }}"></script>
	<script src="{{ asset('/assets/js/waves.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery.nicescroll.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery.scrollTo.min.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery.slimscroll.js') }}"></script>
	<script src="{{ asset('/assets/plugins/switchery/switchery.min.js') }}"></script>

	

	<script src="{{ asset('/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
	<script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
	{{-- <script src="{{ asset('/assets/plugins/select2/js/select2-tab-fix.min.js') }}"></script> --}}
	<script src="{{ asset('/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/moment/moment.js') }}"></script>
	<script src="{{ asset('/assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/mjolnic-bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/clockpicker/bootstrap-clockpicker.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('/assets/pages/jquery.form-pickers.init.js') }}"></script>
	<script src="{{ asset('/assets/pages/jquery.formadvanced.init.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery.core.js') }}"></script>
	<script src="{{ asset('/assets/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
	<script src="{{ asset('/assets/ckeditor/adapters/jquery.js') }}"></script>
	@yield('js')
	<!-- App js -->
	
	<script src="{{ asset('/assets/js/jquery.app.js?v=1.0.0') }}"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		var config = {};
		config.entities_latin = false
		$('.ckeditor').ckeditor(
			{
				height: 150,
				entities_latin: false,
				enterMode: CKEDITOR.ENTER_BR,
				filebrowserBrowseUrl: "{{ route('ckfinder-get-view') }}",
				filebrowserImageBrowseUrl: "{{ route('ckfinder-get-view') }}?type=Images",
				filebrowserFlashBrowseUrl: "{{ route('ckfinder-get-view') }}?type=ImaFlashges",
				filebrowserUploadUrl: "{{ route('ckfinder-get-connector') }}?command=QuickUpload&type=Files",
				filebrowserImageUploadUrl: "{{ route('ckfinder-get-connector') }}?command=QuickUpload&type=Images",
			}
		);
		
		@if(session('alert_message'))
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": true,
				"progressBar": true,
				"positionClass": "toast-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "6000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}
			Command: toastr["{{ session('alert_message')['type'] }}"]("{{ session('alert_message')['content'] }}")
		@endif
	});
	</script>
</body>
</html>