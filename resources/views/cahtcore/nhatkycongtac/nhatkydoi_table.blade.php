<p>Tìm thấy tất cả <span style="font-weight: bold;" class="text-danger">{{ $list_nhatkydoi->total() }}</span> kết quả</p>
<table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th class="center"><input id="checkAll" type="checkbox"></th>
            <th class="center" style="width: 120px;">Tuần</th>
            <th class="center" style="width: 400px;">Nội dung dự kiến</th>
            <th class="center">Kết quả thực hiện</th>
            <th class="center">Ghi chú của Lãnh đạo</th>
            <th class="center" style="width: 100px;">Trạng thái</th>
            <th class="center" style="width: 100px;">Tác vụ</th>
        </tr>
    </thead>


    <tbody>
        @foreach($list_nhatkydoi as $nhatky)
        <tr tr_id="{{$nhatky->id}}">
            <th class="center"><input class="nhatky" type="checkbox"></th>
            <td class="ngay">{!! date('d-m-Y', strtotime($nhatky->ngaydautuan)) .' -><br>'. date('d-m-Y', strtotime($nhatky->ngaycuoituan)) !!}</td>
            <td class="noidung">{!! $nhatky->noidungdukien !!}</td>
            <td class="ketqua">{!! $nhatky->ketquathuchien !!}</td>
            <td>{!! $nhatky->ghichuduyet !!}</td>
            <td class="center"> {!! ($nhatky->nhatky_status == 2) ? '<i style="color:darkgreen" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Đã duyệt"></i>' : '<i style="color:crimson" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Chưa duyệt"></i>' !!}  </td>
            <td>
                <div class="button-list" style="max-width: 50px; margin: auto;">
                    <a class="btn btn-link editNhatkyCB" modal_use="nhatkydoi-modal" nhatky_id="{{$nhatky->id}}" ajax_url="{{ route('ajax-get-nhat-ky-cb-info', $nhatky->id) }}" data-toggle="tooltip" data-placement="top" title="Sửa nhật ký"> <i style="color: #D85C0C;" class="zmdi zmdi-edit"></i> </a>
                    <a class="btn btn-link deleteNhatkyCB" nhatky_id="{{$nhatky->id}}" ajax_url="{{ route('ajaxDeleteNhatkyDoi', $nhatky->id) }}"  data-toggle="tooltip" data-placement="top" title="Xóa nhật ký"> <i style="color: red;" class="zmdi zmdi-delete"></i> </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>{{ $list_nhatkydoi->links() }}</p>
