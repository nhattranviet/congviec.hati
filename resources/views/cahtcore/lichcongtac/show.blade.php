<html><head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="<?php echo '300; url='.$app_url ?>">
	<link rel="shortcut icon" href="{{asset('/assets/images/favicon.ico')}}">
	<title>Công an Hà Tĩnh | Lịch công tác</title>
	{{-- <script src="{{ asset('/assets/js/lich_jquery.min.js') }}"></script> --}}
	<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/assets/js/anphalbootstrap.min.js') }}"></script>
	<script src="{{asset('/assets/js/modernizr.min.js')}}"></script>
	<link href="{{asset('/assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/css/bootstrapanphal.min.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/css/lich_show.css')}}" rel="stylesheet" />
	<style>
		body{
			background-color: #ca043a;
		}
		.trip_viectrongngay, .trip_viectrongtuan{
			display: none;
		}

		.trip_viectrongtuan p, .trip_viectrongngay p, .tripStatic p{
			color: #FFFF24;
			font-size: 150%;
			text-shadow: 1.5px 1.5px rgba(0,0,0,0.5);
		}

		.trip_viectrongtuan strong, .trip_viectrongngay strong, .tripStatic strong{
			color: #ff0036;
		}
		.leftHead{
			width: 35%;
			text-align: center;
			font-size: 150%;
		}

		.rightHead{
			text-align: center;
			font-size: 180%;
			font-weight: bold;
		}
		.lanhdaotructuan{
			text-align: center;
			font-size: 130%;
		}

		.lanhdaotructuan_title{
			text-shadow: 1.5px 1.5px rgba(0,0,0,0.5);
		}

		.lanhdaotructuan_name{
			color: #FFFF00;
		}

		.leftHead_tendonvi{
			font-size: 120%; font-weight: bold;
		}

		.rightHead_tendonvi{
			font-size: 120%;
			font-weight: bold;
		}

		.lich-center{
			text-align: center;
		}

		.lichcontent{
			height: 600px	;
		}

		.footer{
			position:fixed;
			height:50px;
			background-color:#ca043a;
			bottom:0px;
			left:0px;
			right:0px;
			line-height: 50px;
			margin-bottom:0px;
		}

		.firstRow, .lich_title, .lanhdaotructuan_title, .ngaytrongtuan, .ngayhientai{
			color: #FFFF00;
		}

		.firstRow td {
			text-shadow: 1.5px 1.5px rgba(0,0,0,0.5);
		}

		td{
			border-radius: 15px 15px 15px 15px;
			-moz-border-radius: 15px 15px 15px 15px;
			-webkit-border-radius: 15px 15px 15px 15px;
			border: 2px solid #f5f5f5;
		}

		.lich_title{
			font-weight: bold;
			font-size: 150%;
			text-shadow: 1.5px 1.5px rgba(0,0,0,0.5);
		}

		.ngaytrongtuan{
			font-size: 100% !important;
		}

		.ngaytrongtuan, .ngayhientai{
			text-shadow: 1.5px 1.5px rgba(0,0,0,0.5);
			font-size: 120%;
		}

		.footerLeft{
			text-align: right;
			font-size: 120%;
			font-weight: bold;
			text-transform: uppercase;
			padding: 5px 0px 0px 0px !important;
			width: 50px;
		}

		.footerRight{
			font-size: 120%;
			font-weight: bold;
			text-transform: uppercase;
			padding: 0px !important;
			color: #FFFF24;
		}

		.marquee{
		padding: 0px !important;
		}

		.footer{
			border-top: 2px solid #f5f5f5;
		}

		.leftHead_tendonvi{
			text-transform: uppercase;
		}
		.show_title{
			color: #f5f5f5 !important;
		}

	</style>
	
	<script type="text/javascript">//<![CDATA[
		$(document).ready( function () {
			var $elem = $('.trip_viectrongngay'),
			    l = $elem.length,
			    i = 0;

			function go() {
			    $elem.eq(i % l).fadeIn(700, function () {
			        $elem.eq(i % l).delay(15000).fadeOut(700, go);
			        i++;
			    })
			}
			
			var $elem1 = $('.trip_viectrongtuan'),
			    l1 = $elem1.length,
			    i1 = 0;
			function goes() {
			    $elem1.eq(i1 % l1).fadeIn(700, function () {
			        $elem1.eq(i1 % l1).delay(15000).fadeOut(700, goes);
			        i1++;
			    })
			}
			go();
			goes();
		});
		//]]>
	</script>
</head>
<body>
	<div class="container-fluid">
		<div class="row header">
			<table class="table">
		      <tr class="firstRow">
				  @if ( $iddonvi == config('user_config.iddonvi_bangiamdoc') )
					<td valign="middle" style="background-image:url({{ asset('/assets/images/logo_cand.png') }}); background-repeat:no-repeat; background-position: center; background-size: 23% 100%;" class="align-middle leftHead"><span>BỘ CÔNG AN</span> <br /><span class="leftHead_tendonvi">CÔNG AN HÀ TĨNH</span></td>
		        	<td class="align-middle rightHead">LỊCH CÔNG TÁC BAN GIÁM ĐỐC</td>
				  @else
				  	<td valign="middle" style="background-image:url({{ asset('/assets/images/logo_cand.png') }}); background-repeat:no-repeat; background-position: center; background-size: 23% 100%;" class="align-middle leftHead"><span>CÔNG AN HÀ TĨNH</span> <br /><span class="leftHead_tendonvi">{{ $tendonvi }}</td>
		        	<td class="align-middle rightHead">LỊCH CÔNG TÁC LÃNH ĐẠO ĐƠN VỊ</td>
				  @endif
		        
		      </tr>
		      <tr>
		      	<td colspan="2" class="lanhdaotructuan"><span class="lanhdaotructuan_title">Lãnh đạo trực tuần:<i class="fa fa-spin fa-spinner" style="width: auto;margin-right: 10px;"></i> </span><span class="lanhdaotructuan_name"> {!! ($tructuan) ? '<b>Đ/c '.$tructuan->hoten.' - '.$tructuan->tenchucvu.'</b>' : 'Đang cập nhật <img src="'.asset('/assets/images/loading_mini.gif').'" /> ' !!} </span></td>
		      </tr>
		      <tr>
		        <td class="align-middle lich-center"><div class="lich_title">LỊCH TRONG TUẦN</div><div class="ngaytrongtuan"> Từ ngày {{ date('d-m-Y', strtotime($tuan['ngaydautuan'])) }} đến {{ date('d-m-Y', strtotime($tuan['ngaycuoituan'])) }}</div></td>
		        <td class="align-middle lich-center"><div class="lich_title">LỊCH TRONG NGÀY</div><div class="ngayhientai"> ({{ $current_day_name }}) </div></td>
		      </tr>
		      <tr class="lichcontent">
		      	<td class="align-top">

					@php
						if($data_tuan != NULL)
						{
							foreach ($data_tuan as $data)
							{
								$arrCVTuan[] = "<strong class='show_title'>Ngày ".date("d/m", strtotime($data->ngay)).":</strong> ".$data->noidungcongviec;
							}
							$num_arrCVTuan = count($arrCVTuan);
							$i = 0;
							if($num_arrCVTuan == 1)
							{
								echo "<div class='tripStatic'><div><p>".$arrCVTuan[0]."</p></div></div>";
							}
							elseif($num_arrCVTuan == 2)
							{
								echo "<div class='tripStatic'><div><p>".$arrCVTuan[0]."</p></div> <div><p>".$arrCVTuan[1]."</p></div></div>";
							}
							elseif($num_arrCVTuan % 2 == 0)
							{
								while ( $i < $num_arrCVTuan)
									{
										echo "<div class='trip_viectrongtuan'><div><p>".$arrCVTuan[$i]."</p></div> <div><p>".$arrCVTuan[$i+1]."</p></div></div>";
										$i = $i +2;
									}
							}
							elseif($num_arrCVTuan % 2 == 1)
							{
								while ($i < $num_arrCVTuan - 1)
								{
									echo "<div class='trip_viectrongtuan'><div><p>".$arrCVTuan[$i]."</p></div> <div><p>".$arrCVTuan[$i+1]."</p></div></div>";
									$i = $i +2;
								}
									echo "<div class='trip_viectrongtuan'><div><p>".$arrCVTuan[$i]."</p></div></div>";
							}
						}
						else {
							echo '<div style="text-align: center;" class="tripStatic"><p>Đang cập nhật nội dung</p> <p> <img src='.asset('/assets/images/loading.gif').' /></p></div>';
						}
					@endphp  
					
				</td>
		        <td class="align-top">
		        	<?php 
		        		if(isset($data_ngay) && $data_ngay != NULL)
		        		{
		        			foreach ($data_ngay as $ngay)
		        			{
		        				echo '<div class="trip_viectrongngay"><p><strong>Nội dung: </strong>'.$ngay->noidungcongviec.'</p><p><strong>Thời gian: </strong>'.date('H:i', strtotime($ngay->ngay)).'</p><p><strong>Đơn vị chủ trì: </strong>'.$ngay->donvichutri.'</p><p><strong>Lãnh đạo tham dự: </strong>'.( ( isset($congviec_lanhdao[$ngay->id]) ) ? $congviec_lanhdao[$ngay->id] : '' ).'</p><p><strong>Địa điểm: </strong>'.$ngay->diadiem.'</p></div>';
		        			}
		        		}else{
		        			echo '<div style="text-align: center;" class="tripStatic"><p>Đang cập nhật nội dung</p><p> <img src='.asset('/assets/images/loading.gif').' /></p></div>';
		        		}
					?>
		        </td>
		      </tr>
		  </table>
		</div>

		<div class="row footer">
			<div class="col-md-1 footerLeft">
				{{-- style="background-image:url({{ asset('/assets/images/logo_cand.png') }}); background-repeat:no-repeat; background-position: center; background-size: 23% 100%;" class="align-middle leftHead"> --}}
				<img height="80%" src="{{ asset('/assets/images/logo_cand2.png') }}" alt="">
			</div>

			<div class="col-md-11 footerRight">
				<marquee><span style="font-size: 20px">CHỦ ĐỘNG - ĐỔI MỚI - KỶ CƯƠNG - TRÁCH NHIỆM - HIỆU QUẢ | CÔNG AN HÀ TĨNH HỌC TẬP, LÀM THEO 6 ĐIỀU BÁC HỒ DẠY</span></marquee>
			</div>
		</div>
	</div>
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
<script src="{{ asset('/assets/js/jquery.core.js') }}"></script>
</body>
</html>