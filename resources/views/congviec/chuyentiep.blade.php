@extends('layouts.masterPage')

@section('js')
   <script type="text/javascript">
      $(document).ready(function(){
         
      })
   </script>
@endsection

@section('css')
<link href="{{asset('/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

<style type="text/css">
    .button-list a{
        margin: 0px 0px;
        padding: 0.35em;
    }

    .button-list a i {
        font-size: 1.15em;
    }
</style>
@endsection

@section('content')
<div class="content-page">
<!-- Start content -->
<div class="content">
    <div class="container">
        <!-- end row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger" id="error-msg" style="display: none">
                </div>
                <div class="alert alert-success" id="success-msg" style="display: none">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card-box table-responsive">
                    <div class="row">
                            <div class="col-xs-12 col-sm-12" id="ajax_table" style="position: relative;">
                                @include('congviec.chitiet_congviec_table')
                                <a href="{{ route('cong-viec.index') }}" class="btn btn-primary pull-right">Quay lại</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <form id="form-nhankhau" action="{{ route('post-chuyentiep-cong-viec', $congviec_info->id) }}" method="POST" role="form">
                    @csrf
                    <div class="card-box table-responsive">
                        <div class="row">
                            <div class="col-md-3">
                                <fieldset class="form-group" >
                                    <label>Đội nhận việc<span class="text-danger">*</span></label>
                                    <select name="id_iddonvi_iddoi" id="iddoicongtac" class="form-control select2">
                                        <option value="">Chọn đội công tác</option>
                                        @foreach($list_doicongtac as $doicongtac)
                                        <option value="{{ $doicongtac->id }}">{{ $doicongtac->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>

                            <div class="col-md-3">
                                <fieldset class="form-group" >
                                    <label>Cán bộ nhận việc<span class="text-danger">*</span></label>
                                    <select name="idcanbonhan" id="idcanbo" class="form-control select2 canbo">
                                        <option value="">Chọn cán bộ nhận việc</option>
                                    </select>
                                </fieldset>
                            </div>

                            <div class="col-md-3">
                                <fieldset class="form-group" >
                                    <label>Thời gian lãnh đạo giao hoàn thành<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="input-group">
                                            <input type="text" name="hanxuly" value="{{ ($congviec_info->hancongviec != NULL) ? date('d-m-Y', strtotime($congviec_info->hancongviec)) : NULL }}" class="form-control pull-right" id="datepicker">
                                            <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-3">
                                <fieldset class="form-group" >
                                    <label>Thời gian bắt đầu tính giao việc<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="input-group">
                                            <input type="text" name="thoigiangiao" value="" class="form-control pull-right datepicker_get_current_date">
                                            <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-12">
                                <fieldset class="form-group">
                                    <label for="datepicker">Bút phê/Ghi chú chuyển</label>
                                    <div>
                                        <div class="input-group">
                                            <input type="text" name="ghichu" class="form-control" value="">
                                            <span class="input-group-addon bg-custom b-0"><i class="zmdi zmdi-calendar-note"></i></span>
                                        </div><!-- input-group -->
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-1">
                                <fieldset class="form-group">
                                    <label for="datepicker">&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary"> <i class="zmdi zmdi-forward"></i> Chuyển</button>
                                    </div>
                                </fieldset>
                                
                            </div>
                        </div>
                    </div>
                </form>
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
      $(document).ready(function() {
         $('.datatable').DataTable({
            "paging":   false,
            "ordering": false,
            "info": false,
            "searching": true,
         });
      });
   </script>
@endsection