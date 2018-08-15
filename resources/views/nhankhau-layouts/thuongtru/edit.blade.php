@extends('layouts.masterPage')

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
              
              <form id="form-nhankhau" action="{{ route('nhankhau.update', $brief->id) }}" method="POST" role="form">
                <div class="row">
                  <div class="col-xs-12 col-sm-12">
                    <h4 class="header-title m-t-0 pull-left">Sửa thông tin hồ sơ</h4>
                  </div>
                  @include('/nhankhau-layouts.nhankhauForm', ['brief' => $brief, 'nhankhau' => $nhankhau])
                </div>
                <div class="row m-t-50">
                  <div class="col-xs-12 col-sm-12">
                    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
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
@include('layouts.address_modal')
@endsection

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $('#picker > #addressPickerGroup').each(function() {

      var inputs = $(this).find('input[type=hidden]').toArray();

      var binding = {
        country: 'Việt Nam', province: '', district: '', ward: '', addressDetail: $('#'+inputs[4].id).val()
      };

      var arrData = [];

      var el = $(this);


      // Get province or citie
      getProvinces($('#'+inputs[0].id).val(), null,function(data) {

        for (var i = 0; i < data.length; i++) {

          if (data[i].id == $('#'+inputs[1].id).val()) {

            binding.province = data[i].name;
            arrData[0] = binding;
            loadAddress(el, arrData[0]);

            break;

          }
        }
      });

      // Get district
      getDistricts($('#'+inputs[1].id).val(), null,function(data) {

        for (var i = 0; i < data.length; i++) {

          if (data[i].id == $('#'+inputs[2].id).val()) {

            binding.district = data[i].name;
            arrData[1] = binding;
            loadAddress(el, arrData[1]);
            break;
          }
        }
      });

      // Get ward
      getWards($('#'+inputs[2].id).val(), null,function(data) {

        for (var i = 0; i < data.length; i++) {

          if (data[i].id == $('#'+inputs[3].id).val()) {

            binding.ward = data[i].name;
            arrData[2] = binding;
            loadAddress(el, arrData[2]);
            break;
          }
        }
      });

    });
  });
</script>
@endsection