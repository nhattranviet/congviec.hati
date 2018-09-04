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

    <div class="center" style="page-break-before: always; font-weight: bold;">THỐNG KÊ NHẬT KÝ ĐỘI</div>
    <div class="center">{{ $tendoi }} từ ngày {{ date('d-m-Y', strtotime($tungay_ngaydautuan_cuoituan['ngaydautuan'])) }} đến {{ date('d-m-Y', strtotime($denngay_ngaydautuan_cuoituan['ngaycuoituan'])) }}</div>
    <br>
    <p>Tổng số tuần cần cập nhật: {{ count($list_Moday) }}.</p>
    <p>Tổng số tuần cập nhật đủ: {{ count($list_day_full_nhatky_info) }}.</p>
    <p>Tổng số tuần cập nhật thiếu hoặc không cập nhật: {{ $a = count($tuanchuacapnhat) }}. 
        @if ($a > 0)
            <b>Cụ thể:</b>
            @foreach ($tuanchuacapnhat as $tuan)
                {{ date('d-m-Y', strtotime($tuan)) }} đến {{ date('d-m-Y', (strtotime($tuan) + 518400)) }}, 
            @endforeach
            
        @endif
    </p>
    
    
    
