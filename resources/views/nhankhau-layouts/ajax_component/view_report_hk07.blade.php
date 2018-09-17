@include('commons.word_css')
<table class="head">
    <tr>
        <td valign="top" class="center">
            <span>CAH KỲ ANH</span><br>
            <span>CA...................</span><br><br>
            <span>Số:....../GCHK</span>
        </td>
        <td valign="top" class="center">
            <span class="daumuc">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br>
            <span class="italic">Độc lập - Tự do - Hạnh phúc</span>
        </td>
        <td class="center daumuc" style="width: 170px; font-size: 11pt;" valign="top" >
            Mẫu HK07 ban hành theo TT số 36/2014/TT-BCA ngày 09/9/2014
        </td>
    </tr>
</table>
<br>

<p class="center"><span class="daumuc-12">GIẤY CHUYỂN HỘ KHẨU</span></p>
<br>
<p>
    <span class="bold">1.</span></span> Họ và tên: <span class="uppercase bold" style="font-weight: bold;"> {{ $nhankhau->hoten }} </span> <br>
    <span class="bold">2.</span> Họ và tên gọi khác (nếu có): <span> {{ $nhankhau->tenkhac }} </span> <br>
    <span class="bold">3.</span> Ngày, tháng, năm sinh: <span> {{ ( $nhankhau->ngaysinh != NULL) ? date( 'd-m-Y', strtotime($nhankhau->ngaysinh) ) : '' }} </span> &nbsp; &nbsp; &nbsp; &nbsp; <span class="bold">4.</span> Giới tính: <span>{{ ( $nhankhau->gioitinh == 1) ? 'Nam' : 'Nữ' }}</span> <br>
    <span class="bold">5.</span> Nơi sinh: <span>  {{ $nhankhau->chitiet_noisinh }} - {{ ($nhankhau->idxa_noisinh) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noisinh)->value('name') : '' }} - {{ ($nhankhau->idhuyen_noisinh) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noisinh)->value('name') : '' }} - {{ ($nhankhau->idtinh_noisinh) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noisinh)->value('name') : '' }} </span> <br>
    <span class="bold">6.</span> Nguyên quán: <span>  {{ $nhankhau->chitiet_nguyenquan }} - {{ ($nhankhau->idxa_nguyenquan) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_nguyenquan)->value('name') : '' }} - {{ ($nhankhau->idhuyen_nguyenquan) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_nguyenquan)->value('name') : '' }} - {{ ($nhankhau->idtinh_nguyenquan) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_nguyenquan)->value('name') : '' }} </span> <br>
    <span class="bold">7.</span> Dân tộc: {{ DB::table('tbl_dantoc')->where('id', $nhankhau->iddantoc)->value('name') }} &nbsp; &nbsp; &nbsp; &nbsp;  <span class="bold">8.</span> Tôn giáo: {{ DB::table('tbl_tongiao')->where('id', $nhankhau->idtongiao)->value('name') }} &nbsp; &nbsp; &nbsp; &nbsp;  <span class="bold">9.</span> Quốc tịch: {{ DB::table('tbl_quocgia')->where('id', $nhankhau->idquoctich)->value('name') }} <br>
    <span class="bold">10.</span> Nơi thường trú: <span>  {{ $nhankhau->chitiet_thuongtru }} - {{ ($nhankhau->idxa_thuongtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_thuongtru)->value('name') : '' }} - {{ ($nhankhau->idhuyen_thuongtru) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_thuongtru)->value('name') : '' }} - {{ ($nhankhau->idtinh_thuongtru) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_thuongtru)->value('name') : '' }} </span> <br>
    <span class="bold">11.</span> Họ và tên chủ hộ nơi đi: <span class="uppercase"> {{ $chuhoinfo->hoten }}</span> &nbsp; &nbsp; &nbsp; &nbsp;   <span class="bold">12.</span> Quan hệ với chủ hộ: {{ $tenquanhechuho }} <br>
    <span class="bold">13.</span> Lý do chuyển hộ khẩu: <span> {!! $lydo !!} </span> <br>
    <span class="bold">14.</span> Nơi chuyển đến: <span>  {!! $noichuyenden !!} </span> <br>
    <span class="bold">15.</span> Những người trong hộ cùng chuyển hộ khẩu:
    @if ($nhankhauchuyencung != NULL)
        <table class="info" border="1" cellspacing="0" cellpadding="0">
            <tr class="bold">
                <td class="center">TT</td>
                <td class="center">Họ và tên</td>
                <td class="center">Ngày, tháng, năm, sinh</td>
                <td class="center">Giới tính</td>
                <td class="center">Nguyên quán</td>
                <td class="center">Dân tộc</td>
                <td class="center">Quốc tịch</td>
                <td class="center">CMND số hoặc Hộ chiếu số</td>
                <td class="center">Quan hệ</td>
            </tr>
            @php
                $i=1;
            @endphp
        @foreach ($nhankhauchuyencung as $nhankhauchuyen_item)
            <tr>
                <td class="center">{{ $i }}</td>
                <td>{{ $nhankhauchuyen_item->hoten }}</td>
                <td class="center">{{ ( $nhankhauchuyen_item->ngaysinh != NULL) ? date( 'd-m-Y', strtotime($nhankhauchuyen_item->ngaysinh) ) : '' }}</td>
                <td class="center">{{ ( $nhankhauchuyen_item->gioitinh == 1) ? 'Nam' : 'Nữ' }}</td>
                <td>{{ $nhankhauchuyen_item->chitiet_nguyenquan }} - {{ ($nhankhauchuyen_item->idxa_nguyenquan) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhauchuyen_item->idxa_nguyenquan)->value('name') : '' }} - {{ ($nhankhauchuyen_item->idhuyen_nguyenquan) ? DB::table('tbl_huyen_tx')->where('id', $nhankhauchuyen_item->idhuyen_nguyenquan)->value('name') : '' }} - {{ ($nhankhauchuyen_item->idtinh_nguyenquan) ? DB::table('tbl_tinh_tp')->where('id', $nhankhauchuyen_item->idtinh_nguyenquan)->value('name') : '' }}</td>
                <td>{{ DB::table('tbl_dantoc')->where('id', $nhankhauchuyen_item->iddantoc)->value('name') }}</td>
                <td>{{ DB::table('tbl_quocgia')->where('id', $nhankhauchuyen_item->idquoctich)->value('name') }}</td>
                <td>{{ $nhankhauchuyen_item->cmnd_so }}</td>
                <td></td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
        </table>
    @else
    Không
    @endif
</p><br>
<table class="head" width="100%">
    <tr>
        <td class="center" style="width: 50%" valign="top"></td>
        <td> <span class="italic">Hà Tĩnh, ngày.....tháng.....năm.....</span> </td>
    </tr>
    <tr>
        <td valign="top" style="width: 50%">
            
        </td>
        <td valign="top" class="center bold">
            <span class="bold">TRƯỞNG CÔNG AN</span>.................... <br>
            (Ký, ghi rõ họ tên, đóng dấu) <br>
        </td>
    </tr>
</table>