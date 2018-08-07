@extends('layouts.masterPage')

@section('css_code')
    <style type="text/css">
        .has-danger ~ .select2 .select2-selection {
          border: 1px solid #ff5d48;
        }
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
                        <h4 class="page-title">Thêm hồ sơ</h4>
                        <ol class="breadcrumb p-0">
                            <li>
                                <a href="#">Uplon</a>
                            </li>
                            <li>
                                <a href="#">Pages</a>
                            </li>
                            <li class="active">
                                Thêm hồ sơ
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
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

                        <form action="{{ route('dang-ky-thuong-tru', 11) }}" method="POST" role="form">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 class="header-title m-t-0 pull-left">ĐĂNG KÝ THƯỜNG TRÚ</h4>
                                    <div class="btn-group pull-right m-t-15">

                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                                    <ul class="m-b-30 nav nav-tabs m-b-10" id="myTabalt" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab1" data-toggle="tab" href="#home1" role="tab" aria-controls="home" aria-expanded="true">Thông tin nhân khẩu</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabaltContent">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home1" aria-labelledby="home-tab">
                                            <div>

                                                <div class="row m-t-20">

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                                        <fieldset class="form-group {{ ($errors->has('hoten')) ? 'has-danger' : '' }}">
                                                            <label for="hoten">Họ tên<span class="text-danger">*</span></label>
                                                            <input type="text" value="{{ old('hoten') }}" name="hoten" parsley-trigger="change" placeholder="Nhập họ tên" class="form-control" id="hoten">
                                                        </fieldset>

                                                        <fieldset class="form-group {{ ($errors->has('tenkhac')) ? 'has-danger' : '' }}">
                                                            <label for="tenkhac">Tên khác<span class="text-danger">*</span></label>
                                                            <input type="text" value="{{ old('tenkhac') }}" name="tenkhac" parsley-trigger="change" placeholder="Nhập họ tên" class="form-control" id="tenkhac">
                                                        </fieldset>

                                                        <fieldset class="form-group" >
                                                            <label>Tôn giáo<span class="text-danger">*</span></label>
                                                            <select id="tongiao" name="idtongiao" class="form-control select2  {{ ($errors->has('idtongiao')) ? 'has-danger' : '' }}">
                                                                <option value="">Chọn tôn giáo</option>
                                                                @foreach($list_tongiao as $tongiao)
                                                                    <option value="{{ $tongiao->id }}"  {{ old('idtongiao') == $tongiao->id ? 'selected' : '' }}>{{ $tongiao->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>

                                                        <fieldset class="form-group" >
                                                            <label>Quốc tịch<span class="text-danger">*</span></label>
                                                            <select id="quoctich" name="idquoctich" class="form-control select2  {{ ($errors->has('idquoctich')) ? 'has-danger' : '' }}">
                                                                <option value="">Chọn quốc tịch</option>
                                                                @foreach($list_quoctich as $quoctich)
                                                                    <option value="{{ $quoctich->id }}"  {{ old('idquoctich') == $quoctich->id ? 'selected' : '' }}>{{ $quoctich->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>

                                                        <fieldset class="form-group" >
                                                            <label>Học vấn<span class="text-danger">*</span></label>
                                                            <select id="trinhdohocvan" name="idtrinhdohocvan" class="form-control select2  {{ ($errors->has('idtrinhdohocvan')) ? 'has-danger' : '' }}">
                                                                <option value="">Chọn trình độ học vấn</option>
                                                                @foreach($list_trinhdohocvan as $trinhdohocvan)
                                                                    <option value="{{ $trinhdohocvan->id }}"  {{ old('idtrinhdohocvan') == $trinhdohocvan->id ? 'selected' : '' }}>{{ $trinhdohocvan->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>

                                                        <fieldset class="form-group" >
                                                            <label>Nghề nghiệp<span class="text-danger">*</span></label>
                                                            <select id="nghenghiep" name="idnghenghiep" class="form-control select2  {{ ($errors->has('idnghenghiep')) ? 'has-danger' : '' }}">
                                                                <option value="">Chọn nghề nghiệp</option>
                                                                @foreach($list_nghenghiep as $nghenghiep)
                                                                    <option value="{{ $nghenghiep->id }}"  {{ old('idnghenghiep') == $nghenghiep->id ? 'selected' : '' }}>{{ $nghenghiep->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>

                                                        <fieldset class="form-group" >
                                                            <label>Dân tộc<span class="text-danger">*</span></label>
                                                            <select id="dantoc" name="iddantoc" class="form-control select2  {{ ($errors->has('iddantoc')) ? 'has-danger' : '' }}">
                                                                <option value="">Chọn dân tộc</option>
                                                                @foreach($list_dantoc as $dantoc)
                                                                    <option value="{{ $dantoc->id }}"  {{ old('iddantoc') == $dantoc->id ? 'selected' : '' }}>{{ $dantoc->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>

                                                        <fieldset class="form-group {{ ($errors->has('cmnd_so')) ? 'has-danger' : '' }}">
                                                            <label for="cmnd_so">Số CMND<span class="text-danger">*</span></label>
                                                            <input type="text" value="{{ old('cmnd_so') }}" name="cmnd_so" parsley-trigger="change" placeholder="Nhập họ tên" class="form-control" id="cmnd_so">
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="trinhdochuyenmon">Trình độ chuyên môn<span class="text-danger">*</span></label>
                                                            <input type="text" name="trinhdochuyenmon" parsley-trigger="change" placeholder="Trình độ chuyên môn" class="form-control" id="trinhdochuyenmon">
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="biettiengdantoc">Biết tiếng dân tộc<span class="text-danger">*</span></label>
                                                            <input type="text" name="biettiengdantoc" parsley-trigger="change" placeholder="Biết tiếng dân tộc" class="form-control" id="biettiengdantoc">
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="trinhdongoaingu">Trình độ ngoại ngữ<span class="text-danger">*</span></label>
                                                            <input type="text" name="trinhdongoaingu" parsley-trigger="change" placeholder="Trình độ ngoại ngữ" class="form-control" id="trinhdongoaingu">
                                                        </fieldset>

                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-8">
                                                        <fieldset class="form-group" id="addressPickerGroup">
                                                            <label for="thuongtru_view">Nơi thường trú<span class="text-danger">*</span></label>
                                                            <input type="text" name="thuongtru_view" parsley-trigger="change" id="addressPicker" placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="thuongtru_view">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" hidden="hidden" name="idquocgia_thuongtru" class="form-control" id="idquocgia_thuongtru">
                                                            <input type="hidden" hidden="hidden" name="idtinh_thuongtru" class="form-control" id="idtinh_thuongtru">
                                                            <input type="hidden" hidden="hidden" name="idhuyen_thuongtru" class="form-control" id="idhuyen_thuongtru">
                                                            <input type="hidden" hidden="hidden" name="idxa_thuongtru" class="form-control" id="idxa_thuongtru">
                                                            <input type="hidden" hidden="hidden" name="chitiet_thuongtru" class="form-control" id="chitiet_thuongtru">
                                                        </fieldset>

                                                        <fieldset class="form-group" id="addressPickerGroup">
                                                            <label for="noisinh_view">Nơi sinh <span class="text-danger">*</span></label>
                                                            <input type="text" name="noisinh_view" parsley-trigger="change" id="addressPicker" placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noisinh_view">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" hidden="hidden" name="idquocgia_noisinh" class="form-control" id="idquocgia_noisinh">
                                                            <input type="hidden" hidden="hidden" name="idtinh_noisinh" class="form-control" id="idtinh_noisinh">
                                                            <input type="hidden" hidden="hidden" name="idhuyen_noisinh" class="form-control" id="idhuyen_noisinh">
                                                            <input type="hidden" hidden="hidden" name="idxa_noisinh" class="form-control" id="idxa_noisinh">
                                                            <input type="hidden" hidden="hidden" name="chitiet_noisinh" class="form-control" id="chitiet_noisinh">
                                                        </fieldset>

                                                        <fieldset class="form-group" id="addressPickerGroup">
                                                            <label for="noisinh_view">Nguyên quán<span class="text-danger">*</span></label>
                                                            <input type="text" name="nguyenquan_view" parsley-trigger="change" id="addressPicker" placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="nguyenquan_view">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" hidden="hidden" name="idquocgia_nguyenquan" class="form-control" id="idquocgia_nguyenquan">
                                                            <input type="hidden" hidden="hidden" name="idtinh_nguyenquan" class="form-control" id="idtinh_nguyenquan">
                                                            <input type="hidden" hidden="hidden" name="idhuyen_nguyenquan" class="form-control" id="idhuyen_nguyenquan">
                                                            <input type="hidden" hidden="hidden" name="idxa_nguyenquan" class="form-control" id="idxa_nguyenquan">
                                                            <input type="hidden" hidden="hidden" name="chitiet_nguyenquan" class="form-control" id="chitiet_nguyenquan">
                                                        </fieldset>

                                                        <fieldset class="form-group" id="addressPickerGroup">
                                                            <label for="noiohiennay_view">Nơi ở hiện nay<span class="text-danger">*</span></label>
                                                            <input type="text" name="noiohiennay_view" parsley-trigger="change" id="addressPicker" placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noiohiennay_view">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" hidden="hidden" name="idquocgia_noiohiennay" class="form-control" id="idquocgia_noiohiennay">
                                                            <input type="hidden" hidden="hidden" name="idtinh_noiohiennay" class="form-control" id="idtinh_noiohiennay">
                                                            <input type="hidden" hidden="hidden" name="idhuyen_noiohiennay" class="form-control" id="idhuyen_noiohiennay">
                                                            <input type="hidden" hidden="hidden" name="idxa_noiohiennay" class="form-control" id="idxa_noiohiennay">
                                                            <input type="hidden" hidden="hidden" name="chitiet_noiohiennay" class="form-control" id="chitiet_noiohiennay">
                                                        </fieldset>

                                                        <fieldset class="form-group" id="addressPickerGroup">
                                                            <label for="noilamviec_view">Nơi làm việc<span class="text-danger">*</span></label>
                                                            <input type="text" name="noilamviec_view" parsley-trigger="change" id="addressPicker" placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noilamviec_view">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" hidden="hidden" name="idquocgia_noilamviec" class="form-control" id="idquocgia_noilamviec">
                                                            <input type="hidden" hidden="hidden" name="idtinh_noilamviec" class="form-control" id="idtinh_noilamviec">
                                                            <input type="hidden" hidden="hidden" name="idhuyen_noilamviec" class="form-control" id="idhuyen_noilamviec">
                                                            <input type="hidden" hidden="hidden" name="idxa_noilamviec" class="form-control" id="idxa_noilamviec">
                                                            <input type="hidden" hidden="hidden" name="chitiet_noilamviec" class="form-control" id="chitiet_noilamviec">
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="exampleTextarea">Tóm tắt bản thân (Từ đủ 14 tuổi trở lên đến nay ở đâu, làm gì:) <span class="text-danger">*</span></label>
                                                            <textarea rows="6" class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="exampleTextarea">Tóm tắt gia đình<span class="text-danger">*</span></label>
                                                            <textarea rows="6" class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="exampleTextarea">Tiền án (Tội danh, hình phạt, theo bản án số)<span class="text-danger">*</span></label>
                                                            <textarea rows="5" class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                        </fieldset>

                                                        
                                                    </div>

                                                    

                                                   

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-50">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Thêm hồ sơ</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </div>
    <!-- content -->
</div>

<div class="modal fade" id="address-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modal title</h4>
        </div>
        <div class="modal-body p-20">
          <div class="row">
            <div class="col-md-6">
              <fieldset class="form-group">
                <label class="control-label">Quốc gia</label>
                <select id="country" class="form-control select2">
                    <option  value="">Chọn Quốc gia</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
              </fieldset>
            </div>
            <div class="col-md-6">
              <fieldset class="form-group">
                <label class="control-label">Tỉnh TP</label>
                <select id="province" class="form-control select2">
                    <option value="">Chọn Tỉnh hoặc Thành Phố</option>
                </select>
              </fieldset>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <fieldset class="form-group">
                <label class="control-label">Huyện</label>
                <select id="district" class="form-control select2">
                    <option  value="">Chọn Huyện</option>
                </select>
              </fieldset>
            </div>
            <div class="col-md-6">
              <fieldset class="form-group">
                <label class="control-label">Xã</label>
                <select id="ward" class="form-control select2">
                    <option value="">Chọn Xã</option>
                </select>
              </fieldset>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <fieldset class="form-group">
                <label class="control-label">Chi tiết địa chỉ</label>
                <textarea class="form-control" id="addressDetail" placeholder="Nhập chi tiét địa " rows="3"></textarea>
              </fieldset>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          <button type="button" id="saveChange" class="btn btn-primary" data-dismiss="modal">Chọn</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.1"></script>
@endsection