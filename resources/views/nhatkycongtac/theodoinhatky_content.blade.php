<div class="card-box table-responsive">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <h5>Nhật ký công tác đội</h5>
        </div>
        <div class="col-xs-12 col-sm-12 loading" id="ajax_table" style="position: relative;">
            <table class="table table-bordered table-striped datatable">
                <thead>
                    <tr>
                        <th class="center" width="20px;"><input id="checkAll_nhatkydoi" current="nhatkydoi" class="checkAllCls" type="checkbox"></th>
                        <th class="center" width="20px;">STT</th>
                        <th class="center" width="90px;">Tuần</th>
                        <th class="center" width="450px;">Nội dung dự kiến</th>
                        <th class="center">Kết quả thực hiện</th>
                        <th class="center" width="70px;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                    @endphp
                    @foreach ($list_nhatkydoi as $nhatky)
                    <tr>
                        <td class="center"><input name="nhatkydoi[]" value="{{ $nhatky->id }}" class="nhatky_nhatkydoi" type="checkbox"></td>
                        <td class="center">{{ $i }}</td>
                        <td>{{ date('d-m-Y', strtotime($nhatky->ngaydautuan)) .' -> '. date('d-m-Y', strtotime($nhatky->ngaycuoituan)) }}</td>
                        <td>{!! $nhatky->noidungdukien !!}</td>
                        <td>{!! $nhatky->ketquathuchien !!}</td>
                        <td class="center"> {!! ($nhatky->nhatky_status == 2) ? '<i style="color:darkgreen" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Đã duyệt"></i>' : '<i style="color:crimson" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Chưa duyệt"></i>' !!} </td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div class="row m-t-20">
        <div class="col-xs-12 col-sm-12">
            <h5>Nhật ký công tác cán bộ</h5>
        </div>
        <div class="col-xs-12 col-sm-12">
            <div class="panel-group" id="accordion">
                @php
                $i=1;
                @endphp
                @foreach ($list_canbo_nhatky as $hoten => $canbo_nhatky)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $i }}"> <i class="fa fa-user"></i> {{ $hoten }}</a> </h5>
                    </div>
                    <div id="collapse_{{ $i }}" class="panel-collapse collapse">
                        <div class="panel-body">
                        <div class="row">
                                <div class="col-md-12">
                                    <table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="center" width="20px;"><input id="checkAll_{{ $i }}" current="{{ $i }}" class="checkAllCls" type="checkbox"></th>
                                                <th class="center" width="60px;">Ngày</th>
                                                <th class="center" width="450px;">Nội dung dự kiến</th>
                                                <th class="center">Kết quả thực hiện</th>
                                                <th class="center" style="width: 70px;">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($canbo_nhatky as $nhatky)
                                                @if ($nhatky->id != NULL)
                                                    <tr>
                                                        <td class="center"><input name="nhatkycanbo[]" value="{{ $nhatky->id }}" class="nhatky_{{ $i }}" type="checkbox"></td>
                                                        <td>{{ date('d-m-Y', strtotime($nhatky->ngay)) }}</td>
                                                        <td>{!! $nhatky->noidungdukien !!}</td>
                                                        <td>{!! $nhatky->ketquathuchien !!}</td>
                                                        <td class="center"> {!! ($nhatky->nhatky_status == 2) ? '<i style="color:darkgreen" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Đã duyệt"></i>' : '<i style="color:crimson" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Chưa duyệt"></i>' !!} </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                @php
                $i++;
                @endphp
                @endforeach
            </div>
        </div>
    </div>
</div>