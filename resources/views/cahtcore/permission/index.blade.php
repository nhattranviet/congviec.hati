@extends('layouts.masterPage')

@section('js')
<script type="text/javascript">
    var global_id;
    $(document).ready(function(){
        $("#checkAllDonvi").click(function () {
            $('.donvi').prop('checked', this.checked);
        });

        $(document).on('click', '.chucnang_checkbox', function(e){
            // console.log(e);
            if(e.target.checked){
                var global_id = this.id;
                $('#address-modal').modal();
            }
            else
            {

            }
            
        });

        $('#modalsaveChange').on('click', function(e){
            idlevel_select = $('#idlevel').val();
            alert(global_id);
            // $('#chucnang_level_'+global_id).val(idlevel_select);
            // alert(idlevel_select);
        });
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
        <div class="row">
            <div class="col-xs-12">
            <div class="alert alert-danger" id="error-msg" style="display: none">
            </div>
            <div class="alert alert-success" id="success-msg" style="display: none">
            </div>
            </div>
        </div>

        <div class="row m-t-10">
            <div class="col-xs-12">
                <div class="card-box table-responsive">
                    <form id="tim-kiem-hoso" action="{{ URL::to('nhan-khau') }}" method="GET" role="form" idresult="nhankhautable">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkAllDonvi" type="checkbox" >
                                    <label for="checkbox">
                                        <b>Chọn tất cả</b>
                                    </label>
                                </div>
                            </div>
                            @foreach($list_donvi as $donvi)
                                <div class="col-xs-12 col-sm-2">
                                    <div class="checkbox checkbox-primary">
                                        <input class="donvi" name="iddonvi[]" type="checkbox" value="{{ $donvi->id }}" >
                                        <label for="checkbox">
                                            {{ $donvi->kyhieu }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                                
                        </div>

                        {{-- <div class="row">
                            <input type="checkbox" class="check btn btn-primary" value="check all" />
                        </div> --}}

                        <div class="row">
                            <div class="col-xs-12 col-sm-3">

                                <fieldset class="form-group" >
                                    <label>Chọn nhóm quyền<span class="text-danger">*</span></label>
                                    <select name="idnhomquyen" class="form-control select2">
                                        <option value="">Chọn nhóm quyền</option>
                                        @foreach($list_nhomquyen as $nhomquyen)
                                        <option value="{{ $nhomquyen->id }}">{{ $nhomquyen->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>

                            <div class="col-xs-12 col-sm-3">

                                <fieldset class="form-group" >
                                    <label>Chọn modules phân quyền<span class="text-danger">*</span></label>
                                    <select id="module" name="idmodule" class="form-control select2">
                                        <option value="">Chọn Module</option>
                                        @foreach($list_module as $module)
                                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row" id="chucnanglist">

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
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Mức quyền</h4>
            </div>
            <div class="modal-body p-20">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="form-group">
                            <select name="idlevel" id="idlevel" class="form-control select2">
                                @foreach ($list_level as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="modalsaveChange" class="btn btn-primary" data-dismiss="modal">Chọn</button>
            </div>
        </div>
    </div>
</div>
@endsection


