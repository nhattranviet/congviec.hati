<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Session;
use App\User;
use App\Canbo;

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
    
    // public $id_iddonvi_iddoi_lanhdao = 11;

    public $hanxuly;
    public $hancongviec;

    public $idnhomquyen_canbo = 1;
    public $idnhomquyen_doipho = 2;
    public $idnhomquyen_doitruong = 3;
    public $idnhomquyen_capphodonvi = 4;
    public $idnhomquyen_captruongdonvi = 5 ;
    public $idnhomquyen_administrator = 7;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_curr_id_iddonvi_iddoi_lanhdao()
    {
        return DB::table('tbl_donvi_doi')->where( array(
            ['iddonvi', Session::get('userinfo')->iddonvi],
            ['iddoi', '=', 2]
        ) )->value('id');
    }

    

    public function index( Request $request )
    {
        $arrWhere = array();
        if( Session::get('userinfo')->id_iddonvi_iddoi ==  $this->get_curr_id_iddonvi_iddoi_lanhdao() )
        {
            $data['list_doicongtac'] = DB::table('tbl_lanhdaodonvi_quanlydoi')
            ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_lanhdaodonvi_quanlydoi.idcanbo')
            ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_lanhdaodonvi_quanlydoi.id_iddonvi_iddoi')
            ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
            ->where('idcanbo', Session::get('userinfo')->idcanbo)
            ->select('tbl_donvi_doi.id', 'tbl_doicongtac.name')
            ->get()->toArray();
        }
        else
        {
            $data['list_doicongtac'] = DB::table('tbl_donvi_doi')
            ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
            ->where( 'tbl_donvi_doi.id', Session::get('userinfo')->id_iddonvi_iddoi )
            ->select('name', 'tbl_donvi_doi.id')
            ->get()->toArray();
        }
        $data['current_day'] = date('Y-m-d', time());
        $arrListdoi = array();
        foreach ($data['list_doicongtac'] as $value) {
            $arrListdoi[] = $value->id;
        }

        if( $request->ajax() )
        {
            if($request->id_iddonvi_iddoi != NULL)
            {
                $arrListdoi = array($request->id_iddonvi_iddoi);
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
                if( $request->idstatus == 3 )   // Quá hạn
                {
                    $current_day = date('Y-m-d', time());
                    // echo date('')
                    $arrWhere[] = array('idstatus', '=', 1 );
                    $arrWhere[] = array('hancongviec', '<=', $current_day );
                }
                else
                {
                    $arrWhere[] = array('idstatus', '=', $request->idstatus );
                }
            }

            if( Session::get('userinfo')->id_iddonvi_iddoi ==  $this->get_curr_id_iddonvi_iddoi_lanhdao() || Session::get('userinfo')->idnhomquyen == $this->idnhomquyen_doitruong )    // Lãnh đạo đơn vị hoặc đội trưởng
            {
                $dt = DB::table( 'tbl_congviec' )
                ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
                ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
                ->where( $arrWhere )
                ->where(function ($query) use ($arrListdoi) {
                    $query->whereIn('id_iddonvi_iddoi_nhan', $arrListdoi)
                    ->orWhere('idcanbonhan', Session::get('userinfo')->idcanbo);
                });
                if ($request->keyword)
                {
                    $dt = $dt->where(function ($query) use ($request)
                    {
                        $query->where('sotailieu', 'LIKE', '%'.$request->keyword.'%')
                        ->orWhere('trichyeu', 'LIKE', '%'.$request->keyword.'%');
                    });
                }

                if( $request->idstatus == 3 )
                {
                    $dt = $dt->orderBy('hancongviec', 'ASC');
                }
                
                $data['list_congviec'] = $dt->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
                ->distinct()
                ->paginate(10, ['idcongviec']);
            }
            else
            {   
                $arrWhere[] = array('idcanbonhan', '=', Session::get('userinfo')->idcanbo);
                $dt = DB::table( 'tbl_congviec' )
                ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
                ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
                ->where( $arrWhere );
                if ($request->keyword)
                {
                    $dt = $dt->where(function ($query) use ($request)
                    {
                        $query->where('sotailieu', 'LIKE', '%'.$request->keyword.'%')
                        ->orWhere('trichyeu', 'LIKE', '%'.$request->keyword.'%');
                    });
                }
                if( $request->idstatus == 3 )
                {
                   $dt = $dt->orderBy('hancongviec', 'ASC');
                }
                $data['list_congviec'] = $dt->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
                ->distinct()
                ->paginate(10, ['idcongviec']);
            }

            return response()->json(['html' => view('congviec.congviec_table', $data)->render()]);

        }
        else
        {   
            
            if( Session::get('userinfo')->id_iddonvi_iddoi ==  $this->get_curr_id_iddonvi_iddoi_lanhdao() || Session::get('userinfo')->idnhomquyen == $this->idnhomquyen_doitruong )    // Lãnh đạo đơn vị hoặc đội trưởng
            {
                $data['list_congviec'] = DB::table( 'tbl_congviec' )
                ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
                ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
                ->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
                ->whereIn('id_iddonvi_iddoi_nhan', $arrListdoi)
                ->orWhere('idcanbonhan', Session::get('userinfo')->idcanbo)
                ->orderBy('tbl_congviec.id', 'DESC')
                ->distinct()
                ->paginate(10, ['idcongviec']);
            }
            else
            {   
                $data['list_congviec'] = DB::table( 'tbl_congviec' )
                ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
                ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
                ->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
                ->where('idcanbonhan', Session::get('userinfo')->idcanbo)
                ->orderBy('tbl_congviec.id', 'DESC')
                ->distinct()
                ->paginate(10, ['idcongviec']);
            }

            
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
            ['id_iddonvi_iddoi', '=', $this->get_curr_id_iddonvi_iddoi_lanhdao()]
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
            'idcanbo_creater' => Session::get('userinfo')->idcanbo,
            'id_iddonvi_iddoi_creater' => Session::get('userinfo')->id_iddonvi_iddoi,
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
            'id_iddonvi_iddoi_nhan' => $this->get_curr_id_iddonvi_iddoi_lanhdao(),
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
            ['id_iddonvi_iddoi', '=', $this->get_curr_id_iddonvi_iddoi_lanhdao()]
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
        ->where('iddonvi', Session::get('userinfo')->iddonvi )
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
        // print_r( $congviec_node_info ); die;
        DB::table('tbl_congviec_chuyentiep')->where('id', $idnode)->delete();
        if( $congviec_node_info->order == 0 )
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
