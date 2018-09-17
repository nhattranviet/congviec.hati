@include('commons.word_css')
<table class="head">
    <tr>
        <td class="center">
            <span class="daumuc">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
            <span class="italic">Độc lập - Tự do - Hạnh phúc</span>
        </td>
        <td class="center daumuc" style="width: 170px; font-size: 11pt;" valign="top" >
            Mẫu HK01 ban hành theo TT số 36/2014/TT-BCA ngày 09/9/2014
        </td>
    </tr>
</table>
<br>

<p class="center"><span class="daumuc">BẢN KHAI NHÂN KHẨU</span><br>
(Dùng cho người từ 14 tuổi trở lên)</p>
<br>
<p>
    <span class="bold">1.</span></span> Họ và tên: <span class="uppercase bold" style="font-weight: bold;"> {{ $nhankhau->hoten }} </span> <br>
    <span class="bold">2.</span> Họ và tên gọi khác (nếu có): <span> {{ $nhankhau->tenkhac }} </span> <br>
    <span class="bold">3.</span> Ngày, tháng, năm sinh: <span> {{ ( $nhankhau->ngaysinh != NULL) ? date( 'd-m-Y', strtotime($nhankhau->ngaysinh) ) : '' }} </span> &nbsp; &nbsp; &nbsp; &nbsp; <span class="bold">4.</span> Giới tính: <span>{{ ( $nhankhau->gioitinh == 1) ? 'Nam' : 'Nữ' }}</span> <br>
    <span class="bold">5.</span> Nơi sinh: <span>  {{ $nhankhau->chitiet_noisinh }} - {{ ($nhankhau->idxa_noisinh) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noisinh)->value('name') : '' }} - {{ ($nhankhau->idhuyen_noisinh) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noisinh)->value('name') : '' }} - {{ ($nhankhau->idtinh_noisinh) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noisinh)->value('name') : '' }} </span> <br>
    <span class="bold">6.</span> Nguyên quán: <span>  {{ $nhankhau->chitiet_nguyenquan }} - {{ ($nhankhau->idxa_nguyenquan) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_nguyenquan)->value('name') : '' }} - {{ ($nhankhau->idhuyen_nguyenquan) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_nguyenquan)->value('name') : '' }} - {{ ($nhankhau->idtinh_nguyenquan) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_nguyenquan)->value('name') : '' }} </span> <br>
    <span class="bold">7.</span> Dân tộc: {{ DB::table('tbl_dantoc')->where('id', $nhankhau->iddantoc)->value('name') }} &nbsp; &nbsp; &nbsp; &nbsp;  <span class="bold">8.</span> Tôn giáo: {{ DB::table('tbl_tongiao')->where('id', $nhankhau->idtongiao)->value('name') }} &nbsp; &nbsp; &nbsp; &nbsp;  <span class="bold">9.</span> Quốc tịch: {{ DB::table('tbl_quocgia')->where('id', $nhankhau->idquoctich)->value('name') }} <br>
    <span class="bold">10.</span> CMND số: {{ $nhankhau->cmnd_so }} &nbsp; &nbsp; &nbsp; &nbsp;   <span class="bold">11.</span> Hộ chiếu số: {{ $nhankhau->hochieu_so }} <br>
    <span class="bold">12.</span> Nơi thường trú: <span>  {{ $nhankhau->chitiet_thuongtru }} - {{ ($nhankhau->idxa_thuongtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_thuongtru)->value('name') : '' }} - {{ ($nhankhau->idhuyen_thuongtru) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_thuongtru)->value('name') : '' }} - {{ ($nhankhau->idtinh_thuongtru) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_thuongtru)->value('name') : '' }} </span> <br>
    <span class="bold">13.</span> Địa chỉ chỗ ở hiện nay: <span>  {{ $nhankhau->chitiet_noiohiennay }} - {{ ($nhankhau->idxa_noiohiennay) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noiohiennay)->value('name') : '' }} - {{ ($nhankhau->idhuyen_noiohiennay) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noiohiennay)->value('name') : '' }} - {{ ($nhankhau->idtinh_noiohiennay) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noiohiennay)->value('name') : '' }} </span> <br>
    <span class="bold">14.</span> Trình độ học vấn: {{ DB::table('tbl_trinhdohocvan')->where('id', $nhankhau->idtrinhdohocvan)->value('name') }} &nbsp; &nbsp; &nbsp; &nbsp;  <span class="bold">15.</span> Trình độ ngoại ngữ: {{ $nhankhau->trinhdochuyenmon }} <br>
    <span class="bold">16.</span> Biết tiếng dân tộc: {{ $nhankhau->biettiengdantoc }}  &nbsp; &nbsp; &nbsp; &nbsp;   <span class="bold">17.</span> Trình độ ngoại ngữ: {{ $nhankhau->trinhdongoaingu }} <br>
    <span class="bold">18.</span> Nghề nghiệp, nơi làm việc: {{ DB::table('tbl_nghenghiep')->where('id', $nhankhau->idnghenghiep)->value('name') }}, {{ $nhankhau->chitiet_noilamviec }} - {{ ($nhankhau->idxa_noilamviec) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noilamviec)->value('name') : '' }} - {{ ($nhankhau->idhuyen_noilamviec) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noilamviec)->value('name') : '' }} - {{ ($nhankhau->idtinh_noilamviec) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noilamviec)->value('name') : '' }} <br>
    <span class="bold">19.</span> Tóm tắt về bản thân (Từ đủ 14 tuổi trở lên đến nay ở đâu, làm gì): <br>
    <span class="tomtat">{!! $nhankhau->tomtatbanthan !!}</span>
    <span class="bold">20.</span> Tiền án (Tội danh, hình phạt, theo bản án số, ngày, tháng, năm của Tòa án): {{ $nhankhau->tienan_tiensu }} <br>
    <span class="bold">21.</span> Tóm tắt gia đình (Bố, mẹ; vợ/chồng; con; anh, chị, em ruột): <br>
    <span class="tomtat">{!! $nhankhau->tomtatgiadinh !!}</span>
</p>
<p>
    Tôi cam đoan những lời khai trên đây là đúng sự thật và chịu trách nhiệm trước pháp luật về cam đoan của mình./.
</p>
<table class="head" width="100%">
    <tr>
        <td class="center" style="width: 50%" valign="top"></td>
        <td> <span class="italic">Hà Tĩnh, ngày.....tháng.....năm.....</span> </td>
    </tr>
    <tr>
        <td valign="top" style="width: 50%">
            
        </td>
        <td valign="top" class="center">
            NGƯỜI KHAI HOẶC NGƯỜI VIẾT HỘ <br>
            (Ký, ghi rõ họ tên) <br>
        </td>
    </tr>
</table>