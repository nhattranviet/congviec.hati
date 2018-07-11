<div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
    <ul class="m-b-30 nav nav-tabs m-b-10" id="myTabalt" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab1" data-toggle="tab" href="#home1" role="tab" aria-controls="home" aria-expanded="true">Trang chính</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabaltContent">
        <div role="tabpanel" class="tab-pane fade in active" id="home1" aria-labelledby="home-tab">
            <div>
                <div class="row hokhau-code">
                    <div class="col-xs-12 col-sm-12 tab-header">
                        <h4 class="header-title m-t-0 m-b-10">THÔNG TIN HỒ SƠ</h4>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                        <fieldset class="form-group">
                            <label for="hosohokhau_so">Hồ sơ hộ khẩu số <span class="text-danger">*</span></label>
                            <input type="text" name="hosohokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hosohokhau_so" value="@if(isset($brief)){{$brief->hosohokhau_so}} @endif">
                        </fieldset>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                        <fieldset class="form-group">
                            <label for="hokhau_so">Hộ khẩu số <span class="text-danger">*</span></label>
                            <input type="text" name="hokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hokhau_so" value="@if(isset($brief)){{$brief->hokhau_so}} @endif">
                        </fieldset>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                        <fieldset class="form-group">
                            <label for="so_dktt_so">Sổ đăng ký thường trú số <span class="text-danger">*</span></label>
                            <input type="text" name="so_dktt_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_so" value="@if(isset($brief)) {{ $brief->so_dktt_so}} @endif">
                        </fieldset>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                        <fieldset class="form-group">
                            <label for="so_dktt_toso">Tờ số <span class="text-danger">*</span></label>
                            <input type="text" name="so_dktt_toso" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_toso" value="@if(isset($brief)) {{ $brief->so_dktt_so}} @endif">
                        </fieldset>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                        <fieldset class="form-group">
                            <label for="datepicker">Ngày nộp lưu <span class="text-danger">*</span></label>
                            <div>
                                <div class="input-group">
                                    <input type="text" name="datetime" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                </div><!-- input-group -->
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-xs-12 col-sm-12 tab-header">
                        <h4 class="header-title m-t-0 m-b-10">THÔNG TIN NHÂN KHẨU</h4>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                        <fieldset class="form-group" >
                            <label>Quan hệ với chủ hộ<span class="text-danger">*</span></label>
                            <select name="idquanhechuho[]" class="form-control select2  {{ ($errors->has('idquanhechuho')) ? 'has-danger' : '' }}">
                                <option value="">Chọn quan hệ</option>
                                @foreach($list_quanhechuho as $quanhechuho)
                                    <option value="{{ $quanhechuho->id }}"  {{ old('idquanhechuho') == $quanhechuho->id ? 'selected' : '' }}>{{ $quanhechuho->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="hoten">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="hoten[]" parsley-trigger="change" placeholder="Họ và tên" class="form-control" id="hoten" value="@if(isset($nhankhau)){{$nhankhau->hoten}} @endif">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="tenkhac">Tên gọi khác <span class="text-danger">*</span></label>
                            <input type="text" name="tenkhac[]" parsley-trigger="change" placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac" value="@if(isset($nhankhau)){{$nhankhau->tenkhac}}@endif">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="datepicker">Ngày sinh <span class="text-danger">*</span></label>
                            <div>
                                <div class="input-group">
                                    <input type="text" name="birthday[]" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="@if(isset($nhankhau)){{date('d-m-Y', strtotime($nhankhau->ngaysinh))}}@endif">
                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                </div><!-- input-group -->
                            </div>
                        </fieldset>
                        

                        <fieldset class="form-group">
                          <label>Giới tính <span class="text-danger">*</span></label>
    
                          <div>
                            <input type="hidden" name="gender[]" value="@if(isset($nhankhau)){{$nhankhau->gioitinh}} @endif">
                            <div class="radio gender-radio">
                              <input type="radio" name="gender0" value="0" id="radio1" @if(isset($nhankhau) && $nhankhau->gioitinh == 0) checked @endif >
                              <label for="radio1">Nam</label>
                            </div>
                            <div class="radio gender-radio">
                              <input type="radio" name="gender0" value="1" id="radio2" @if(isset($nhankhau) && $nhankhau->gioitinh == 1) checked @endif>
                              <label for="radio2">Nữ</label>
                            </div>
                          </div>
                          
                        </fieldset>


                        

                        
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                        <fieldset class="form-group">
                            <label>Học vấn<span class="text-danger">*</span></label>
                            <select name="idtrinhdohocvan[]" class="form-control select2">
                                <option value="">Chọn Học vấn</option>
                                @foreach($educations as $education)
                                    <option @if(isset($nhankhau) && $education->id == $nhankhau->idtrinhdohocvan) selected @endif value="{{ $education->id }}">{{ $education->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Nghề nghiệp<span class="text-danger">*</span></label>
                            <select name="idnghenghiep[]" class="form-control select2">
                                <option value="">Chọn Nghề nghiệp</option>
                                @foreach($careers as $career)
                                    <option @if(isset($nhankhau) && $career->id == $nhankhau->idnghenghiep) selected @endif value="{{ $career->id }}">{{ $career->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Dân tộc<span class="text-danger">*</span></label>
                            <select name="iddantoc[]" class="form-control select2">
                                <option value="">Chọn Dân tộc</option>
                                @foreach($nations as $nation)
                                    <option @if(isset($nhankhau) && $nation->id == $nhankhau->iddantoc) selected @endif value="{{ $nation->id }}">{{ $nation->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="cmnd_so">Số CMND<span class="text-danger">*</span></label>
                            <input type="text" name="cmnd_so[]" parsley-trigger="change" placeholder="Nhập số CMND" class="form-control" id="cmnd_so" value="@if(isset($nhankhau)){{$nhankhau->cmnd_so}}@endif">
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="hochieu_so">Số Hộ Chiếu</label>
                            <input type="text" name="hochieu_so[]" parsley-trigger="change" placeholder="Nhập số hộ chiếu (Nếu có)" class="form-control"so value="@if(isset($nhankhau)){{$nhankhau->hochieu_so}}@endif" id="hochieu_so">
                        </fieldset>

                        

                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                        <fieldset class="form-group">
                            <label for="trinhdochuyenmon">Trình độ chuyên môn<span class="text-danger">*</span></label>
                            <input type="text" name="trinhdochuyenmon[]" parsley-trigger="change" placeholder="Trình độ chuyên môn" class="form-control" value="@if(isset($nhankhau)){{$nhankhau->trinhdochuyenmon}}@endif" id="trinhdochuyenmon">
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="trinhdongoaingu">Trình độ ngoại ngữ<span class="text-danger">*</span></label>
                            <input type="text" name="trinhdongoaingu[]" parsley-trigger="change" placeholder="Trình độ ngoại ngữ" class="form-control" value="@if(isset($nhankhau)){{$nhankhau->trinhdongoaingu}}@endif" id="trinhdongoaingu">
                        </fieldset>
                        <fieldset class="form-group">
                            <label>Tôn giáo<span class="text-danger">*</span></label>
                            <select name="idtongiao[]" class="form-control select2">
                                <option value="">Chọn Tôn giáo</option>
                                @foreach($religions as $religion)
                                    <option @if(isset($nhankhau) && $religion->id == $nhankhau->idtongiao) selected @endif value="{{ $religion->id }}">{{ $religion->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        <fieldset class="form-group">
                            <label>Quốc tịch<span class="text-danger">*</span></label>
                            <select name="idquoctich[]" class="form-control select2">
                                <option  value="">Chọn Quốc tịch</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if(isset($nhankhau) && $country->id == $nhankhau->idquoctich) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="biettiengdantoc">Biết tiếng dân tộc<span class="text-danger">*</span></label>
                            <input type="text" name="biettiengdantoc[]" parsley-trigger="change" placeholder="Biết tiếng dân tộc" class="form-control" value="@if(isset($nhankhau)){{$nhankhau->biettiengdantoc}}@endif" id="biettiengdantoc">
                        </fieldset>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">
                        
                        <fieldset class="form-group" id="addressPickerGroup">
                            <label for="thuongtru_view">Nơi thường trú<span class="text-danger">*</span></label>
                            <input type="text" name="thuongtru_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ thường trú" class="form-control" id="thuongtru_view">
                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                            <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_thuongtru[]" class="form-control" id="idquocgia_thuongtru" value="@if(isset($nhankhau)){{$nhankhau->idquocgia_thuongtru}}@endif">
                            <input type="hidden" data-addr="" hidden="hidden" name="idtinh_thuongtru[]" class="form-control" id="idtinh_thuongtru" value="@if(isset($nhankhau)){{$nhankhau->idtinh_thuongtru}}@endif">
                            <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_thuongtru[]" class="form-control" id="idhuyen_thuongtru" value="@if(isset($nhankhau)){{$nhankhau->idhuyen_thuongtru}}@endif">
                            <input type="hidden" data-addr="" hidden="hidden" name="idxa_thuongtru[]" class="form-control" id="idxa_thuongtru" value="@if(isset($nhankhau)){{$nhankhau->idxa_thuongtru}}@endif">
                            <input type="hidden" data-addr="" hidden="hidden" name="chitiet_thuongtru[]" class="form-control" id="chitiet_thuongtru" value="@if(isset($nhankhau)){{$nhankhau->chitiet_thuongtru}}@endif">
                        </fieldset>
                        
                        <fieldset class="form-group" id="addressPickerGroup">
                            <label for="noisinh_view">Nơi sinh <span class="text-danger">*</span></label>
                            <input type="text" name="noisinh_view" onload="test();" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi sinh" class="form-control" id="noisinh_view">
                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                            <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noisinh[]" class="form-control" value="@if(isset($nhankhau)){{$nhankhau->idquocgia_noisinh}}@endif" id="idquocgia_noisinh">
                            <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noisinh[]" class="form-control" value="@if(isset($nhankhau)){{$nhankhau->idtinh_noisinh}}@endif" id="idtinh_noisinh">
                            <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noisinh[]" class="form-control" value="@if(isset($nhankhau)){{$nhankhau->idhuyen_noisinh}}@endif" id="idhuyen_noisinh">
                            <input type="hidden" data-addr="" hidden="hidden" name="idxa_noisinh[]" class="form-control" value="@if(isset($nhankhau)){{$nhankhau->idxa_noisinh}}@endif" id="idxa_noisinh">
                            <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noisinh[]" class="form-control" value="@if(isset($nhankhau)){{$nhankhau->chitiet_noisinh}}@endif" id="chitiet_noisinh">
                        </fieldset>

                        <fieldset class="form-group" id="addressPickerGroup">
                            <label for="noisinh_view">Nguyên quán<span class="text-danger">*</span></label>
                            <input type="text" name="nguyenquan_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nguyên quán" class="form-control" id="nguyenquan_view">
                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                            <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_nguyenquan[]" class="form-control" id="idquocgia_nguyenquan">
                            <input type="hidden" data-addr="" hidden="hidden" name="idtinh_nguyenquan[]" class="form-control" id="idtinh_nguyenquan">
                            <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_nguyenquan[]" class="form-control" id="idhuyen_nguyenquan">
                            <input type="hidden" data-addr="" hidden="hidden" name="idxa_nguyenquan[]" class="form-control" id="idxa_nguyenquan">
                            <input type="hidden" data-addr="" hidden="hidden" name="chitiet_nguyenquan[]" class="form-control" id="chitiet_nguyenquan">
                        </fieldset>

                        <fieldset class="form-group" id="addressPickerGroup">
                            <label for="noiohiennay_view">Nơi ở hiện nay<span class="text-danger">*</span></label>
                            <input type="text" name="noiohiennay_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi ở hiện nay" class="form-control" id="noiohiennay_view">
                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                            <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noiohiennay[]" class="form-control" id="idquocgia_noiohiennay">
                            <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noiohiennay[]" class="form-control" id="idtinh_noiohiennay">
                            <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noiohiennay[]" class="form-control" id="idhuyen_noiohiennay">
                            <input type="hidden" data-addr="" hidden="hidden" name="idxa_noiohiennay[]" class="form-control" id="idxa_noiohiennay">
                            <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noiohiennay[]" class="form-control" id="chitiet_noiohiennay">
                        </fieldset>

                        <fieldset class="form-group" id="addressPickerGroup">
                            <label for="noilamviec_view">Nơi làm việc<span class="text-danger">*</span></label>
                            <input type="text" name="noilamviec_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi làm việc" class="form-control" id="noilamviec_view">
                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                            <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noilamviec[]" class="form-control" id="idquocgia_noilamviec">
                            <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noilamviec[]" class="form-control" id="idtinh_noilamviec">
                            <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noilamviec[]" class="form-control" id="idhuyen_noilamviec">
                            <input type="hidden" data-addr="" hidden="hidden" name="idxa_noilamviec[]" class="form-control" id="idxa_noilamviec">
                            <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noilamviec[]" class="form-control" id="chitiet_noilamviec">
                        </fieldset>
                        
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <fieldset class="form-group">
                            <label for="exampleTextarea">Tóm tắt bản thân (Từ đủ 14 tuổi trở lên đến nay ở đâu, làm gì:) <span class="text-danger">*</span></label>
                            <textarea class="form-control ckeditor" name="description[]" rows="3">@if(isset($nhankhau)){{$nhankhau->tomtatbanthan}}@endif
                                <table align="center" border="1" cellpadding="1" cellspacing="0" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle; width: 20%;">
                                            <p>Từ th&aacute;ng năm</p>

                                            <p>đến th&aacute;ng năm</p>
                                            </th>
                                            <th style="text-align: center; vertical-align: middle; width: 60%;">
                                            <p>Chổ ở</p>

                                            <p>(Ghi r&otilde; số nh&agrave;, đường phố, th&ocirc;n, x&oacute;m, l&agrave;ng, ấp bản)</p>
                                            </th>
                                            <td>Nghề nghiệp, nơi l&agrave;m việc</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>&nbsp;</p>
                            </textarea>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="exampleTextarea">Tóm tắt gia đình<span class="text-danger">*</span></label>
                            <textarea class="form-control ckeditor" name="descriptionFamily[]" rows="3">@if(isset($nhankhau)){{$nhankhau->tomtatgiadinh}}@endif
                                <table align="center" border="1" cellpadding="0" cellspacing="0" style="width:100%" summary="Tóm lược">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Họ t&ecirc;n</th>
                                            <th scope="col">Ng&agrave;y sinh</th>
                                            <th scope="col">Giới t&iacute;nh</th>
                                            <th scope="col">Quan hệ</th>
                                            <th scope="col">Nghề nghiệp</th>
                                            <th scope="col">Địa chỉ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <p>&nbsp;</p>

                            </textarea>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="exampleTextarea">Tiền án (Tội danh, hình phạt, theo bản án số)<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="criminalRecord[]" rows="3">@if(isset($nhankhau)){{$nhankhau->tienan_tiensu}}@endif</textarea>
                        </fieldset>
                    </div>

                    

                    

                </div>
            
            </div>
        </div>
    </div>
</div>