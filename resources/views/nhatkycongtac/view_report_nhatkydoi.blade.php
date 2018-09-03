<style>
    table{
        width: 100%;
    }
    .center{
        text-align: center;
    }
    table tr td{
        padding: 2px 2px;
        font-size: 12pt;
    }

    table.head td{
        padding: 2px 2px;
        font-size: 12pt;
        text-align: center;
    }

    table.info{
        border-collapse: collapse;
    }
    .bold{
        font-weight: bold;
    }
    .italic{
        font-style: italic;
    }
    .daumuc{
        font-size: 11pt;
        font-weight: bold;
    }

    .daumuc-10{
        font-size: 10pt;
        font-weight: bold;
    }
    .daumuc-9{
        font-size: 9pt;
        font-weight: bold;
    }
    .daumuc-8{
        font-size: 8pt;
        font-weight: bold;
    }
    p{
        margin-top: 0.6pt;
    }
    .daumuc-center{
        text-align: center;
        font-size: 11pt;
        font-weight: bold;
        padding: 2px 2px 2px 2px;
    }
</style>
@foreach ($list_tuan as $tuan)

    <div class="center" style="page-break-before: always; font-weight: bold;">CHƯƠNG TRÌNH CÔNG TÁC TUẦN</div>
    <div class="center">Từ ngày {{ date('d-m-Y', strtotime($tuan[0])) }} đến {{ date('d-m-Y', strtotime($tuan[6])) }}</div>
    <br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td class="daumuc-center" style="width: 50%" valign="center" >NỘI DUNG CÔNG TÁC</td>
            <td class="daumuc-center" valign="center" >KẾT QUẢ THỰC HIỆN</td>
        </tr>
            <tr>
                @if (isset( $nhatky_chuanhoa[$tuan[0]] ))
                    <td>{!! $nhatky_chuanhoa[$tuan[0]]->noidungdukien !!}</td>
                    <td>{!! $nhatky_chuanhoa[$tuan[0]]->ketquathuchien !!}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
            </tr>
    </table>
    <br>
    <table class="head" width="100%">
        <tr>
            <td valign="top" style="width: 50%">
                <span class="daumuc-10" style="font-weight: bold;">PHÊ DUYỆT CỦA LÃNH ĐẠO <br>TRỰC TIẾP PHỤ TRÁCH</span><br>
            </td>
            <td valign="top" class="center">
                <span class="daumuc-10" style="font-weight: bold;">NHẬN XÉT, ĐÁNH GIÁ CỦA <br>LÃNH ĐẠO TRỰC TIẾP PHỤ TRÁCH</span><br>
            </td>
        </tr>
    </table>
@endforeach
