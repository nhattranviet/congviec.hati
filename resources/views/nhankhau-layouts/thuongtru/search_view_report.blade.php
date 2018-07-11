<p>Tìm thấy <span style="font-weight: bold;" class="text-danger"> {{ $total }} </span> kết quả</p>
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
         <td><a class="btn btn-danger" target="_blank" href="/nhan-khau/{{$brief->id}}/chi-tiet-nhan-khau">Chi tiết</a></td>
      </tr>
      @endforeach
   </tbody>
</table>
<p>{{ $briefs->links() }}</p>