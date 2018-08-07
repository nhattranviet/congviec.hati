@extends('layouts.masterPage')

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
                    <div class="card-box">
                        <form action="" method="POST" role="form">
                            <div class="col-md-6 col-xs-12 m-t-sm-40 m-t-20">
                                <ul class="m-b-30 nav nav-pills m-b-10" id="myTabalt" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab1" data-toggle="tab" href="#home1" role="tab" aria-controls="home" aria-expanded="true">Trang chính</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab1" data-toggle="tab" href="#profile1" role="tab" aria-controls="profile">Nhân khẩu 1</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab1" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile">Nhân khẩu 2</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabaltContent">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home1" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                                <fieldset class="form-group">
                                                    <label for="hosohokhau_so">Hồ sơ hộ khẩu số <span class="text-danger">*</span></label>
                                                    <input type="text" name="hosohokhau_so" parsley-trigger="change" required placeholder="Nhập tên" class="form-control" id="hosohokhau_so">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="hokhau_so">Hộ khẩu số <span class="text-danger">*</span></label>
                                                    <input type="text" name="hokhau_so" parsley-trigger="change" required placeholder="Nhập tên" class="form-control" id="hokhau_so">
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                                <fieldset class="form-group">
                                                    <label for="so_dktt_so">Sổ đăng ký thường trú số <span class="text-danger">*</span></label>
                                                    <input type="text" name="so_dktt_so" parsley-trigger="change" required placeholder="Nhập tên" class="form-control" id="so_dktt_so">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="so_dktt_toso">Tờ số <span class="text-danger">*</span></label>
                                                    <input type="text" name="so_dktt_toso" parsley-trigger="change" required placeholder="Nhập tên" class="form-control" id="so_dktt_toso">
                                                </fieldset>
                                            </div>
                                            <!-- end col -->
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4 m-t-sm-40">
                                                <fieldset class="form-group">
                                                    <label for="datepicker">Ngày nộp lưu <span class="text-danger">*</span></label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker">
                                                            <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                        </div><!-- input-group -->
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="row m-t-20">
                                            <div class="col-xs-12 col-sm-12">
                                                <h4 class="header-title m-t-0 m-b-30">THÔNG TIN CHỦ HỘ</h4>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                                <fieldset class="form-group">
                                                    <label for="hoten">Họ và tên <span class="text-danger">*</span></label>
                                                    <input type="text" name="hoten" parsley-trigger="change" required placeholder="Họ và tên" class="form-control" id="hoten">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="tenkhac">Tên gọi khác/Biệt danh <span class="text-danger">*</span></label>
                                                    <input type="text" name="tenkhac" parsley-trigger="change" required placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Tôn giáo<span class="text-danger">*</span></label>
                                                    <select name="idtongiao" class="form-control select2">
                                                        <option>Chọn Tôn giáo</option>
                                                        <option>Tôn giáo A</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Quốc tịch<span class="text-danger">*</span></label>
                                                    <select name="idquoctich" class="form-control select2">
                                                        <option>Chọn Quốc tịch</option>
                                                        <option>Quốc tịch A</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Học vấn<span class="text-danger">*</span></label>
                                                    <select name="idtrinhdohocvan" class="form-control select2">
                                                        <option>Chọn Quốc tịch</option>
                                                        <option>Quốc tịch A</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="cmnd_so">Số CMND<span class="text-danger">*</span></label>
                                                    <input type="text" name="cmnd_so" parsley-trigger="change" required placeholder="Họ và tên" class="form-control" id="cmnd_so">
                                                </fieldset>

                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-8">
                                                <fieldset class="form-group">
                                                    <label for="noisinh_view">Nơi sinh <span class="text-danger">*</span></label>
                                                    <input type="text" name="noisinh_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noisinh_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_noisinh" required class="form-control" id="idquocgia_noisinh">
                                                    <input type="text" hidden="hidden" name="idtinh_noisinh" required class="form-control" id="idtinh_noisinh">
                                                    <input type="text" hidden="hidden" name="idhuyen_noisinh" required class="form-control" id="idhuyen_noisinh">
                                                    <input type="text" hidden="hidden" name="idxa_noisinh" required class="form-control" id="idxa_noisinh">
                                                    <input type="text" hidden="hidden" name="chitiet_noisinh" required class="form-control" id="chitiet_noisinh">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="noisinh_view">Nguyên quán<span class="text-danger">*</span></label>
                                                    <input type="text" name="nguyenquan_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="nguyenquan_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_nguyenquan" required class="form-control" id="idquocgia_nguyenquan">
                                                    <input type="text" hidden="hidden" name="idtinh_nguyenquan" required class="form-control" id="idtinh_nguyenquan">
                                                    <input type="text" hidden="hidden" name="idhuyen_nguyenquan" required class="form-control" id="idhuyen_nguyenquan">
                                                    <input type="text" hidden="hidden" name="idxa_nguyenquan" required class="form-control" id="idxa_nguyenquan">
                                                    <input type="text" hidden="hidden" name="chitiet_nguyenquan" required class="form-control" id="chitiet_nguyenquan">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="thuongtru_view">Nơi thường trú<span class="text-danger">*</span></label>
                                                    <input type="text" name="thuongtru_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="thuongtru_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_thuongtru" required class="form-control" id="idquocgia_thuongtru">
                                                    <input type="text" hidden="hidden" name="idtinh_thuongtru" required class="form-control" id="idtinh_thuongtru">
                                                    <input type="text" hidden="hidden" name="idhuyen_thuongtru" required class="form-control" id="idhuyen_thuongtru">
                                                    <input type="text" hidden="hidden" name="idxa_thuongtru" required class="form-control" id="idxa_thuongtru">
                                                    <input type="text" hidden="hidden" name="chitiet_thuongtru" required class="form-control" id="chitiet_thuongtru">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="noiohiennay_view">Nơi ở hiện nay<span class="text-danger">*</span></label>
                                                    <input type="text" name="noiohiennay_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noiohiennay_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_noiohiennay" required class="form-control" id="idquocgia_noiohiennay">
                                                    <input type="text" hidden="hidden" name="idtinh_noiohiennay" required class="form-control" id="idtinh_noiohiennay">
                                                    <input type="text" hidden="hidden" name="idhuyen_noiohiennay" required class="form-control" id="idhuyen_noiohiennay">
                                                    <input type="text" hidden="hidden" name="idxa_noiohiennay" required class="form-control" id="idxa_noiohiennay">
                                                    <input type="text" hidden="hidden" name="chitiet_noiohiennay" required class="form-control" id="chitiet_noiohiennay">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="noilamviec_view">Nơi ở hiện nay<span class="text-danger">*</span></label>
                                                    <input type="text" name="noilamviec_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noilamviec_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_noilamviec" required class="form-control" id="idquocgia_noilamviec">
                                                    <input type="text" hidden="hidden" name="idtinh_noilamviec" required class="form-control" id="idtinh_noilamviec">
                                                    <input type="text" hidden="hidden" name="idhuyen_noilamviec" required class="form-control" id="idhuyen_noilamviec">
                                                    <input type="text" hidden="hidden" name="idxa_noilamviec" required class="form-control" id="idxa_noilamviec">
                                                    <input type="text" hidden="hidden" name="chitiet_noilamviec" required class="form-control" id="chitiet_noilamviec">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Dân tộc<span class="text-danger">*</span></label>
                                                    <select name="iddantoc" class="form-control select2">
                                                        <option>Chọn Dân tộc</option>
                                                        <option>Dân tộc A</option>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">

                                                <fieldset class="form-group">
                                                    <label for="trinhdochuyenmon">Trình độ chuyên môn<span class="text-danger">*</span></label>
                                                    <input type="text" name="trinhdochuyenmon" parsley-trigger="change" required placeholder="Trình độ chuyên môn" class="form-control" id="trinhdochuyenmon">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="biettiengdantoc">Biết tiếng dân tộc<span class="text-danger">*</span></label>
                                                    <input type="text" name="biettiengdantoc" parsley-trigger="change" required placeholder="Biết tiếng dân tộc" class="form-control" id="biettiengdantoc">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="trinhdongoaingu">Trình độ ngoại ngữ<span class="text-danger">*</span></label>
                                                    <input type="text" name="trinhdongoaingu" parsley-trigger="change" required placeholder="Trình độ ngoại ngữ" class="form-control" id="trinhdongoaingu">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Nghề nghiệp<span class="text-danger">*</span></label>
                                                    <select name="idnghenghiep" class="form-control select2">
                                                        <option>Chọn Nghề nghiệp</option>
                                                        <option>Nghề nghiệp A</option>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-8">
                                                <fieldset class="form-group">
                                                    <label for="exampleTextarea">Tóm tắt bản thân (Từ đủ 14 tuổi trở lên đến nay ở đâu, làm gì:) <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="exampleTextarea">Tóm tắt gia đình<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="exampleTextarea">Tiền án (Tội danh, hình phạt, theo bản án số)<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                </fieldset>
                                            </div>

                                        </div>

                                        <div class="row m-t-50">
                                            <div class="col-xs-12 col-sm-12">
                                                <button type="submit" class="btn btn-primary">Thêm hồ sơ</button>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane fade" id="profile1" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row m-t-20">
                                            <div class="col-xs-12 col-sm-12">
                                                <h4 class="header-title m-t-0 m-b-30">THÔNG TIN NHÂN KHẨU 1</h4>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                                <fieldset class="form-group">
                                                    <label for="hoten">Họ và tên <span class="text-danger">*</span></label>
                                                    <input type="text" name="hoten" parsley-trigger="change" required placeholder="Họ và tên" class="form-control" id="hoten">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="tenkhac">Tên gọi khác/Biệt danh <span class="text-danger">*</span></label>
                                                    <input type="text" name="tenkhac" parsley-trigger="change" required placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Tôn giáo<span class="text-danger">*</span></label>
                                                    <select name="idtongiao" class="form-control select2">
                                                        <option>Chọn Tôn giáo</option>
                                                        <option>Tôn giáo A</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Quốc tịch<span class="text-danger">*</span></label>
                                                    <select name="idquoctich" class="form-control select2">
                                                        <option>Chọn Quốc tịch</option>
                                                        <option>Quốc tịch A</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Học vấn<span class="text-danger">*</span></label>
                                                    <select name="idtrinhdohocvan" class="form-control select2">
                                                        <option>Chọn Quốc tịch</option>
                                                        <option>Quốc tịch A</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="cmnd_so">Số CMND<span class="text-danger">*</span></label>
                                                    <input type="text" name="cmnd_so" parsley-trigger="change" required placeholder="Họ và tên" class="form-control" id="cmnd_so">
                                                </fieldset>

                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-8">
                                                <fieldset class="form-group">
                                                    <label for="noisinh_view">Nơi sinh <span class="text-danger">*</span></label>
                                                    <input type="text" name="noisinh_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noisinh_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_noisinh" required class="form-control" id="idquocgia_noisinh">
                                                    <input type="text" hidden="hidden" name="idtinh_noisinh" required class="form-control" id="idtinh_noisinh">
                                                    <input type="text" hidden="hidden" name="idhuyen_noisinh" required class="form-control" id="idhuyen_noisinh">
                                                    <input type="text" hidden="hidden" name="idxa_noisinh" required class="form-control" id="idxa_noisinh">
                                                    <input type="text" hidden="hidden" name="chitiet_noisinh" required class="form-control" id="chitiet_noisinh">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="noisinh_view">Nguyên quán<span class="text-danger">*</span></label>
                                                    <input type="text" name="nguyenquan_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="nguyenquan_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_nguyenquan" required class="form-control" id="idquocgia_nguyenquan">
                                                    <input type="text" hidden="hidden" name="idtinh_nguyenquan" required class="form-control" id="idtinh_nguyenquan">
                                                    <input type="text" hidden="hidden" name="idhuyen_nguyenquan" required class="form-control" id="idhuyen_nguyenquan">
                                                    <input type="text" hidden="hidden" name="idxa_nguyenquan" required class="form-control" id="idxa_nguyenquan">
                                                    <input type="text" hidden="hidden" name="chitiet_nguyenquan" required class="form-control" id="chitiet_nguyenquan">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="thuongtru_view">Nơi thường trú<span class="text-danger">*</span></label>
                                                    <input type="text" name="thuongtru_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="thuongtru_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_thuongtru" required class="form-control" id="idquocgia_thuongtru">
                                                    <input type="text" hidden="hidden" name="idtinh_thuongtru" required class="form-control" id="idtinh_thuongtru">
                                                    <input type="text" hidden="hidden" name="idhuyen_thuongtru" required class="form-control" id="idhuyen_thuongtru">
                                                    <input type="text" hidden="hidden" name="idxa_thuongtru" required class="form-control" id="idxa_thuongtru">
                                                    <input type="text" hidden="hidden" name="chitiet_thuongtru" required class="form-control" id="chitiet_thuongtru">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="noiohiennay_view">Nơi ở hiện nay<span class="text-danger">*</span></label>
                                                    <input type="text" name="noiohiennay_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noiohiennay_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_noiohiennay" required class="form-control" id="idquocgia_noiohiennay">
                                                    <input type="text" hidden="hidden" name="idtinh_noiohiennay" required class="form-control" id="idtinh_noiohiennay">
                                                    <input type="text" hidden="hidden" name="idhuyen_noiohiennay" required class="form-control" id="idhuyen_noiohiennay">
                                                    <input type="text" hidden="hidden" name="idxa_noiohiennay" required class="form-control" id="idxa_noiohiennay">
                                                    <input type="text" hidden="hidden" name="chitiet_noiohiennay" required class="form-control" id="chitiet_noiohiennay">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="noilamviec_view">Nơi ở hiện nay<span class="text-danger">*</span></label>
                                                    <input type="text" name="noilamviec_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noilamviec_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_noilamviec" required class="form-control" id="idquocgia_noilamviec">
                                                    <input type="text" hidden="hidden" name="idtinh_noilamviec" required class="form-control" id="idtinh_noilamviec">
                                                    <input type="text" hidden="hidden" name="idhuyen_noilamviec" required class="form-control" id="idhuyen_noilamviec">
                                                    <input type="text" hidden="hidden" name="idxa_noilamviec" required class="form-control" id="idxa_noilamviec">
                                                    <input type="text" hidden="hidden" name="chitiet_noilamviec" required class="form-control" id="chitiet_noilamviec">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Dân tộc<span class="text-danger">*</span></label>
                                                    <select name="iddantoc" class="form-control select2">
                                                        <option>Chọn Dân tộc</option>
                                                        <option>Dân tộc A</option>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">

                                                <fieldset class="form-group">
                                                    <label for="trinhdochuyenmon">Trình độ chuyên môn<span class="text-danger">*</span></label>
                                                    <input type="text" name="trinhdochuyenmon" parsley-trigger="change" required placeholder="Trình độ chuyên môn" class="form-control" id="trinhdochuyenmon">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="biettiengdantoc">Biết tiếng dân tộc<span class="text-danger">*</span></label>
                                                    <input type="text" name="biettiengdantoc" parsley-trigger="change" required placeholder="Biết tiếng dân tộc" class="form-control" id="biettiengdantoc">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="trinhdongoaingu">Trình độ ngoại ngữ<span class="text-danger">*</span></label>
                                                    <input type="text" name="trinhdongoaingu" parsley-trigger="change" required placeholder="Trình độ ngoại ngữ" class="form-control" id="trinhdongoaingu">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Nghề nghiệp<span class="text-danger">*</span></label>
                                                    <select name="idnghenghiep" class="form-control select2">
                                                        <option>Chọn Nghề nghiệp</option>
                                                        <option>Nghề nghiệp A</option>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-8">
                                                <fieldset class="form-group">
                                                    <label for="exampleTextarea">Tóm tắt bản thân (Từ đủ 14 tuổi trở lên đến nay ở đâu, làm gì:) <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="exampleTextarea">Tóm tắt gia đình<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="exampleTextarea">Tiền án (Tội danh, hình phạt, theo bản án số)<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                </fieldset>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row m-t-20">
                                            <div class="col-xs-12 col-sm-12">
                                                <h4 class="header-title m-t-0 m-b-30">THÔNG TIN NHÂN KHẨU 2</h4>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                                <fieldset class="form-group">
                                                    <label for="hoten">Họ và tên <span class="text-danger">*</span></label>
                                                    <input type="text" name="hoten" parsley-trigger="change" required placeholder="Họ và tên" class="form-control" id="hoten">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="tenkhac">Tên gọi khác/Biệt danh <span class="text-danger">*</span></label>
                                                    <input type="text" name="tenkhac" parsley-trigger="change" required placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Tôn giáo<span class="text-danger">*</span></label>
                                                    <select name="idtongiao" class="form-control select2">
                                                        <option>Chọn Tôn giáo</option>
                                                        <option>Tôn giáo A</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Quốc tịch<span class="text-danger">*</span></label>
                                                    <select name="idquoctich" class="form-control select2">
                                                        <option>Chọn Quốc tịch</option>
                                                        <option>Quốc tịch A</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Học vấn<span class="text-danger">*</span></label>
                                                    <select name="idtrinhdohocvan" class="form-control select2">
                                                        <option>Chọn Quốc tịch</option>
                                                        <option>Quốc tịch A</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="cmnd_so">Số CMND<span class="text-danger">*</span></label>
                                                    <input type="text" name="cmnd_so" parsley-trigger="change" required placeholder="Họ và tên" class="form-control" id="cmnd_so">
                                                </fieldset>

                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-8">
                                                <fieldset class="form-group">
                                                    <label for="noisinh_view">Nơi sinh <span class="text-danger">*</span></label>
                                                    <input type="text" name="noisinh_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noisinh_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_noisinh" required class="form-control" id="idquocgia_noisinh">
                                                    <input type="text" hidden="hidden" name="idtinh_noisinh" required class="form-control" id="idtinh_noisinh">
                                                    <input type="text" hidden="hidden" name="idhuyen_noisinh" required class="form-control" id="idhuyen_noisinh">
                                                    <input type="text" hidden="hidden" name="idxa_noisinh" required class="form-control" id="idxa_noisinh">
                                                    <input type="text" hidden="hidden" name="chitiet_noisinh" required class="form-control" id="chitiet_noisinh">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="noisinh_view">Nguyên quán<span class="text-danger">*</span></label>
                                                    <input type="text" name="nguyenquan_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="nguyenquan_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_nguyenquan" required class="form-control" id="idquocgia_nguyenquan">
                                                    <input type="text" hidden="hidden" name="idtinh_nguyenquan" required class="form-control" id="idtinh_nguyenquan">
                                                    <input type="text" hidden="hidden" name="idhuyen_nguyenquan" required class="form-control" id="idhuyen_nguyenquan">
                                                    <input type="text" hidden="hidden" name="idxa_nguyenquan" required class="form-control" id="idxa_nguyenquan">
                                                    <input type="text" hidden="hidden" name="chitiet_nguyenquan" required class="form-control" id="chitiet_nguyenquan">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="thuongtru_view">Nơi thường trú<span class="text-danger">*</span></label>
                                                    <input type="text" name="thuongtru_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="thuongtru_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_thuongtru" required class="form-control" id="idquocgia_thuongtru">
                                                    <input type="text" hidden="hidden" name="idtinh_thuongtru" required class="form-control" id="idtinh_thuongtru">
                                                    <input type="text" hidden="hidden" name="idhuyen_thuongtru" required class="form-control" id="idhuyen_thuongtru">
                                                    <input type="text" hidden="hidden" name="idxa_thuongtru" required class="form-control" id="idxa_thuongtru">
                                                    <input type="text" hidden="hidden" name="chitiet_thuongtru" required class="form-control" id="chitiet_thuongtru">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="noiohiennay_view">Nơi ở hiện nay<span class="text-danger">*</span></label>
                                                    <input type="text" name="noiohiennay_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noiohiennay_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_noiohiennay" required class="form-control" id="idquocgia_noiohiennay">
                                                    <input type="text" hidden="hidden" name="idtinh_noiohiennay" required class="form-control" id="idtinh_noiohiennay">
                                                    <input type="text" hidden="hidden" name="idhuyen_noiohiennay" required class="form-control" id="idhuyen_noiohiennay">
                                                    <input type="text" hidden="hidden" name="idxa_noiohiennay" required class="form-control" id="idxa_noiohiennay">
                                                    <input type="text" hidden="hidden" name="chitiet_noiohiennay" required class="form-control" id="chitiet_noiohiennay">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="noilamviec_view">Nơi ở hiện nay<span class="text-danger">*</span></label>
                                                    <input type="text" name="noilamviec_view" parsley-trigger="change" required placeholder="Chọn vào đây sẽ hiện lên modal" class="form-control" id="noilamviec_view">
                                                    <input type="text" hidden="hidden" name="idquocgia_noilamviec" required class="form-control" id="idquocgia_noilamviec">
                                                    <input type="text" hidden="hidden" name="idtinh_noilamviec" required class="form-control" id="idtinh_noilamviec">
                                                    <input type="text" hidden="hidden" name="idhuyen_noilamviec" required class="form-control" id="idhuyen_noilamviec">
                                                    <input type="text" hidden="hidden" name="idxa_noilamviec" required class="form-control" id="idxa_noilamviec">
                                                    <input type="text" hidden="hidden" name="chitiet_noilamviec" required class="form-control" id="chitiet_noilamviec">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Dân tộc<span class="text-danger">*</span></label>
                                                    <select name="iddantoc" class="form-control select2">
                                                        <option>Chọn Dân tộc</option>
                                                        <option>Dân tộc A</option>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">

                                                <fieldset class="form-group">
                                                    <label for="trinhdochuyenmon">Trình độ chuyên môn<span class="text-danger">*</span></label>
                                                    <input type="text" name="trinhdochuyenmon" parsley-trigger="change" required placeholder="Trình độ chuyên môn" class="form-control" id="trinhdochuyenmon">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="biettiengdantoc">Biết tiếng dân tộc<span class="text-danger">*</span></label>
                                                    <input type="text" name="biettiengdantoc" parsley-trigger="change" required placeholder="Biết tiếng dân tộc" class="form-control" id="biettiengdantoc">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="trinhdongoaingu">Trình độ ngoại ngữ<span class="text-danger">*</span></label>
                                                    <input type="text" name="trinhdongoaingu" parsley-trigger="change" required placeholder="Trình độ ngoại ngữ" class="form-control" id="trinhdongoaingu">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label>Nghề nghiệp<span class="text-danger">*</span></label>
                                                    <select name="idnghenghiep" class="form-control select2">
                                                        <option>Chọn Nghề nghiệp</option>
                                                        <option>Nghề nghiệp A</option>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-8">
                                                <fieldset class="form-group">
                                                    <label for="exampleTextarea">Tóm tắt bản thân (Từ đủ 14 tuổi trở lên đến nay ở đâu, làm gì:) <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="exampleTextarea">Tóm tắt gia đình<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="exampleTextarea">Tiền án (Tội danh, hình phạt, theo bản án số)<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                                                </fieldset>
                                            </div>

                                        </div>
                                    </div>
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
@endsection