<p>Tìm thấy tất cả <span style="font-weight: bold;" class="text-danger">{{ $list_congviec->total() }}</span> kết quả</p>
<table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 150px;" class="center">Thời gian</th>
            <th style="width: 50%;" class="center">Công việc</th>
            <th class="center">Địa điểm</th>
            <th style="width: 15%;" class="center">Lãnh đạo dự</th>
            <th class="center" style="width: 100px;">Tác vụ</th>
        </tr>
    </thead>


    <tbody>
        @foreach($list_congviec as $congviec)
        <tr tr_id="{{ $congviec->id }}">
            <td class="ngay">{{ date('H:s d-m-Y', strtotime($congviec->ngay)) }}</td>
            <td class="noidung">{!! $congviec->noidungcongviec !!}</td>
            <td class="ketqua">{!! $congviec->diadiem !!}</td>
            <td>{{  $congviec_lanhdao[$congviec->id] }}</td>
            <td>
                <div class="button-list" style="max-width: 50px; margin: auto;">
                    <a href="{{ route('lich-cong-tac.edit', $congviec->id) }}" class="btn btn-link"  modal_use="congvieccanbo-modal"  data-toggle="tooltip" data-placement="top" title="Sửa công việc"> <i style="color: #D85C0C;" class="zmdi zmdi-edit"></i> </a>
                    <a href="{{ route('lich-cong-tac.delete', $congviec->id) }}" onclick="confirm('Bạn có muốn xóa công việc này không?')" class="btn btn-link"  data-toggle="tooltip" data-placement="top" title="Xóa công việc"> <i style="color: red;" class="zmdi zmdi-delete"></i> </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>{{ $list_congviec->links() }}</p>
