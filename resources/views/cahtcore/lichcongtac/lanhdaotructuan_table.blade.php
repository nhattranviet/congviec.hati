<p>Tìm thấy tất cả <span style="font-weight: bold;" class="text-danger">{{ $list_lanhdaotructuan->total() }}</span> kết quả</p>
<table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 200px;" class="center">Thời gian</th>
            <th class="center">Lãnh đạo trực</th>
            <th class="center" style="width: 100px;">Tác vụ</th>
        </tr>
    </thead>

    <tbody>
        @foreach($list_lanhdaotructuan as $lanhdaotructuan)
        <tr>
            <td>{{ date('d-m-Y', strtotime($lanhdaotructuan->ngaydautuan)).' -> '.date('d-m-Y', strtotime($lanhdaotructuan->ngaycuoituan)) }}</td>
            <td>{{ 'Đ/c '.$lanhdaotructuan->hoten.' - '.$lanhdaotructuan->tenchucvu }}</td>
            <td>
                <div class="button-list" style="max-width: 50px; margin: auto;">
                    <a href="{{ route('lich-cong-tac.edit_lanhdaotructuan', $lanhdaotructuan->id) }}" class="btn btn-link"  modal_use="congvieccanbo-modal"  data-toggle="tooltip" data-placement="top" title="Sửa"> <i style="color: #D85C0C;" class="zmdi zmdi-edit"></i> </a>
                    <a href="{{ route('lich-cong-tac.delete_lanhdaotructuan', $lanhdaotructuan->id) }}" onclick="confirm('Bạn có muốn xóa không?')" class="btn btn-link"  data-toggle="tooltip" data-placement="top" title="Xóa"> <i style="color: red;" class="zmdi zmdi-delete"></i> </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>{{ $list_lanhdaotructuan->links() }}</p>
