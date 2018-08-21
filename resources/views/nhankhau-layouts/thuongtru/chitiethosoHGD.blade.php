@extends('layouts.masterPage')

@section('css')
<link href="{{asset('/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('js')
    <script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection

@section('content')
<div class="content-page">
   <!-- Start content -->
   <div class="content">
      <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Xóa thường trú hộ gia đình</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
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

                  <div class="col-xs-12 col-sm-12">
                     <table style="margin-bottom: 20px;" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                           <th>STT</th>
                           <th>Hồ sơ số</th>
                           <th>Sổ hộ khẩu số</th>
                           <th>Họ tên</th>
                           <th>Quan hệ với chủ hộ</th>
                           <th>Thường trú</th>
                        </tr>
                     </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        @foreach($list_thongtinhokhau as $thongtinhokhau)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $thongtinhokhau->hosohokhau_so }}</td>
                                <td>{{ $thongtinhokhau->hokhau_so }}</td>
                                <td>{{ $thongtinhokhau->hoten }}</td>
                                <td>{{ ($thongtinhokhau->idquanhechuho) ? DB::table('tbl_moiquanhe')->where('id', $thongtinhokhau->idquanhechuho)->value('name') : '' }}</td>
                                <td> {{ $thongtinhokhau->chitiet_thuongtru }} - {{ ($thongtinhokhau->idxa_thuongtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $thongtinhokhau->idxa_thuongtru)->value('name') : '' }} - {{ ($thongtinhokhau->idhuyen_thuongtru) ? DB::table('tbl_huyen_tx')->where('id', $thongtinhokhau->idhuyen_thuongtru)->value('name') : '' }} - {{ ($thongtinhokhau->idtinh_thuongtru) ? DB::table('tbl_tinh_tp')->where('id', $thongtinhokhau->idtinh_thuongtru)->value('name') : '' }}</td>
                            </tr>
                           <?php $i++; ?>
                        @endforeach
                      </tbody>
                  </table>
                  </div>

                  <form id="form-nhankhau" action="{{ route('xoa-thuong-tru-HDG', $idhoso) }}" method="POST" role="form">
                    @csrf
                    <input type="hidden" name="idhoso" value="{{ $idhoso }}">
                    <div style="padding: 0.7rem;" class="row">
                        <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                            <div class="row hokhau-code">
                                <div class="col-xs-12 col-sm-12 tab-header">
                                    <h4 class="header-title m-t-0 m-b-10">THÔNG TIN HỒ SƠ</h4>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                    <fieldset class="form-group">
                                        <label>Trường hợp xóa <span class="text-danger">*</span></label>
                                        <div>
                                            @foreach($list_truonghopxoa as $truonghopxoa)
                                                <div class="radio gender-radio">
                                                    <input type="radio" name="idtruonghopxoa" value="{{ $truonghopxoa->id }}" id="radio" >
                                                    <label for="radio1">{{ $truonghopxoa->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="datepicker">Ngày xóa <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="input-group">
                                                <input value="{{ old('ngayxoathuongtru') }}" type="text" name="ngayxoathuongtru" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-10">
                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="thuongtrumoi_view">Nơi chuyển đến<span class="text-danger">*</span></label>
                                        <input type="text" name="thuongtrumoi_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ thường trú" class="form-control" id="thuongtrumoi_view">
                                        <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_thuongtrumoi" class="form-control" id="idquocgia_thuongtrumoi" value="">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_thuongtrumoi" class="form-control" id="idtinh_thuongtrumoi" value="">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_thuongtrumoi" class="form-control" id="idhuyen_thuongtrumoi" value="">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_thuongtrumoi" class="form-control" id="idxa_thuongtrumoi" value="">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_thuongtrumoi" class="form-control" id="chitiet_thuongtrumoi" value="">
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-xs-12 col-sm-12">
                            <button onclick="return confirm('Bạn có muốn xóa không?');" class="pull-left btn btn-danger"><i class="fa fa-trash"></i> Xóa thường trú</button>
                            <a class="pull-right btn btn-primary" href="{{ URL::to('nhan-khau') }}/sua-nhan-khau">Quay lại</a>
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