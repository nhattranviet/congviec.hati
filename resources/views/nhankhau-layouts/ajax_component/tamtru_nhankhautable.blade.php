<p>Tìm thấy tất cả <span style="font-weight: bold;" class="text-danger">{{ $briefs->total() }}</span> hồ sơ</p>
<table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th>Sổ tạm trú số</th>
            <th>Người đại diện</th>
            <th>Loại sổ</th>
            <th>Nơi tạm trú</th>
            <th style="width: 220px;">Tác vụ</th>
        </tr>
    </thead>


    <tbody>
        @foreach($briefs as $brief)
        <tr>
            <td>{{ $brief->sotamtru_so }}</td>
            <td>{{ $brief->hoten }}</td>
            <td> {!! ($brief->type == 'hogiadinh') ? '<span class="label label-primary">Hộ gia đình</span>' : '<span class="label label-warning">Cá nhân</span>' !!} </td>
            <td> {{ $brief->chitiet_tamtru }} {{ ($brief->idxa_tamtru) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $brief->idxa_tamtru)->value('name') : '' }} {{ ($brief->idhuyen_tamtru) ? '-'.DB::table('tbl_huyen_tx')->where('id', $brief->idhuyen_tamtru)->value('name') : '' }} {{ ($brief->idtinh_tamtru) ? '-'.DB::table('tbl_tinh_tp')->where('id', $brief->idtinh_tamtru)->value('name') : '' }}</td>
            <td>
                <div class="button-list" style="max-width: 200px; margin: auto;">
                    <a href=" {{ route('chi-tiet-so-tam-tru', $brief->idsotamtru) }} " class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Chi tiết hồ sơ"> <i style="color: #387576;" class="zmdi zmdi-eye"></i> </a>
                    <a href="#" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Sửa hồ sơ"> <i style="color: #D85C0C;" class="zmdi zmdi-edit"></i> </a>
                    @if ($brief->thoigianxoaso == NULL)
                        <a href="{{ route('get-xoa-tam-tru-So', $brief->idsotamtru) }}" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Xóa tạm trú sổ"> <i style="color: red;" class="zmdi zmdi-delete"></i> </a>
                    @endif
                    
                    @if ($brief->type == 'hogiadinh')
                        <a href="/tam-tru/{{ $brief->idsotamtru }}/get-add-nhan-khau" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Thêm nhân khẩu tạm trú"> <i style="color: #0BABE7;" class="zmdi zmdi-account-add"></i> </a>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>{{ $briefs->links() }}</p>