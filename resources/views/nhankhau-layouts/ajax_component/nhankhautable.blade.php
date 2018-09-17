<p>Tìm thấy tất cả <span style="font-weight: bold;" class="text-danger">{{ $briefs->total() }}</span> hồ sơ</p>
<table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th>Hồ sơ hộ khẩu số</th>
            <th>Hộ khẩu số</th>
            <th>Họ tên chủ hộ</th>
            <th>Nơi thường trú</th>
            <th style="width: 200px;">Tác vụ</th>
        </tr>
    </thead>


    <tbody>
        @foreach($briefs as $brief)
        <tr>
            <td>{{ $brief->hosohokhau_so }}</td>
            <td>{{ $brief->hokhau_so }}</td>
            <td>{{ $brief->hoten }}</td>
            <td> {{ $brief->chitiet_thuongtru }} {{ ($brief->idxa_thuongtru) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $brief->idxa_thuongtru)->value('name') : '' }} {{ ($brief->idhuyen_thuongtru) ? '-'.DB::table('tbl_huyen_tx')->where('id', $brief->idhuyen_thuongtru)->value('name') : '' }} {{ ($brief->idtinh_thuongtru) ? '-'.DB::table('tbl_tinh_tp')->where('id', $brief->idtinh_thuongtru)->value('name') : '' }}</td>
            <td class="center">
                <div class="btn-group" style="max-width: 200px; margin: auto;">
                    <button type="button" class="btn btn-warning dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Lựa chọn <span class="caret"></span></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('chi-tiet-ho-khau', $brief->idhoso) }}"><i style="color: #387576;" class="zmdi zmdi-eye"></i> Xem hồ sơ</a>
                        <a class="dropdown-item" href="{{ route('get-dang-ky-thuong-tru', $brief->idhoso) }}"><i style="color: #0BABE7;" class="zmdi zmdi-account-add"></i> Đăng ký thường trú</a>
                        <a class="dropdown-item" href="{{ route('nhan-khau.edit', $brief->idhoso) }}"><i style="color: #D85C0C;" class="zmdi zmdi-edit"></i> Sửa hồ sơ</a>
                        <a class="dropdown-item" href="{{ route('get-tach-ho-khau', $brief->idhoso) }}"><i style="color: #6C6A4B;" class="zmdi zmdi-collection-item-2"></i> Tách hộ</a>
                        <a class="dropdown-item" href="{{ route('get-check-cap-lai-SHK', $brief->idhoso) }}"> <i style="color: green;" class="zmdi zmdi-swap"></i> Cấp lại SHK</a>
                        <a class="dropdown-item" href="{{ route('get-check-cap-doi-SHK', $brief->idhoso) }}"> <i style="color: blue;" class="zmdi zmdi-swap-vertical"></i> Cấp đổi SHK</a>
                        <a class="dropdown-item" href="{{ route('get-xoa-thuong-tru-HDG', $brief->idhoso) }}"><i style="color: red;" class="zmdi zmdi-delete"></i> Xóa thường trú Hộ</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>{{ $briefs->links() }}</p>
