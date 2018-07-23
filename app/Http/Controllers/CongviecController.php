<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Session;

class CongviecController extends Controller
{
    public $messages = [
        'sotailieu.required' => 'Số tài liệu/Ký hiệu không được để trống',
        'trichyeu.required' => 'Trích yếu không được để trống',
        'canbonhan.required' => 'Lãnh đạo xử lý không được để trống',
        'hancongviec.required' => 'Hạn công việc không được để trống',
        'ghichu.required' => 'Ghi chú, cán bộ nhập công việc không được để trống',
        'idstatus.required' => 'Trạng thái không được để trống',
        
    ];
    public $curr_donvi = 19;
    public $curr_idcanbo = 27;
    public $curr_id_iddonvi_iddoi = 15;
    public $id_iddonvi_iddoi_lanhdao = 11;

    public $hanxuly;
    public $hancongviec;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index( Request $request )
    {
        $arrWhere = array();
        // session('name', 'Trần Viết Nhật');
        // echo session('name'); die;
        // Session::put('id',12 );
        // echo Session::get('id' );
        // // if($request->session()->has('name'))
        // // {
        // //     echo 'have';
        // // }else{
        // //     echo 'No';
        // // }
        // // die;
        // echo $request->session()->get('name', 'Không có giá trị');
        // $a = session(['key' => 'value']);
        // print_r($a['key']);
        // die;

        if($request->id_iddonvi_iddoi != NULL)
        {
            $arrWhere[] = array('tbl_congviec_chuyentiep.id_iddonvi_iddoi_nhan', '=', $request->id_iddonvi_iddoi );
        }

        if($request->ngaytao_tungay != NULL)
        {
            $arrWhere[] = array('tbl_congviec.created_at', '>=', date('Y-m-d', strtotime($request->ngaytao_tungay)));
        }

        if($request->ngaytao_denngay != NULL)
        {
            $arrWhere[] = array('tbl_congviec.created_at', '<=', date('Y-m-d', strtotime($request->ngaytao_denngay)));
        }

        if($request->idstatus != NULL)
        {
            $arrWhere[] = array('idstatus', '=', $request->idstatus );
        }

        $dt = DB::table( 'tbl_congviec' )
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
        ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
        ->where($arrWhere);
        // ->where('tbl_congviec_chuyentiep.id', DB::raw("(SELECT MAX(`id`) FROM tbl_congviec_chuyentiep WHERE idcongviec =".));
        if ($request->keyword)
        {
            $dt = $dt->where(function ($query) use ($request)
            {
                $query->where('sotailieu', 'LIKE', '%'.$request->keyword.'%')
                ->orWhere('trichyeu', 'LIKE', '%'.$request->keyword.'%');
            });
        }
        $data['list_congviec'] = $dt->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
        ->orderBy('tbl_congviec.id', 'DESC')
        ->distinct()
        ->paginate(10);

        $data['list_doicongtac'] = DB::table('tbl_donvi_doi')
        ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
        ->where('iddonvi', $this->curr_donvi)
        ->select('name', 'tbl_donvi_doi.id')
        ->get();

        if( $request->ajax() )
        {
            
            return response()->json(['html' => view('congviec.congviec_table', $data)->render()]);
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
            'idcanbonhan' => 'required',
            'hancongviec' => 'required',
            'ghichu' => 'required',

        ], $this->messages);

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $dataCongViec = array(
            'idcanbo_creater' => $this->curr_idcanbo,
            'id_iddonvi_iddoi_creater' => $this->curr_id_iddonvi_iddoi,
            'sotailieu' => $request->sotailieu,
            'trichyeu' => $request->trichyeu,
            'noisoanthao' => $request->noisoanthao,
            'chitiet' => $request->chitiet,
            'ghichu' => $request->ghichu,
            'hancongviec' => date('Y-m-d', strtotime($request->hancongviec)),
            'idstatus' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );
        
        $idcongviec = DB::table('tbl_congviec')->insertGetId( $dataCongViec );

        $dataCongViecChuyentiep = array(
            'idcongviec' => $idcongviec,
            'idcanbonhan' => $request->idcanbonhan,
            'timechuyentiep' => Carbon::now(),
            'id_iddonvi_iddoi_nhan' => $this->id_iddonvi_iddoi_lanhdao,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'order' => 0,
            'ghichu' => $request->ghichu,
        );
        DB::table('tbl_congviec_chuyentiep')->insert( $dataCongViecChuyentiep );

        return response()->json(['success' => 'Thêm công việc thành công ', 'url' => route('cong-viec.index')]);
    }

    public function edit($idcongviec)
    {
        $data['page_name'] = "Sửa công việc";
        $data['list_lanhdao'] = DB::table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->select('tbl_canbo.id', 'hoten', 'tbl_chucvu.name')
        ->where(array(
            ['id_iddonvi_iddoi', '=', $this->id_iddonvi_iddoi_lanhdao]
        ))
        ->get();
        $data['congviec_info'] = DB::table('tbl_congviec')->where('id',$idcongviec)->first();
        $data['idcanboxulybandau'] = DB::table('tbl_congviec_chuyentiep')->where( array(
            ['idcongviec', '=', $idcongviec],
            ['order', '=', 0],
        ) )->value('idcanbonhan');
        // print_r($data['congviec_info']); die;
        return view('congviec.edit', $data);
    }

    public function update(Request $request, $idcongviec)
    {
         $validator = Validator::make($request->all(), [
            'sotailieu' => 'required',
            'sotailieu' => 'required',
            'trichyeu' => 'required',
            'idcanbonhan' => 'required',
            'hancongviec' => 'required',
            'ghichu' => 'required',
            'idstatus' => 'required',

        ], $this->messages);

        $validator->after(function ($validator) use ($request) {
            if($request->hanxuly &&  strtotime($request->hanxuly) > strtotime($request->hancongviec) )
            {
                $validator->errors()->add('hanxuly', 'Hạn xử lý xong phải trước hoặc bằng hạn công việc!');
            }
        });
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $dataCongViec = array(
            'sotailieu' => $request->sotailieu,
            'trichyeu' => $request->trichyeu,
            'noisoanthao' => $request->noisoanthao,
            'chitiet' => $request->chitiet,
            'ghichu' => $request->ghichu,
            'idstatus' => $request->idstatus,
            'hancongviec' => date('Y-m-d', strtotime($request->hancongviec)),
            'hanxuly' => ($request->hanxuly != NULL) ? date('Y-m-d', strtotime($request->hanxuly)) : NULL,
            'updated_at' => Carbon::now()
        );
        
        DB::table('tbl_congviec')->where('id',$idcongviec)->update( $dataCongViec );

        $dataCongViecChuyentiep_update = array(
            'idcanbonhan' => $request->idcanbonhan,
            'timechuyentiep' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        DB::table('tbl_congviec_chuyentiep')->where(array(
            ['idcongviec', '=', $idcongviec],
            ['order', '=', 0],
        ))->update( $dataCongViecChuyentiep_update );
        return response()->json(['success' => 'Thêm công việc thành công ', 'url' => route('cong-viec.index')]);
    }

    public function show($idcongviec)
    {
        // echo 5 % 2; die;
        $data['page_name'] = "Chi tiết công việc";
        $data['congviec_info'] = DB::table('tbl_congviec')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('tbl_congviec.id',$idcongviec)
        ->select('tbl_congviec.*', 'hoten')->first();

        $data['congviec_chuyentiep_info'] = DB::table('tbl_congviec_chuyentiep')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec_chuyentiep.idcanbonhan')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('idcongviec', $idcongviec)
        ->orderBy('timechuyentiep', 'ASC')
        ->select('tbl_congviec_chuyentiep.*', 'hoten')
        ->get()->toArray();
        // echo ( $data['congviec_chuyentiep_info'][0]->hoten ); die;
        return view('congviec.show', $data);
    }

    public function chuyentiep($idcongviec)
    {
        $data['page_name'] = "Chuyển công việc";
        $data['congviec_info'] = DB::table('tbl_congviec')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('tbl_congviec.id',$idcongviec)->select('tbl_congviec.*', 'hoten')->first();

        $data['list_doicongtac'] = DB::table('tbl_donvi_doi')
        ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
        ->where('iddonvi', $this->curr_donvi)
        ->select('name', 'tbl_donvi_doi.id')
        ->get();
        $data['congviec_chuyentiep_info'] = DB::table('tbl_congviec_chuyentiep')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec_chuyentiep.idcanbonhan')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('idcongviec', $idcongviec)
        ->orderBy('timechuyentiep', 'ASC')
        ->select('tbl_congviec_chuyentiep.*', 'hoten')
        ->get()->toArray();
        // print_r($data['list_doicongtac']); die;
        return view('congviec.chuyentiep', $data);
    }

    public function postChuyentiep(Request $request, $idcongviec)
    {
        $validator = Validator::make($request->all(), [
                'id_iddonvi_iddoi' => 'required',
                'idcanbonhan' => 'required',
                'hanxuly' => 'required|date_format:d-m-Y',
                'thoigiangiao' => 'required|date_format:d-m-Y|before_or_equal:hanxuly'

            ],
            [
                'id_iddonvi_iddoi.required' => 'Đội nhận việc không được để trống',
                'idcanbonhan.required' => 'Cán bộ nhận việc không được để trống',
                'hanxuly.required' => 'Hạn xử lý không được để trống',
                'thoigiangiao.before_or_equal' => 'Thời gian bắt đầu tính giao việc phải trước Thời gian lãnh đạo giao hoàn thành',
            ]
        );
            
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $dataCongViecChuyentiep = array(
            'idcongviec' => $idcongviec,
            'idcanbonhan' => $request->idcanbonhan,
            'timechuyentiep' => Carbon::now(),
            'id_iddonvi_iddoi_nhan' => $request->id_iddonvi_iddoi,
            'ghichu' => $request->ghichu,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        DB::table('tbl_congviec_chuyentiep')->insert( $dataCongViecChuyentiep );

        return response()->json(['success' => 'Chuyển tiếp công việc thành công ', 'url' => route('get-show-cong-viec', $idcongviec)]);        
    
    }

    public function delete($idcongviec)
    {
        $data['page_name'] = "Chi tiết công việc";
        $data['congviec_info'] = DB::table('tbl_congviec')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('tbl_congviec.id',$idcongviec)->select('tbl_congviec.*', 'hoten')->first();
        $data['congviec_chuyentiep_info'] = DB::table('tbl_congviec_chuyentiep')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec_chuyentiep.idcanbonhan')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('idcongviec', $idcongviec)
        ->orderBy('timechuyentiep', 'ASC')
        ->select('tbl_congviec_chuyentiep.*', 'hoten')
        ->get()->toArray();
        // print_r($data['congviec_info']); die;
        return view('congviec.delete', $data);
    }

    public function destroy($idcongviec)
    {
        DB::table('tbl_congviec_chuyentiep')->where('idcongviec', $idcongviec)->delete();
        DB::table('tbl_congviec')->where('id', $idcongviec)->delete();
        return redirect()->route('cong-viec.index');
    }

    public function deleteNodeChuyentiep( $idnode )
    {
        $congviec_node_info = DB::table('tbl_congviec_chuyentiep')->where('id',$idnode)->first();
        DB::table('tbl_congviec_chuyentiep')->where('id', $idnode)->delete();
        if( $congviec_node_info->order === 0 )
        {
            DB::table('tbl_congviec')->where('id', $congviec_node_info->idcongviec)->delete();
            return redirect()->route('cong-viec.index');
        }
        else
        {
            return redirect()->route('get-show-cong-viec', $congviec_node_info->idcongviec);
        }
        
        
    }
}
