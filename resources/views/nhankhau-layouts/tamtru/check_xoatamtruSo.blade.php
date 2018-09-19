@extends('layouts.masterPage')

@section('css')
<link href="{{asset('/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

<style type="text/css">
	/* .nhankhautable tr td:first-child{
text-align: right;
} */
</style>
@endsection

@section('content')
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">Xóa tạm trú Sổ tạm trú</h4>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-xs-12">
					<div class="card-box table-responsive">
						<div class="col-xs-12 col-sm-12">
							<table style="margin-bottom: 20px;" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>STT</th>
										<th>Sổ tạm trú số</th>
										<th>Họ tên</th>
										<th>Quan hệ với chủ hộ</th>
										<th>Tạm trú</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>
									@foreach($list_nhankhautamtru as $nhankhautamtru)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $nhankhautamtru->sotamtru_so }}</td>
										<td>{{ $nhankhautamtru->hoten }}</td>
										<td>{{ ($nhankhautamtru->idquanhechuho) ? DB::table('tbl_moiquanhe')->where('id',
											$nhankhautamtru->idquanhechuho)->value('name') : '' }}</td>
										<td> {{ $nhankhautamtru->chitiet_tamtru }} - {{ ($nhankhautamtru->idxa_tamtru) ?
											DB::table('tbl_xa_phuong_tt')->where('id', $nhankhautamtru->idxa_tamtru)->value('name') : '' }} - {{
											($nhankhautamtru->idhuyen_tamtru) ? DB::table('tbl_huyen_tx')->where('id',
											$nhankhautamtru->idhuyen_tamtru)->value('name') : '' }} - {{ ($nhankhautamtru->idtinh_tamtru) ?
											DB::table('tbl_tinh_tp')->where('id', $nhankhautamtru->idtinh_tamtru)->value('name') : '' }}</td>
									</tr>
									<?php $i++; ?>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>
						<div class="col-xs-12">
							<div class="alert alert-danger" id="error-msg" style="display: none">
							</div>
							<div class="alert alert-success" id="success-msg" style="display: none">
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 m-t-10">
							<form id="form-nhankhaus" action="{{ route('post-xoa-tam-tru-So', $idsotamtru) }}" method="POST" role="form" autocomplete="off">
								@csrf
								<div class="row">
									<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
										<fieldset class="form-group {{ ($errors->has('ngayxoa')) ? 'has-danger' : '' }}">
											<label for="datepicker">Ngày xóa <span class="text-danger">*</span> </label>
											<div>
												<div class="input-group">
													<input type="text" name="ngayxoa" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
													<span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
												</div><!-- input-group -->
											</div>
										</fieldset>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-8">
										<fieldset class="form-group {{ ($errors->has('ghichu')) ? 'has-danger' : '' }}">
											<label for="ghichu">Ghi chú/Lý do xóa <span class="text-danger">*</span> </label>
											<input type="text" name="ghichu" parsley-trigger="change" placeholder="Sổ tạm trú" class="form-control" id="ghichu" value="">
										</fieldset>
									</div>
								</div>
								<div class="row m-t-10">
									<div class="col-xs-12 col-sm-12">
										<button type="submit" class="btn btn-primary">Xóa tạm trú</button>
										<a href="{{ route( 'chi-tiet-so-tam-tru', $idsotamtru ) }}" class="btn btn-primary waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Quay lại</a>
									</div>
								</div>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- container -->
	</div>
	<!-- content -->
</div>
@endsection

@section('js')
<script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function () {
		$('.datatable').DataTable({
			"paging": false,
			"ordering": false,
			"info": false,
			"searching": true,
		});
	});
</script>
@endsection