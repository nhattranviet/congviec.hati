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

    <div class="center" style="page-break-before: always; font-weight: bold;">THỐNG KÊ NHẬT KÝ CÁN BỘ</div>
    <div class="center">Đ/c {{ $hoten }} từ ngày {{ $tungay_d_m_Y }} đến {{ $denngay_d_m_Y }}</div>
    <br>
    <p>Tổng số ngày cần cập nhật: {{ count($list_ngay_not_cuoituan) }}.</p>
    <p>Tổng số ngày cập nhật đủ: {{ count($list_ngay_full_nhatky_info) }}.</p>
    <p>Tổng số ngày cập nhật thiếu hoặc không cập nhật: {{ $a = count($ngaychuacapnhat) }}. 
        @if ($a > 0)
            <b>Cụ thể:</b>
            @foreach ($ngaychuacapnhat as $ngay)
                {{ date('d-m-Y', strtotime($ngay)) }}, 
            @endforeach
            
        @endif
    </p>
    
    
    
