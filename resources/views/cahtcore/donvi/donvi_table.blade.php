<p>Tìm thấy tất cả <span style="font-weight: bold;" class="text-danger">{{ $list_donvi->total() }}</span> đơn vị</p>
<table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
    <thead>
        <tr>
            <th class="center">ID</th>
            <th class="center">Tên đơn vị</th>
            <th class="center">Ký hiệu</th>
            <th class="center">Loại đơn vị</th>
            <th class="center" style="width: 220px;">Tác vụ</th>
        </tr>
    </thead>


    <tbody>
        @foreach($list_donvi as $donvi)
        <tr>
            <td class="center">{{ $donvi->id }}</td>
            <td>{{ $donvi->name }}</td>
            <td>{{ $donvi->kyhieu }}</td>
            <td class="center">
                @php
                    if ($donvi->loaidonvi == 'phongban')
                    {
                        echo '<span class="label label-primary">Phòng ban</span>';
                    }
                    elseif($donvi->loaidonvi == 'huyentptx')
                    {
                        echo '<span class="label label-warning">Huyện - TP -TX</span>';
                    }
                    else {
                        echo '<span class="label label-danger">Ban Giám đốc</span>';
                    }
                @endphp
            </td>
            <td class="center">
                
                <div class="button-list" style="max-width: 200px; margin: auto;">
                    <a href="{{ route('don-vi-get-set-doi', $donvi->id) }}" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Thiết lập đội trong đơn vị"> <i style="color: #D85C0C;" class="zmdi zmdi-tv-list"></i> </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<p>{{ $list_donvi->links() }}</p>