<div class="modal fade"  data-backdrop="static" id="address-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body p-20">
                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <label class="control-label">Quốc gia</label>
                            <select id="country" class="form-control select2 test">
                                <option  value="">Chọn Quốc gia</option>
                                @foreach($countries as $country)
                                <option {{ (config('user_config.default_hanhchinh.country') == $country->id) ? 'selected' : NULL }} value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                    
                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <label class="control-label">Tỉnh TP</label>
                            <select id="province" class="form-control select2">
                                <option value="">Chọn Tỉnh hoặc Thành Phố</option>
                                @foreach($provinces as $province)
                                <option {{ (config('user_config.default_hanhchinh.province') == $province->id) ? 'selected' : NULL }} value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
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
                                @foreach($districts as $district)
                                <option {{ (config('user_config.default_hanhchinh.district') == $district->id) ? 'selected' : NULL }} value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <label class="control-label">Xã</label>
                            <select id="ward" class="form-control select2">
                                <option value="">Chọn Xã</option>
                                @foreach($wards as $ward)
                                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                @endforeach
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