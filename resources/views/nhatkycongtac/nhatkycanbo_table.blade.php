<p>Tìm thấy tất cả <span style="font-weight: bold;" class="text-danger">{{ $briefs->total() }}</span> hồ sơ</p>
<table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th>Ngày</th>
            <th>Nội dung dự kiến</th>
            <th>Kết quả thực hiện</th>
            <th>Trạng thái</th>
            <th style="width: 220px;">Tác vụ</th>
        </tr>
    </thead>


    <tbody>
        @foreach($briefs as $brief)
        <tr>
            <td>{{ $brief->hosohokhau_so }}</td>
            <td>{{ $brief->hokhau_so }}</td>
            <td>{{ $brief->hoten }}</td>
            <td> {{ $brief->chitiet_thuongtru }} {{ ($brief->idxa_thuongtru) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $brief->idxa_thuongtru)->value('name') : '' }} {{ ($brief->idhuyen_thuongtru) ? '-'.DB::table('tbl_huyen_tx')->where('id', $brief->idhuyen_thuongtru)->value('name') : '' }} {{ ($brief->idtinh_thuongtru) ? '-'.DB::table('tbl_tinh_tp')->where('id', $brief->idtinh_thuongtru)->value('name') : '' }}</td>
            <td>
                <div class="button-list" style="max-width: 200px; margin: auto;">
                    <a href="/nhan-khau/{{$brief->idhoso}}/chi-tiet-ho-khau" alt="Text" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Chi tiết hồ sơ"> <i style="color: #387576;" class="zmdi zmdi-eye"></i> </a>
                    <a href="/nhan-khau/{{$brief->idhoso}}/edit" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Sửa hồ sơ"> <i style="color: #D85C0C;" class="zmdi zmdi-edit"></i> </a>
                    <a href="/nhan-khau/{{$brief->idhoso}}/dang-ky-thuong-tru" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Đăng ký thường trú nhân khẩu mới"> <i style="color: #0BABE7;" class="zmdi zmdi-account-add"></i> </a>
                    <a href="/nhan-khau/{{$brief->idhoso}}/tach-ho-khau" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Tách hộ khẩu"> <i style="color: #6C6A4B;" class="zmdi zmdi-collection-item-2"></i> </a>
                    <a href="/nhan-khau/{{$brief->idhoso}}/check-cap-lai-SHK" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Cấp lại hộ khẩu"> <i style="color: green;" class="zmdi zmdi-swap"></i> </a>
                    <a href="/nhan-khau/{{$brief->idhoso}}/check-cap-doi-SHK" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Cấp đổi hộ khẩu"> <i style="color: blue;" class="zmdi zmdi-swap-vertical"></i> </a>
                    <a href="/nhan-khau/{{$brief->idhoso}}/check-xoa-thuong-tru-HDG" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Xóa thường trú hộ gia đình"> <i style="color: red;" class="zmdi zmdi-delete"></i> </a>


                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>{{ $briefs->links() }}</p>
