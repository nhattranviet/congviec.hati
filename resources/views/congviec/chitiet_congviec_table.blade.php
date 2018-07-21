<div class="row">
    <div class="col-md-6">
        <table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center;">Tên</th>
                    <th style="text-align: center; width: 70%;">Giá trị</th>
                </tr>
            </thead>


            <tbody>
                <tr>
                    <td>Số tài liệu</td>
                    <td>{{ $congviec_info->sotailieu }}</td>
                </tr>
                <tr>
                    <td>Trích yếu</td>
                    <td>{{ $congviec_info->trichyeu }}</td>
                </tr>
                <tr>
                    <td>Nơi soạn thảo</td>
                    <td>{{ $congviec_info->noisoanthao }}</td>
                </tr>
                <tr>
                    <td>Hạn công việc</td>
                    <td>{{ ($congviec_info->hancongviec) ? date('d-m-Y', strtotime($congviec_info->hancongviec)) : NULL }}</td>
                </tr>
                <tr>
                    <td>Hạn xử lý</td>
                    <td>{{ ($congviec_info->hanxuly) ? date('d-m-Y', strtotime($congviec_info->hanxuly)) : NULL }}</td>
                </tr>
                
                
            </tbody>
        </table>
    </div>

    <div class="col-md-6">
        <table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center;">Tên</th>
                    <th style="text-align: center; width: 70%;">Giá trị</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hạn lãnh đạo giao</td>
                    <td>{{ ($congviec_info->thoigiangiao) ? date('d-m-Y', strtotime($congviec_info->thoigiangiao)) : NULL }}</td>
                </tr>
                <tr>
                    <td>Thời gian hoàn thành</td>
                    <td>{{ ($congviec_info->thoigianhoanthanh) ? date('d-m-Y', strtotime($congviec_info->thoigianhoanthanh)) : NULL }}</td>
                </tr>
                <tr>
                    <td>Trạng thái</td>
                    <td>{!! ($congviec_info->idstatus == 2) ? '<span class="label label-success">Hoàn thành</span>' : '<span class="label label-warning">Đang xử lý</span>' !!}</td>
                </tr>
                <tr>
                    <td>Ghi chú</td>
                    <td>{{ $congviec_info->ghichu }}</td>
                </tr>
                <tr>
                    <td>Ngày tạo</td>
                    <td>{{ ($congviec_info->created_at) ? date('H:i:s d-m-Y', strtotime($congviec_info->created_at)) : NULL }}</td>
                </tr>
                
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <p style="font-weight: bold;">Chi tiết</p>
        <p>{!! $congviec_info->chitiet !!}</p>
    </div>
</div>
