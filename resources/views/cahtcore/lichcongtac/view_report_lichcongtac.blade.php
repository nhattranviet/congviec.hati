@include('commons.word_css')
<style>
    table.border tr td, div{
        padding: 2px 2px !important;
        font-size: 13pt !important;
    }
</style>
    <table class="head">
        <tr class="center">
            <td class="center" style="width: 250px" valign="top" >
                @if (config('user_config.iddonvi_bangiamdoc') == $iddonvi)
                    <span style="font-size: 14pt;">BỘ CÔNG AN</span><br>
                    <span class="daumuc-13">CÔNG AN TỈNH HÀ TĨNH</span>
                @else
                    <span style="font-size: 14pt;">CÔNG AN TỈNH HÀ TĨNH</span><br>
                    <span class="daumuc-13"> {{ ($infodonvi->loaidonvi == 'phongban') ? 'PHÒNG' : NULL }} {{ $infodonvi->kyhieu }}</span>
                @endif
                
            </td>
            <td  class="center">
                <span class="daumuc-13">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM<br>Độc lập - Tự do - Hạnh phúc</span><br>
                <span class="italic">Hà Tĩnh, ngày {{ date('d', time()) }} tháng {{ date('m', time()) }} năm {{ date('Y', time()) }}</span>
            </td>
        </tr>
    </table>
    <br>
    <div class="center" style="font-weight: bold; font-size: 13pt;">{{ (config('user_config.iddonvi_bangiamdoc') == $iddonvi) ? 'LỊCH LÀM VIỆC CỦA BAN GIÁM ĐỐC CÔNG AN TỈNH' : 'LỊCH LÀM VIỆC CỦA LÃNH ĐẠO ĐƠN VỊ' }}</div>
    <div class="center">(Từ ngày {{ $tungay }}  đến {{ $denngay }})</div>
    <div class="center">Trực tuần: <b>{{ $lanhdaotruc }}</b></div>
    <br>
    <table class="border" border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 100px;" class="daumuc-center" valign="center" >NGÀY</td>
            <td style="width: 50px;" class="daumuc-center" valign="center" >BUỔI</td>
            <td class="daumuc-center" valign="center" >NỘI DUNG</td>
            <td class="daumuc-center" valign="center" >CHỦ TRÌ</td>
            <td class="daumuc-center" valign="center" >ĐỊA ĐIỂM</td>
        </tr>
        @foreach ($list_ngay as $ngay)
            @php
                $congviecsang = (isset( $list_congviec_chuanhoa_theo_buoi[$ngay]['Sáng'] )) ? count( $list_congviec_chuanhoa_theo_buoi[$ngay]['Sáng'] ) : 0;
                $congviecchieu = (isset( $list_congviec_chuanhoa_theo_buoi[$ngay]['Chiều'] )) ? count( $list_congviec_chuanhoa_theo_buoi[$ngay]['Chiều'] ) : 0;
                $total_congviec = $congviecsang + $congviecchieu;
                $flag_ngay = TRUE;
                $flag_rowspan_ngay = TRUE;
            @endphp

            @if (isset( $list_congviec_chuanhoa_theo_buoi[$ngay] ))

                @foreach ($list_congviec_chuanhoa_theo_buoi[$ngay] as $buoi => $list_congviec)
                    @php
                        $numviec_buoi = count( $list_congviec_chuanhoa_theo_buoi[$ngay][$buoi] );
                        $flag_rowspan_buoi = TRUE;
                        $count_cv_buoi = 1;
                    @endphp
                    @foreach ($list_congviec as $congviec)
                            <tr>
                                {!! ($flag_rowspan_ngay) ? '<td class="center" rowspan="'.$total_congviec.'"><div>'.$day_name[date('w', strtotime($ngay))].'</div><div>('.date('d/m', strtotime($ngay)).')</div></td>' : NULL !!}
                                {!! ($flag_rowspan_buoi) ? '<td class="center" rowspan="'.$numviec_buoi.'">'.$buoi.'</td>' : NULL !!}
                                <td {!! ($count_cv_buoi != $numviec_buoi ) ? 'class="border-bottom-dotted"' : NULL !!} >{!! $congviec->noidungcongviec .' ('.date("H", strtotime($congviec->ngay)).'h'.date("i", strtotime($congviec->ngay)).')' !!}</td>
                                <td {!! ($count_cv_buoi != $numviec_buoi ) ? 'class="border-bottom-dotted"' : NULL !!} >{!! $congviec_lanhdao[$congviec->id] !!}</td>
                                <td {!! ($count_cv_buoi != $numviec_buoi ) ? 'class="border-bottom-dotted"' : NULL !!} >{!! $congviec->diadiem !!}</td>
                            </tr>
                        @php
                            $count_cv_buoi++;
                            $flag_rowspan_buoi = FALSE;
                            $flag_rowspan_ngay = FALSE;
                        @endphp
                    @endforeach
                @endforeach

            @endif

        @endforeach
    </table>
    <br>
    <div>Ngoài lịch làm việc trên, các đồng chí lãnh đạo Công an tỉnh chỉ đạo các mặt công tác theo phân công phụ trách./.</div>
    <br>
    <table class="head" width="100%">
        <tr>
            <td valign="top" style="width: 50%; text-align: left; font-size:11pt;">
                <b><i>Nơi nhận:</i></b><br>
                - Các đ/c trong Ban Giám đốc CAT<br>
                    (để báo cáo);<br>
                - Các phòng <br>
                    (để thực hiện);<br>
                - Lưu VT, PV11-TH.

            </td>
            <td valign="top" class="center">
                <span class="daumuc-13">CÔNG AN TỈNH HÀ TĨNH</span><br>
            </td>
        </tr>
    </table>
