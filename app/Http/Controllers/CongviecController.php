<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class CongviecController extends Controller
{
    public $messages = [
        'sotailieu.required' => 'Số tài liệu/Ký hiệu không được để trống',
        'trichyeu.required' => 'Trích yếu không được để trống',
        'canbonhan.required' => 'Lãnh đạo xử lý không được để trống',
        'hancongviec.required' => 'Hạn công việc không được để trống',
        'ghichu.required' => 'Ghi chú, cán bộ nhập công việc không được để trống',
    ];
    public $curr_donvi = 19;
    public $curr_idcanbo = 27;
    public $curr_id_iddonvi_iddoi = 15;
    public $id_iddonvi_iddoi_lanhdao = 11;

    public function __construct()
    {
        $_SESSION['curr_donvi'] = $this->curr_donvi;
    }

    public function index( Request $request )
    {
        if($request->keyword)
        {
            $data['briefs'] = DB::table('tbl_tamtru')
            ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_tamtru.idnhankhau')
            ->join('tbl_sotamtru', 'tbl_sotamtru.id' , '=', 'tbl_tamtru.idsotamtru')
            ->where(array(
                ['sotamtru_so', 'like', '%'.$request->keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->orWhere(array(
                ['hoten', 'like', '%'.$request->keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->select('tbl_sotamtru.type', 'tbl_nhankhau.hoten', 'sotamtru_so', 'tbl_sotamtru.id as idsotamtru', 'tbl_sotamtru.idquocgia_tamtru', 'tbl_sotamtru.idtinh_tamtru', 'tbl_sotamtru.idhuyen_tamtru', 'tbl_sotamtru.idxa_tamtru', 'tbl_sotamtru.chitiet_tamtru' )
            ->orderBy('idsotamtru', 'DESC')
            ->paginate(9);
        }
        else
        {
            $data['congviec'] = DB::table( 'tbl_congviec' )
            ->join('tbl_canbo', 'tbl_canbo.idcanbo', '=', 'tbl_congviec.idcanbo_creater')
            ->select( 'tbl_congviec.idcongviec', 'hancongviec', 'thoigianhoanthanh', 'thoigiangiao', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'hanxuly', 'urlfile', 'idstatus', 'tbl_congviec.created' )
            ->orderBy('created', 'DESC')
            ->paginate(10);
        }

        print_r( $data['congviec'] ); die;

        if( $request->ajax() )
        {
            return response()->json(['html' => view('nhankhau-layouts.ajax_component.tamtru_nhankhautable', $data)->render()]);
        }
        return view('congviec.index', $data);
    }

    
    public function create()
    {   //echo $_SESSION['curr_donvi']; die;
        $data['page_name'] = "Thêm mới công việc";
        $data['list_lanhdao'] = DB::table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->select('tbl_canbo.id', 'hoten', 'tbl_chucvu.name')
        ->where(array(
            ['id_iddonvi_iddoi', '=', $this->id_iddonvi_iddoi_lanhdao]
        ))
        ->get();
        return view('congviec.create', $data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'sotailieu' => 'required',
            'sotailieu' => 'required',
            'trichyeu' => 'required',
            'canbonhan' => 'required',
            'hancongviec' => 'required',
            'ghichu' => 'required',

        ], $this->messages);

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $dataCongViec = array(
            'idcanbo_creater' => $this->curr_idcanbo,
            'id_iddonvi_iddoi_creater' => $this->curr_iddoicongtac,
            'sotailieu' => $request->sotailieu,
            'trichyeu' => $request->trichyeu,
            'noisoanthao' => $request->noisoanthao,
            'chitiet' => $request->chitiet,
            'hancongviec' => date('Y-m-d', strtotime($request->hancongviec)),
            'idstatus' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );
        
        $idcongviec = DB::table('tbl_congviec')->insertGetId( $dataCongViec );

        $dataCongViecChuyentiep = array(
            'idcongviec' => $idcongviec,
            'iddonvinhan' => $this->curr_donvi,
            'idnguoinhan' => $request->canbonhan,
            'ghichu' => $request->ghichu,
            'timechuyentiep' => time(),
            'order' => 0,
            'iddoinhan' => 1
        );
        DB::table('tbl_congviec_chuyentiep')->insert( $dataCongViecChuyentiep );

        return response()->json(['success' => 'Thêm công việc thành công ', 'url' => route('cong-viec.index')]);
    }
}
