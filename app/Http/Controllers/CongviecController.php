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
use App\UserApp\CongviecLibrary;
use App\UserApp\UserLibrary;
use Illuminate\Support\Facades\Redirect;

class CongviecController extends Controller
{
    public $messages_validate = [
        'sotailieu.required' => 'Số tài liệu/Ký hiệu không được để trống',
        'trichyeu.required' => 'Trích yếu không được để trống',
        'canbonhan.required' => 'Lãnh đạo xử lý không được để trống',
        'hancongviec.required' => 'Hạn công việc không được để trống',
        'ghichu.required' => 'Ghi chú, cán bộ nhập công việc không được để trống',
        'idstatus.required' => 'Trạng thái không được để trống',
    ];
    
    public $current_idcanbo;
    public $current_iduser;
    public $current_idrole;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index( Request $request )
    {
        // $arrWhere = array();
        // $current_idcanbo = Session::get('userinfo')->idcanbo;
        // $current_iduser = Session::get('userinfo')->iduser;
        // $current_idrole = UserLibrary::getIdRoleUser( $current_iduser );
        // if( $current_idrole == config('user_config.idnhomquyen_capphodonvi') || $current_idrole == config('user_config.idnhomquyen_captruongdonvi') )   // lãnh đạo đơn vị
        // {
        //     $data['list_doicongtac'] = UserLibrary::getListDoiLanhdaoQuanly($current_idcanbo, 'object');
        // }
        // else
        // {
        //     $data['list_doicongtac'] = UserLibrary::getIdDonviIdDoiofCanBo( $current_idcanbo, 'object' );
        // }
        
        // $data['current_day'] = date('Y-m-d', time());
        // $arrListdoi = array();
        // foreach ($data['list_doicongtac'] as $value) {
        //     $arrListdoi[] = $value->id;
        // }

        if( $request->ajax() )      //Begin ajax
        {
            if($request->sotailieu != NULL)
            {
                $arrWhere[] = array('sotailieu', 'LIKE', '%'.$request->sotailieu.'%');
            }

            if($request->trichyeu != NULL)
            {
                $arrWhere[] = array('trichyeu', 'LIKE', '%'.$request->trichyeu.'%');
            }

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

            if( $current_idrole == config('user_config.idnhomquyen_capphodonvi') || $current_idrole == config('user_config.idnhomquyen_captruongdonvi') ||  $current_idrole == config('user_config.idnhomquyen_doitruong') )        // Lãnh đạo đơn vị hoặc đội trưởng
            {
                $dt = DB::table( 'tbl_congviec' )
                ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
                ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
                ->where( $arrWhere )
                ->whereRaw('tbl_congviec_chuyentiep.id = (SELECT max(id) FROM tbl_congviec_chuyentiep WHERE tbl_congviec_chuyentiep.idcongviec = tbl_congviec.id  ) ')
                ->where(function ($query) use ($arrListdoi) {
                    $query->whereIn('id_iddonvi_iddoi_nhan', $arrListdoi)
                    ->orWhere('idcanbonhan', $current_idcanbo)
                    ->orWhere('idcanbo_creater', $current_idcanbo);
                });
                if( $request->idstatus == 3 )
                {
                    $dt = $dt->orderBy('hancongviec', 'ASC');
                }
                else
                {
                    $dt = $dt->orderBy('tbl_congviec.id', 'DESC');
                }
                $data['list_congviec'] = $dt->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
                ->paginate(10, ['idcongviec']);
            }
            else
            {   
                $arrWhere[] = array('idcanbonhan', '=', $current_idcanbo);
                $dt = DB::table( 'tbl_congviec' )
                ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
                ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
                ->where( $arrWhere )
                ->whereRaw('tbl_congviec_chuyentiep.id = (SELECT max(id) FROM tbl_congviec_chuyentiep WHERE tbl_congviec_chuyentiep.idcongviec = tbl_congviec.id  ) ')
                ->where(function ($query){
                    $query->where('idcanbonhan', $current_idcanbo)
                    ->orWhere('idcanbo_creater', $current_idcanbo);
                });


                if( $request->idstatus == 3 )
                {
                   $dt = $dt->orderBy('hancongviec', 'ASC');
                }
                else
                {
                    $dt = $dt->orderBy('tbl_congviec.id', 'DESC');
                }
                $data['list_congviec'] = $dt->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
                ->paginate(10, ['idcongviec']);
            }
            return response()->json(['html' => view('congviec.congviec_table', $data)->render()]);

        }   //End Ajax
        else
        {
            $index_role_info = CongviecLibrary::getUserMethodRoleInfo( Session::get('userinfo')->iduser, 'index' );
            if( $index_role_info->keyword == 'idcanbo' )

            if( $current_idrole == config('user_config.idnhomquyen_capphodonvi') || $current_idrole == config('user_config.idnhomquyen_captruongdonvi') ||  $current_idrole == config('user_config.idnhomquyen_doitruong') )        // Lãnh đạo đơn vị hoặc đội trưởng
            {
                $data['list_congviec'] = DB::table( 'tbl_congviec' )
                ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
                ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
                ->whereRaw('tbl_congviec_chuyentiep.id = (SELECT max(id) FROM tbl_congviec_chuyentiep WHERE tbl_congviec_chuyentiep.idcongviec = tbl_congviec.id  ) ')
                ->where(function($query) use ($arrListdoi, $current_idcanbo) {
                    $query->whereIn('id_iddonvi_iddoi_nhan', $arrListdoi)
                    ->orWhere('idcanbonhan', $current_idcanbo)
                    ->orWhere('idcanbo_creater', $current_idcanbo);
                })
                ->select('tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
                ->orderBy('idcongviec', 'DESC')
                ->paginate(10, ['tbl_congviec.id']);
                
            }
            else
            {
                $data['list_congviec'] = DB::table( 'tbl_congviec' )
                ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
                ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
                ->whereRaw('tbl_congviec_chuyentiep.id = (SELECT max(id) FROM tbl_congviec_chuyentiep WHERE tbl_congviec_chuyentiep.idcongviec = tbl_congviec.id  ) ')
                ->where(function ($query) use ($current_idcanbo) {
                    $query->where('idcanbonhan', $current_idcanbo)
                    ->orWhere('idcanbo_creater', $current_idcanbo);
                })
                ->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
                ->orderBy('tbl_congviec.id', 'DESC')
                ->paginate(10, ['tbl_congviec.id']);
            }
        }
        
        return view('congviec.index', $data);
    }

    
    public function create()
    {           
        // CongviecLibrary::checkPermissionCongviec( 'a', 1, 'http://google.com');
        $current_iddonvi =  UserLibrary::getIdDonViOfCanBo( Session::get('userinfo')->idcanbo );
        $data['page_name'] = "Thêm mới công việc";
        $data['list_lanhdao'] = UserLibrary::getListLanhDaoOfDonVi( $current_iddonvi );
        return view('congviec.create', $data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'sotailieu' => 'required',
            'sotailieu' => 'required',
            'trichyeu' => 'required',
            'idcanbonhan' => 'required',
            'hancongviec' => 'required',

        ], $this->messages_validate);

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $dataCongViec = array(
            'idcanbo_creater' => Session::get('userinfo')->idcanbo,
            'id_iddonvi_iddoi_creater' => UserLibrary::getIdDonviIdDoiOfCanBo( Session::get('userinfo')->idcanbo, 'value' ),
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
            'id_iddonvi_iddoi_nhan' => UserLibrary::getIdDonviIddoiLanhdaoOfDonVi( UserLibrary::getIdDonViOfCanBo( Session::get('userinfo')->idcanbo ) ),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'order' => 0,
            'ghichu' => $request->ghichu,
        );
        DB::table('tbl_congviec_chuyentiep')->insert( $dataCongViecChuyentiep );
        CongviecLibrary::logCongviec($request, $idcongviec, Session::get('userinfo')->username.' thêm công việc '.$idcongviec.' - '.$request->sotailieu );
        return response()->json(['success' => 'Thêm công việc thành công ', 'url' => route('cong-viec.index')]);
    }

    public function edit($idcongviec)
    {
        if( CongviecLibrary::checkPermissionCongviec($idcongviec, Session::get('userinfo')->iduser, Session::get('userinfo')->idcanbo, 'edit' ) == FALSE )
        {
            $message = array('type' => 'error', 'content' => 'Bạn không có quyền ở đây');
            return redirect()->route('cong-viec.index')->with('alert_message', $message);
        }
        $current_iddonvi =  UserLibrary::getIdDonViOfCanBo( Session::get('userinfo')->idcanbo ); 
        $data['page_name'] = "Sửa công việc";
        $data['list_lanhdao'] = UserLibrary::getListLanhDaoOfDonVi( $current_iddonvi );
        $data['congviec_info'] = DB::table('tbl_congviec')->where('id',$idcongviec)->first();
        $data['idcanboxulybandau'] = CongviecLibrary::getIdCanboXulybandau( $idcongviec );
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
            'idstatus' => 'required',

        ], $this->messages_validate);

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
        CongviecLibrary::logCongviec($request, $idcongviec, Session::get('userinfo')->username.' sửa công việc '.$idcongviec.' - '.$request->sotailieu );
        return response()->json(['success' => 'Thêm công việc thành công ', 'url' => route('cong-viec.index')]);
    }

    public function show($idcongviec)
    {
        $data['page_name'] = "Chi tiết công việc";
        $data['congviec_info'] = CongviecLibrary::getCongviecInfo( $idcongviec );
        $data['congviec_chuyentiep_info'] = CongviecLibrary::getCongviecChuyentiepInfo( $idcongviec );
        $data['maxNodeCongViec'] = CongviecLibrary::getMaxNode( $idcongviec );
        return view('congviec.show', $data);
    }

    public function chuyentiep($idcongviec)
    {
        $data['page_name'] = "Chuyển công việc";
        $data['congviec_info'] = CongviecLibrary::getCongviecInfo( $idcongviec );
        $current_iddonvi =  UserLibrary::getIdDonViOfCanBo( Session::get('userinfo')->idcanbo );
        $data['list_doicongtac'] = UserLibrary::getListDoidonVi($current_iddonvi, 'object');
        $data['congviec_chuyentiep_info'] = CongviecLibrary::getCongviecChuyentiepInfo( $idcongviec );
        return view('congviec.chuyentiep', $data);
    }

    public function postChuyentiep(Request $request, $idcongviec)
    {
        $validator = Validator::make($request->all(), [
                'id_iddonvi_iddoi' => 'required',
                'idcanbonhan' => 'required',
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
        CongviecLibrary::logCongviec($request, $idcongviec, Session::get('userinfo')->username.' chuyển tiếp công việc '.$idcongviec.' cho: '.$request->idcanbonhan. ' - id_iddonvi_iddoi: '.$request->id_iddonvi_iddoi );
        return response()->json(['success' => 'Chuyển tiếp công việc thành công ', 'url' => route('get-show-cong-viec', $idcongviec)]);        
    }

    public function delete($idcongviec)
    {
        $data['page_name'] = "Chi tiết công việc";
        $data['congviec_info'] = CongviecLibrary::getCongviecInfo( $idcongviec );
        $data['congviec_chuyentiep_info'] = CongviecLibrary::getCongviecChuyentiepInfo( $idcongviec );
        return view('congviec.delete', $data);
    }

    public function destroy(Request $request, $idcongviec)
    {
        DB::table('tbl_congviec_chuyentiep')->where('idcongviec', $idcongviec)->delete();
        DB::table('tbl_congviec')->where('id', $idcongviec)->delete();
        CongviecLibrary::logCongviec($request, $idcongviec, Session::get('userinfo')->username.' xóa công việc '.$idcongviec );
        return redirect()->route('cong-viec.index');
    }

    public function deleteNodeChuyentiep(Request $request, $idnode )
    {
        $congviec_node_info = DB::table('tbl_congviec_chuyentiep')->where('id',$idnode)->select('idcongviec', 'idcanbonhan', 'id_iddonvi_iddoi_nhan', 'order')->first();
        DB::table('tbl_congviec_chuyentiep')->where('id', $idnode)->delete();
        CongviecLibrary::logCongviec($request, $congviec_node_info->idcongviec, Session::get('userinfo')->username.' xóa node công việc '.$congviec_node_info->idcongviec.' - của cán bộ nhận: '.$congviec_node_info->idcanbonhan.' - id_iddonvo_iddoi_nhan: '.$congviec_node_info->id_iddonvi_iddoi_nhan );
        if( $congviec_node_info->order && $congviec_node_info->order == 0 )
        {
            DB::table('tbl_congviec_chuyentiep')->where('idcongviec', $congviec_node_info->idcongviec)->delete();
            DB::table('tbl_congviec')->where('id', $congviec_node_info->idcongviec)->delete();
            CongviecLibrary::logCongviec($request, $congviec_node_info->idcongviec, Session::get('userinfo')->username.' xóa công việc '.$congviec_node_info->idcongviec );
            
            return redirect()->route('cong-viec.index');
        }
        else
        {
            return redirect()->route('get-show-cong-viec', $congviec_node_info->idcongviec);
        }
    }

    public function toggle_congviec_status(Request $request, $idcongviec)
    {
        $current_status = DB::table('tbl_congviec')->where('id',$idcongviec)->value('idstatus');
        $data_update = array(
            'idstatus' => ($current_status == 1) ? 2 : 1
        );
        DB::table('tbl_congviec')->where('id',$idcongviec)->update($data_update);
        $data_message = array('alert_message' => ['type' => 'success', 'content' => 'Cập nhật trạng thái công việc thành công']);
        CongviecLibrary::logCongviec($request, $idcongviec, Session::get('userinfo')->username.' thay đổi trạng thái công việc '.$idcongviec. ' từ '.$current_status. ' sang '. $data_update["idstatus"] );
        return redirect()->route('cong-viec.index')->with($data_message);
    }

    // public function checkPermission($idcongviec)
    // {

        
    //     $owner_congviec = CongviecLibrary::getCongviecOwner($idcongviec);
    // }

}
