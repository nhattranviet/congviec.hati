@include('commons.word_css')
<table class="head">
    <tr>
        <td valign="top" class="center">
            <span>CAH KỲ ANH</span><br>
            <span>CA...................</span><br><br>
            <span>Số:....../TTTĐ</span>
        </td>
        <td valign="top" class="center">
            <span class="daumuc">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
            <span class="italic">Độc lập - Tự do - Hạnh phúc</span>
        </td>
        <td class="center daumuc" style="width: 170px; font-size: 11pt;" valign="top" >
            Mẫu HK04 ban hành theo TT số 36/2014/TT-BCA ngày 09/9/2014
        </td>
    </tr>
</table>
<br>
<p class="center"><span class="daumuc-13">PHIẾU THÔNG TIN THAY ĐỔI VỀ HỘ KHẨU, NHÂN KHẨU</span></p>
<p class="center">Kính gửi:..........................................................</p>
<br>
<div>
    <span class="bold">1.</span></span> Họ và tên: <span class="uppercase bold" style="font-weight: bold;"> {{ $nhankhau->hoten }} </span> <br>
    <span class="bold">2.</span> Họ và tên gọi khác (nếu có): <span> {{ $nhankhau->tenkhac }} </span> <br>
    <span class="bold">3.</span> Ngày, tháng, năm sinh: <span> {{ ( $nhankhau->ngaysinh != NULL) ? date( 'd-m-Y', strtotime($nhankhau->ngaysinh) ) : '' }} </span> &nbsp; &nbsp; &nbsp; &nbsp; <span class="bold">4.</span> Giới tính: <span>{{ ( $nhankhau->gioitinh == 1) ? 'Nam' : 'Nữ' }}</span> <br>
    <span class="bold">5.</span> Nơi sinh: <span>  {{ $nhankhau->chitiet_noisinh }} - {{ ($nhankhau->idxa_noisinh) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noisinh)->value('name') : '' }} - {{ ($nhankhau->idhuyen_noisinh) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noisinh)->value('name') : '' }} - {{ ($nhankhau->idtinh_noisinh) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noisinh)->value('name') : '' }} </span> <br>
    <span class="bold">6.</span> Nguyên quán: <span>  {{ $nhankhau->chitiet_nguyenquan }} - {{ ($nhankhau->idxa_nguyenquan) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_nguyenquan)->value('name') : '' }} - {{ ($nhankhau->idhuyen_nguyenquan) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_nguyenquan)->value('name') : '' }} - {{ ($nhankhau->idtinh_nguyenquan) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_nguyenquan)->value('name') : '' }} </span> <br>
    <span class="bold">7.</span> Dân tộc: {{ DB::table('tbl_dantoc')->where('id', $nhankhau->iddantoc)->value('name') }} &nbsp; &nbsp; &nbsp; &nbsp;  <span class="bold">8.</span> Tôn giáo: {{ DB::table('tbl_tongiao')->where('id', $nhankhau->idtongiao)->value('name') }} &nbsp; &nbsp; &nbsp; &nbsp;  <span class="bold">9.</span> Quốc tịch: {{ DB::table('tbl_quocgia')->where('id', $nhankhau->idquoctich)->value('name') }} <br>
    <span class="bold">10.</span> CMND số: {{ $nhankhau->cmnd_so }} &nbsp; &nbsp; &nbsp; &nbsp;   <span class="bold">11.</span> Hộ chiếu số: {{ $nhankhau->hochieu_so }} <br>
    <span class="bold">12.</span> Hồ sơ hộ khẩu số: {{ $nhankhau->hosohokhau_so }} &nbsp; &nbsp; &nbsp; &nbsp;   <span class="bold">13.</span> Sổ hộ khẩu số: {{ $nhankhau->hokhau_so }} <br>
    <span class="bold">14.</span> Nơi thường trú: <span>  {{ $nhankhau->chitiet_thuongtru }} - {{ ($nhankhau->idxa_thuongtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_thuongtru)->value('name') : '' }} - {{ ($nhankhau->idhuyen_thuongtru) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_thuongtru)->value('name') : '' }} - {{ ($nhankhau->idtinh_thuongtru) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_thuongtru)->value('name') : '' }} </span> <br>
    <span class="bold">15.</span> Họ và tên chủ hộ: <span class="uppercase"> {{ $chuhoinfo->hoten }}</span> &nbsp; &nbsp; &nbsp; &nbsp;   <span class="bold">16.</span> Quan hệ với chủ hộ: {{ $tenquanhechuho }} <br>
    <span class="bold">17.</span> Nơi thường trú trước khi chuyển đến: <span>  {{ $nhankhau->chitiet_thuongtrutruoc }} - {{ ($nhankhau->idxa_thuongtrutruoc) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_thuongtrutruoc)->value('name') : '' }} - {{ ($nhankhau->idhuyen_thuongtrutruoc) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_thuongtrutruoc)->value('name') : '' }} - {{ ($nhankhau->idtinh_thuongtrutruoc) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_thuongtrutruoc)->value('name') : '' }} </span> <br>
    <span class="bold">18.</span> Họ và tên chủ hộ: <span>........................................</span>  &nbsp; <span class="bold">19.</span> Quan hệ với chủ hộ: <span>........................................</span> <br>
</div><br>
<p class="center"><span class="daumuc-12">NỘI DUNG THAY ĐỔI</span></p>
<p>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
</p>
<br>
<p class="center"><span class="daumuc-12">ĐỀ XUẤT, KIẾN NHỊ</span>(Nếu có)</p>
<p>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
    ..............................................................................................................................................................<br>
</p>
<table class="head" width="100%">
    <tr>
        <td class="center" style="width: 50%" valign="top"></td>
        <td> <span class="italic">.........., ngày.....tháng.....năm.....</span> </td>
    </tr>
    <tr>
        <td valign="top" style="width: 50%">
            CÁN BỘ LẬP PHIẾU <br>
            (Ký và ghi rõ họ tên)
        </td>
        <td valign="top" class="center">
            TRƯỞNG CÔNG AN.............. <br>
            (Ký, ghi rõ họ tên) <br>
        </td>
    </tr>
</table>