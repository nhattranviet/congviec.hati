<p>Tìm thấy tất cả <span style="font-weight: bold;" class="text-danger">{{ $list_canbo->total() }}</span> cán bộ</p>
<table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th class="center">ID</th>
            <th class="center">Họ tên</th>
            <th class="center">Đơn vị</th>
            <th class="center">Đội công tác</th>
            <th class="center">Chức vụ</th>
            <th class="center">Email</th>
            <th class="center">Nhóm quyền</th>
            <th class="center">Trạng thái</th>
            <th class="center" style="width: 220px;">Tác vụ</th>
        </tr>
    </thead>


    <tbody>
        @foreach($list_canbo as $canbo)
        <tr>
            <td class="center">{{ $canbo->id }}</td>
            <td>{{ $canbo->hoten }}</td>
            <td>{{ $canbo->tendonvi }}</td>
            <td>{{ $canbo->tendoi }}</td>
            <td>{{ $canbo->tenchucvu }}</td>
            <td>{{ $canbo->email }}</td>
            <td>{{ $canbo->tennhomquyen }}</td>
            <td class="center"> {!! ($canbo->active == 1) ? '<i style="color:darkgreen" class="zmdi zmdi-badge-check"></i>' : '<i style="color:crimson" class="zmdi zmdi-block-alt"></i>' !!}  </td>
            <td class="center">
                <div class="button-list" style="max-width: 200px; margin: auto;">
                    <a href="{{ route('can-bo.edit', $canbo->id) }}" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Sửa thông tin cán bộ"> <i style="color: #D85C0C;" class="zmdi zmdi-edit"></i> </a>
                    {{-- <a href="{{ route('don-vi-get-set-doi', $canbo->id) }}" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Thiết lập đội trong đơn vị"> <i style="color: #D85C0C;" class="zmdi zmdi-tv-list"></i> </a> --}}
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>{{ $list_canbo->links() }}</p>