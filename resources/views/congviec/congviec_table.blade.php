<p>Tìm thấy tất cả <span style="font-weight: bold;" class="text-danger">{{ $list_congviec->total() }}</span> công việc</p>
<table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th style="width: 200px;">Số/ký hiệu</th>
            <th>Trích yếu</th>
            <th>Hạn xử lý</th>
            <th>Hạn công việc</th>
            <th>Người đang xử lý</th>
            <th>Trạng thái</th>
            <th style="width: 200px;">Tác vụ</th>
        </tr>
    </thead>


    <tbody>
        @foreach($list_congviec as $congviec)
            @php
                $text_color = '';
                $delta_time = ceil( ( strtotime($congviec->hancongviec) - time() ) / 86400);
                if ($congviec->idstatus == 1)
                {
                    if( $delta_time == 1 )
                    {
                        $text_color = 'text-warning';
                    }
                    elseif($delta_time < 1)
                    {
                        $text_color = 'text-danger';
                    }
                    
                }
            @endphp
        <tr class="{{ $text_color }}">
            <td>{{ $congviec->idcongviec }}</td>
            <td>{{ $congviec->sotailieu }}</td>
            <td>{{ $congviec->trichyeu }}</td>
            <td>{{ ($congviec->hanxuly) ? date('d-m-Y', strtotime($congviec->hanxuly)) : NULL }}</td>
            <td>{{ ($congviec->hancongviec) ? date('d-m-Y', strtotime($congviec->hancongviec)) : NULL }}</td>
            @php
                $nguoidangxuly = DB::table( 'tbl_canbo' )
                ->join('tbl_congviec_chuyentiep', 'tbl_canbo.id', '=', 'tbl_congviec_chuyentiep.idcanbonhan')
                ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
                ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
                ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
                ->select( 'hoten', 'tbl_doicongtac.name' )
                ->orderBy('timechuyentiep', 'DESC')
                ->where('idcongviec', $congviec->idcongviec)
                ->first();
            @endphp
            <td>{!! '<span  data-toggle="tooltip" data-placement="top" title="'.$nguoidangxuly->name.'">Đ/c '.$nguoidangxuly->hoten.'</span>' !!} </td>
            <td>{!! ($congviec->idstatus == 2) ? '<span class="label label-success">Hoàn thành</span>' : '<span class="label label-warning">Đang xử lý</span>' !!}</td>
            <td style="text-align:center;">
                
                <div class="button-list" style="max-width: 200px; margin: auto;">
                    <a href="{{ route('get-show-cong-viec', $congviec->idcongviec) }}" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Xem chi tiết công việc"> <i style="color: #387576;" class="zmdi zmdi-eye"></i> </a>
                    <a href="{{ route('get-edit-cong-viec', $congviec->idcongviec) }}" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Sửa công việc"> <i style="color: #D85C0C;" class="zmdi zmdi-edit"></i> </a>
                    <a href="{{ route('get-delete-cong-viec', $congviec->idcongviec) }}" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Xóa công việc"> <i style="color: red;" class="zmdi zmdi-delete"></i> </a>
                    <a href="#" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Đánh dấu hoàn thành công việc"> <i style="color:forestgreen;" class="fa fa-check-square-o"></i> </a>
                    <a href="#" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Đánh dấu đang xử lý công việc"> <i style="color:orange;" class="fa fa-check-square-o"></i> </a>
                    <a href="{{ route('get-chuyentiep-cong-viec', $congviec->idcongviec) }}" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Chuyển tiếp công việc"> <i style="color:cornflowerblue;" class="zmdi zmdi-caret-right-circle"></i> </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>{{ $list_congviec->links() }}</p>