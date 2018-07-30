@extends('layouts.masterPage')

@section('js')
<script type="text/javascript">
    
    $(document).ready(function(){
        var global_id;
        $("#checkAllDonvi").click(function () {
            $('.donvi').prop('checked', this.checked);
        });

        $(document).on('click', '.chucnang_checkbox', function(e){
            global_id = this.id;
            if(e.target.checked){
                
                $('#address-modal').modal();
            }
            else
            {
                $('#chucnang_level_'+global_id).val('');
                $('#chucnang_'+global_id).val('');
            }
            
        });

        $('#modalsaveChange').on('click', function(e){
            var current_chucnang_val = $('#'+global_id).val();
            var idlevel_select = $('#idlevel').val();
            $('#chucnang_'+global_id).val(current_chucnang_val);
            $('#chucnang_level_'+global_id).val(idlevel_select);
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
                    <form id="form-nhankhaus" action="{{ route('post-set-private-role', $iduser) }}" method="POST" role="form">
                        @csrf
                        <input type="hidden" id="iduser" name="iduser" value="{{ $iduser }}">

                        <div class="row">

                            <div class="col-xs-12 col-sm-6">
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

                        <div class="row m-t-20">
                            <div class="col-xs-12 col-sm-3">
                                <button type="submit" class="btn btn-danger"> <i class="fa fa-save"></i> Thực hiện</button>
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

<div class="modal fade" id="address-modal" data-backdrop="static">
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
                            <select id="idlevel" class="form-control select2">
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


