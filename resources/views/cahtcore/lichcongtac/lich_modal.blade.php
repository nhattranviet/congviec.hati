<form id="" action="{{ route('ajaxUpdateNhatkyCB') }}" method="POST" role="form" autocomplete="off">
    @csrf
    <div class="modal fade" id="nhatkycanbo-modal" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Nhật ký cán bộ</h4>
                </div>
                <div class="modal-body p-20">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label for="datepicker">Ngày dự kiến<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input disabled="disabled" type="text" id="ngay" name="ngay" class="form-control datepicker-autoclose" placeholder="dd-mm-yyyy" value="">
                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                    </div><!-- input-group -->
                            </fieldset>
                        </div>
                        
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label for="exampleTextarea">Nội dung dự kiến</label>
                                <textarea id="noidungdukien" class="form-control ckeditor" name="noidungdukien"></textarea>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label for="exampleTextarea">Kết quả thực hiện</label>
                                <textarea id="ketquathuchien" class="form-control ckeditor" name="ketquathuchien"></textarea>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="idnhatky" id="idnhatky_hidden" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" id="submitBtnUpdateCB" class="btn btn-primary">Lưu lại</button>
                    {{-- <button type="button" id="saveChange" class="btn btn-primary" data-dismiss="modal">Lưu lại</button> --}}
                </div>
            </div>
        </div>
    </div>
</form>