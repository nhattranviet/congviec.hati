@extends('layouts.masterPage')

@section('js')
   <script type="text/javascript">
      $(document).ready(function(){
         
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
               <div class="card-box table-responsive">
                   <div class="row">
                        <div class="col-xs-12 col-sm-12" id="ajax_table" style="position: relative;">
                            @include('congviec.chitiet_congviec_table')
                            <a href="{{ route('cong-viec.index') }}" class="btn btn-primary pull-right">Quay lại</a>
                        </div>
                        
                    </div>
               </div>
            </div>
         </div>
         
         <div class="row">
             <div class="col-md-12">
                 <div class="timeline">
                    <article class="timeline-item alt">
                        <div class="text-xs-right">
                            <div class="time-show first">
                                <a href="#" class="btn btn-custom w-lg">Lịch sử công việc</a>
                            </div>
                        </div>
                    </article>
                    @php
                        $i = 1;
                    @endphp

                    @foreach ($congviec_chuyentiep_info as $item)
                        <article class="timeline-item {{ ($i % 2 == 1) ? 'alt' : NULL }}">
                            <div class="timeline-desk">
                                <div class="panel">
                                    <div class="timeline-box">
                                        <span class="arrow"></span>
                                        <span class="timeline-icon bg-warning"><i class="zmdi zmdi-circle"></i></span>
                                        <h4 class="text-warning"> {{ $item->hoten }} </h4>
                                        <p class="timeline-date text-muted"><small> {{ date('H:i d-m-Y', strtotime( $item->timechuyentiep )) }} </small></p>
                                        <p class="text-danger"> {{ $item->ghichu }} </p>

                                    </div>
                                </div>
                            </div>
                        </article>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    

                </div>
             </div>
         </div>
      </div>
      <!-- container -->
   </div>
   <!-- content -->
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