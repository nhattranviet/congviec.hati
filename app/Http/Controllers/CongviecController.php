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
        $current_idcanbo = Session::get('userinfo')->idcanbo;
        $current_iduser = Session::get('userinfo')->iduser;
        $current_idrole = UserLibrary::getIdRoleUser( $current_iduser );
        if( $current_idrole == config('user_config.idnhomquyen_capphodonvi') || $current_idrole == config('user_config.idnhomquyen_captruongdonvi') )   // lãnh đạo đơn vị
        {
            $data['list_doicongtac'] = UserLibrary::getListDoiLanhdaoQuanly($current_idcanbo, 'object');
        }
        else
        {
            $data['list_doicongtac'] = UserLibrary::getIdDonviIdDoiofCanBo( $current_idcanbo, 'object' );
        }
        $arrListdoi = array();
        foreach ($data['list_doicongtac'] as $value) {
            $arrListdoi[] = $value->id;
        }
        $index_role_info = CongviecLibrary::getUserMethodRoleInfo( Session::get('userinfo')->iduser, 'index' );
        if( $request->ajax() )      //Begin ajax
        {
            $arrWhere = CongviecLibrary::processArrWhereCongviec($request);
            if($request->id_iddonvi_iddoi != NULL)
            {
                $arrListdoi = array($request->id_iddonvi_iddoi);
                $arrWhere[] = array('tbl_congviec_chuyentiep.id_iddonvi_iddoi_nhan', '=', $request->id_iddonvi_iddoi );
            }

            if( $index_role_info->keyword == 'idcanbo' )    //Get job for canbo role
            {
                $data['list_congviec'] = CongviecLibrary::getCongviecOfCanbo( $request, Session::get('userinfo')->idcanbo, 20, $arrWhere );
            }
            elseif( $index_role_info->keyword == 'id_iddonvi_iddoi' )   //Get job for id_iddonvi_iddoi role
            {   
                $data['list_congviec'] = $data['list_congviec'] = CongviecLibrary::getCongviecOfDoiPhuTrach($request, $current_idcanbo, $arrListdoi, 20, $arrWhere);
            }
            else{
                return view('errors.403');
            }
            return response()->json(['html' => view('congviec.congviec_table', $data)->render()]);
        }   //End Ajax
        else
        {
            if( $index_role_info->keyword == 'idcanbo' )
            {
                $data['list_congviec'] = CongviecLibrary::getCongviecOfCanbo( $request, Session::get('userinfo')->idcanbo, 20 );
                $data['list_congviec_quahan'] = CongviecLibrary::getCongviecOfCanboQuahan( Session::get('userinfo')->idcanbo );
            }
            elseif( $index_role_info->keyword == 'id_iddonvi_iddoi' )
            {   
                $data['list_congviec'] = $data['list_congviec'] = CongviecLibrary::getCongviecOfDoiPhuTrach($request, $current_idcanbo, $arrListdoi, 20);
                $data['list_congviec_quahan'] = CongviecLibrary::getCongviecOfDoiPhuTrachQuahan(Session::get('userinfo')->idcanbo, $arrListdoi);
            }
            else{
                return view('errors.403');
            }
        }
        return view('congviec.index', $data);
    }
    
    public function create()
    {
        $current_iddonvi =  UserLibrary::getIdDonViOfCanBo( Session::get('userinfo')->idcanbo );
        $data['page_name'] = "Thêm mới công việc";
        $data['list_lanhdao'] = UserLibrary::getListLanhDaoOfDonVi( $current_iddonvi );
        return view('congviec.create', $data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
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
        if( CongviecLibrary::checkPermissionCongviec($idcongviec, Session::get('userinfo')->iduser, Session::get('userinfo')->idcanbo, 'edit' ) == FALSE )
        {
            $message = array('type' => 'error', 'content' => 'Bạn không có quyền ở đây');
            return redirect()->route('cong-viec.index')->with('alert_message', $message);
        }
         $validator = Validator::make($request->all(), [
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
        if( CongviecLibrary::checkPermissionCongviec($idcongviec, Session::get('userinfo')->iduser, Session::get('userinfo')->idcanbo, 'edit' ) == FALSE )
        {
            $message = array('type' => 'error', 'content' => 'Bạn không có quyền ở đây');
            return redirect()->route('cong-viec.index')->with('alert_message', $message);
        }

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
        if( CongviecLibrary::checkPermissionCongviec($idcongviec, Session::get('userinfo')->iduser, Session::get('userinfo')->idcanbo, 'edit' ) == FALSE )
        {
            $message = array('type' => 'error', 'content' => 'Bạn không có quyền ở đây');
            return redirect()->route('cong-viec.index')->with('alert_message', $message);
        }
        $data['page_name'] = "Chi tiết công việc";
        $data['congviec_info'] = CongviecLibrary::getCongviecInfo( $idcongviec );
        $data['congviec_chuyentiep_info'] = CongviecLibrary::getCongviecChuyentiepInfo( $idcongviec );
        return view('congviec.delete', $data);
    }

    public function destroy(Request $request, $idcongviec)
    {
        if( CongviecLibrary::checkPermissionCongviec($idcongviec, Session::get('userinfo')->iduser, Session::get('userinfo')->idcanbo, 'edit' ) == FALSE )
        {
            $message = array('type' => 'error', 'content' => 'Bạn không có quyền ở đây');
            return redirect()->route('cong-viec.index')->with('alert_message', $message);
        }
        DB::table('tbl_congviec_chuyentiep')->where('idcongviec', $idcongviec)->delete();
        DB::table('tbl_congviec')->where('id', $idcongviec)->delete();
        CongviecLibrary::logCongviec($request, $idcongviec, Session::get('userinfo')->username.' xóa công việc '.$idcongviec );
        return redirect()->route('cong-viec.index');
    }

    public function deleteNodeChuyentiep(Request $request, $idnode )
    {
        $congviec_node_info = DB::table('tbl_congviec_chuyentiep')->where('id',$idnode)->select('idcongviec', 'idcanbonhan', 'id_iddonvi_iddoi_nhan', 'order')->first();
        if( CongviecLibrary::checkPermissionCongviec($congviec_node_info->idcongviec, Session::get('userinfo')->iduser, Session::get('userinfo')->idcanbo, 'edit' ) == FALSE )
        {
            $message = array('type' => 'error', 'content' => 'Bạn không có quyền ở đây');
            return redirect()->route('cong-viec.index')->with('alert_message', $message);
        }
        
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
        if( CongviecLibrary::checkPermissionCongviec($idcongviec, Session::get('userinfo')->iduser, Session::get('userinfo')->idcanbo, 'edit' ) == FALSE )
        {
            $message = array('type' => 'error', 'content' => 'Bạn không có quyền ở đây');
            return redirect()->route('cong-viec.index')->with('alert_message', $message);
        }
        $current_status = DB::table('tbl_congviec')->where('id',$idcongviec)->value('idstatus');
        $data_update = array(
            'idstatus' => ($current_status == 1) ? 2 : 1
        );
        DB::table('tbl_congviec')->where('id',$idcongviec)->update($data_update);
        $data_message = array('alert_message' => ['type' => 'success', 'content' => 'Cập nhật trạng thái công việc thành công']);
        CongviecLibrary::logCongviec($request, $idcongviec, Session::get('userinfo')->username.' thay đổi trạng thái công việc '.$idcongviec. ' từ '.$current_status. ' sang '. $data_update["idstatus"] );
        return redirect()->route('cong-viec.index')->with($data_message);
    }

    public function forgetSessionCheckModal()
    {
        if( Session::has('showQuahanModal') ) Session::forget('showQuahanModal');
    }

}
