@extends('layouts.masterPage')

@section('js')
    <script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var config = {};
            config.entities_latin = false
            $('.ckeditor').ckeditor(
                {
                    height: 100,
                    entities_latin: false,
                    filebrowserBrowseUrl: '{{ asset('/assets/ckfinder/ckfinder.html') }}',
                    filebrowserImageBrowseUrl: '{{ asset('/assets/ckfinder/ckfinder.html?type=Images') }}',
                    filebrowserFlashBrowseUrl: '{{ asset('/assets/ckfinder/ckfinder.html?type=Flash') }}',
                    filebrowserUploadUrl: '{{ asset('/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
                    filebrowserImageUploadUrl: '{{ asset('/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
                    filebrowserFlashUploadUrl: '{{ asset('/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
                }
            );

            if($(".datepicker_get_date_after_a_week").length > 0)
            {
                var current_date = new Date();
                current_date.setDate(current_date.getDate() + 7);
                $('.datepicker_get_date_after_a_week').datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                    language: 'vi',
                    todayHighlight: true
                }).datepicker('update', current_date);
            }


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
                    <div class="alert alert-danger" id="error-msg" style="display: none">
                    </div>
                    <div class="alert alert-success" id="success-msg" style="display: none">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box">

                        <form id="form-nhankhau" action="{{ route('post-edit-cong-viec', $congviec_info->id) }}" method="POST" role="form">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 class="header-title m-t-0 pull-left">{{ $page_name }}</h4>
                                </div>
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                                    <div class="row hokhau-code">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Số tài liệu/Ký hiệu<span class="text-danger">*</span></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="sotailieu" value="{{ $congviec_info->sotailieu }}" placeholder="Số, ký hiệu văn bản hoặc ký hiệu công việc" class="form-control pull-right">
                                                        <span class="input-group-addon bg-custom b-0"><i class="fa fa-file-pdf-o"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Nơi soạn thảo</label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="noisoanthao" placeholder="Nơi soạn thảo văn bản, đề ra công việc" value="{{ $congviec_info->noisoanthao }}" class="form-control pull-right">
                                                        <span class="input-group-addon bg-custom b-0"><i class="fa fa-building"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                            
                                            <fieldset class="form-group">
                                                <label for="exampleTextarea">Trích yếu<span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="trichyeu" placeholder="Nhập trích yếu của văn bản, công việc" rows="1">{{ $congviec_info->trichyeu }}</textarea>
                                            </fieldset>

                                            <fieldset class="form-group" >
                                                <label>Lãnh đạo duyệt<span class="text-danger">*</span></label>
                                                <select name="idcanbonhan" class="form-control select2">
                                                    <option value="">Chọn lãnh đạo duyệt ban đầu</option>
                                                    @foreach($list_lanhdao as $lanhdao)
                                                    <option {{ ($idcanboxulybandau == $lanhdao->id) ? 'selected' : NULL }} value="{{ $lanhdao->id }}">{{ $lanhdao->hoten }} - {{ $lanhdao->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                            
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                            
                                            <fieldset class="form-group">
                                                <label for="datepicker">Hạn công việc <span class="text-danger">*</span></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="hancongviec" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="{{ ($congviec_info->hancongviec) ? date('d-m-Y', strtotime($congviec_info->hancongviec)) : NULL }}">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Hạn xử lý xong <span class="text-danger">*</span></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="hanxuly" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="{{ ($congviec_info->hanxuly) ? date('d-m-Y', strtotime($congviec_info->hanxuly)) : NULL }}">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Ghi chú<span class="text-danger">*</span></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="ghichu" placeholder="Nhập cán bộ nhập văn bản" value="{{ $congviec_info->ghichu }}" class="form-control pull-right">
                                                        <span class="input-group-addon bg-custom b-0"><i class="fa fa-user"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>

                                            <fieldset class="form-group" >
                                                <label>Trạng thái<span class="text-danger">*</span></label>
                                                <select name="idstatus" class="form-control select2">
                                                    <option value="">Chọn trạng thái</option>
                                                    <option {{ ($congviec_info->idstatus == 1) ? 'selected' : NULL }} value="1">Đang xử lý</option>
                                                    <option {{ ($congviec_info->idstatus == 2) ? 'selected' : NULL }} value="2">Hoàn thành</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                            <fieldset class="form-group">
                                                <label for="exampleTextarea">Chi tiết công việc</label>
                                                <textarea class="form-control ckeditor" name="chitiet">{{ $congviec_info->chitiet }}</textarea>
                                            </fieldset>
                                        </div>
                                        


                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    <a href="{{ route('cong-viec.index') }}" class="btn btn-danger waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Quay lại</a>
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
