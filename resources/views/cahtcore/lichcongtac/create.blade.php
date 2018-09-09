@extends('layouts.masterPage')

@section('js')
    <script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
        });
    </script>
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <!-- end row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ $page_name }}</h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box">

                        <form id="form-nhankhaus" action="{{ route('lich-cong-tac.store',$iddonvi) }}" method="POST" role="form" autocomplete="off">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="alert alert-danger" id="error-msg" style="display: none"></div>
                                    <div class="alert alert-success" id="success-msg" style="display: none"></div>
                                </div>

                                <div class="col-md-6 m-t-sm-40 m-t-20 m-b-40">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Giờ<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input  id="timepicker2" type="text" name="gio" class="form-control" placeholder="Nhập giờ của công việc" value="7:00">
                                                    <span class="input-group-addon"><i class="zmdi zmdi-time"></i></span>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Ngày<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" name="ngay" class="form-control datepicker-autoclose" placeholder="Chọn ngày của công việc" value=""  autocomplete="off">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Lãnh đạo tham dự<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <select multiple="multiple" name="lanhdaothamdu[]" class="form-control select2" style="width: 100%;">
                                                            @foreach ($list_lanhdao as $lanhdao)
                                                                <option value="{{ $lanhdao->id }}"> {{ 'Đ/c '.$lanhdao->hoten.' ('.$lanhdao->tenchucvu.')' }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- input-group -->
                                            </fieldset>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6 m-t-sm-40 m-t-20 m-b-40">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Đơn vị chủ trì<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" name="donvichutri" class="form-control" placeholder="Nhập đơn vị chủ trì công việc" value="">
                                                        <span class="input-group-addon bg-custom b-0"><i class="fa fa-home"></i></span>
                                                    </div><!-- input-group -->
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Địa điểm<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <select name="diadiem_select" class="form-control select2" style="width: 100%;">
                                                            <option value="">Chọn địa điểm</option>
                                                            <option>Công an tỉnh</option>
                                                            <option>Trụ sở Cảnh sát</option>
                                                            <option>UBND tỉnh</option>
                                                            <option>Tỉnh ủy</option>
                                                            <option>Quân sự tỉnh</option>
                                                            <option>Biên phòng tỉnh</option>
                                                        </select>
                                                    </div><!-- input-group -->
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Địa điểm khác<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" name="diadiemkhac" class="form-control" placeholder="Nhập địa điểm khác nếu không có ở trên" value="">
                                                        <span class="input-group-addon bg-custom b-0"><i class="fa fa-clock-o"></i></span>
                                                    </div><!-- input-group -->
                                            </fieldset>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12 m-t-sm-40 m-t-10 m-b-40">
                                    <fieldset class="form-group">
                                        <label for="exampleTextarea">Nội dung công việc</label>
                                        <textarea class="form-control ckeditor" name="noidungcongviec"></textarea>
                                    </fieldset>
                                </div>
                                
                            </div>
                            <div class="row m-t-10">
                                <div class="col-md-12">
                                    <button type="submit" name="submit" class="btn btn-primary" value="save"> <i class="fa fa-save"></i> Lưu</button>
                                    <button type="submit" name="submit" class="btn btn-warning" value="saveandnew"> <i class="fa fa-save"></i> Lưu và Thêm</button>
                                    <a href="{{ route('lich-cong-tac.index', $iddonvi) }}" class="btn btn-danger waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Quay lại</a>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </div>
    <!-- content -->
</div>
@endsection
