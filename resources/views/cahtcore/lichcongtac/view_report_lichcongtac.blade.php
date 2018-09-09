@include('commons.word_css')
@foreach ($list_tuan as $tuan)

    <div class="center" style="page-break-before: always; font-weight: bold;">CHƯƠNG TRÌNH CÔNG TÁC</div>
    <div class="center">Từ ngày {{ date('d-m-Y', strtotime($tuan[0])) }} đến {{ date('d-m-Y', strtotime($tuan[6])) }}</div>
    <br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td class="daumuc-center" style="width: 100px;">THỜI GIAN</td>
            <td class="daumuc-center" valign="center" >NỘI DUNG CÔNG TÁC</td>
            <td class="daumuc-center" valign="center" >KẾT QUẢ THỰC HIỆN</td>
        </tr>
        @foreach ($tuan as $day)
            @php
                $day_int = date('w', strtotime($day));
            @endphp
            <tr>
                <td class="center">
                    <div>{{ $day_name[$day_int] }}</div>
                    <div>Ngày {{ date('d-m', strtotime($day)) }}</div>
                </td>
                <td>
                    {!! isset($nhatky_chuanhoa[$day]) ? $nhatky_chuanhoa[$day]->noidungdukien : NULL !!}
                </td>
                <td>
                    {!! isset($nhatky_chuanhoa[$day]) ? $nhatky_chuanhoa[$day]->ketquathuchien : NULL !!}
                </td>
            </tr>
        @endforeach
    </table>
    <br>
    <table class="head" width="100%">
        <tr>
            <td valign="top" style="width: 50%">
                <span class="daumuc-10">PHÊ DUYỆT CỦA LÃNH ĐẠO <br>TRỰC TIẾP PHỤ TRÁCH</span><br>
            </td>
            <td valign="top" class="center">
                <span class="daumuc-10">NHẬN XÉT, ĐÁNH GIÁ CỦA <br>LÃNH ĐẠO TRỰC TIẾP PHỤ TRÁCH</span><br>
            </td>
        </tr>
    </table>
@endforeach
