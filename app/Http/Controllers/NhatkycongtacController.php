<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Session;
use App\UserApp\CanboLibrary;
use App\UserApp\UserLibrary;
use App\UserApp\NhatkycongtacLibrary;
use Illuminate\Support\Facades\Redirect;

class NhatkycongtacController extends Controller
{
    public function nhatkycanbo_index(Request $request)
    {
        $idcanbo = Session::get('userinfo')->idcanbo;
        if( $request->ajax() )
        {
            $arrWhere = NhatkycongtacLibrary::processArrWhereNhatkycanboIndex( $request );
            $data['list_nhatky'] = NhatkycongtacLibrary::getListNhatkycanbo( $idcanbo, $arrWhere, 15);
            return response()->json(['html' => view('cahtcore.nhatkycongtac.nhatkycanbo_table', $data)->render()]);
        }
        else
        {
            $data['list_nhatky'] = NhatkycongtacLibrary::getListNhatkycanbo( $idcanbo, array(), 15);
        }
        

        $data['page_name'] = 'Quản lý nhật ký cán bộ';
        return view('cahtcore.nhatkycongtac.nhatkycanbo_index', $data);
    }

    public function nhatkycanbo_create($ngaynhatky = NULL)
    {
        $data['page_name'] = 'Thêm nhật ký công tác cán bộ';
        if( $ngaynhatky != NULL && NhatkycongtacLibrary::checkMyDateDmY($ngaynhatky) ) $data['ngay'] = $ngaynhatky;
        return view('cahtcore.nhatkycongtac.nhatkycanbo_create', $data);
    }

    public function nhatkycanbo_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ngay' => 'required|date_format:d-m-Y',
            'noidungdukien' => 'required',

        ], NhatkycongtacLibrary::getNhatkycongtacMessage() );

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }
        $ngay = date('Y-m-d', strtotime( $request->ngay ));
        $idcanbo = Session::get('userinfo')->idcanbo;

        if(NhatkycongtacLibrary::checkNhatkycanboExist( $idcanbo, $ngay) == TRUE )
        {
            return response()->json(['error' => array('Nhật ký ngày '.$request->ngay.' của bạn đã tồn tại trong hệ thống. Chọn sửa thay vì thêm mới')]);
        }

        $data_nhatkycb = array(
            'idcanbo' => $idcanbo,
            'id_iddonvi_iddoi' => UserLibrary::getIdDonviIdDoiOfCanBo( $idcanbo, 'value' ),
            'ngay' => $ngay,
            'noidungdukien' => $request->noidungdukien,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );
        DB::table('tbl_nhatkycanbo')->insert( $data_nhatkycb );
        return response()->json(['success' => 'Thêm nhật ký cán bộ thành công ', 'url' => route('nhat-ky-cong-tac-cb.index')]);
    }

    public function nhatkycanbo_edit($idnhatky)
    {
        $data['page_name'] = 'Sửa nhật ký cán bộ';
        $data['nhatky_info'] = NhatkycongtacLibrary::getNhatkyCBInfo($idnhatky);
        $data['idnhatky'] = $idnhatky;
        return view('cahtcore.nhatkycongtac.nhatkycanbo_edit', $data);
    }

    public function nhatkycanbo_update(Request $request, $idnhatky)
    {
        $validator = Validator::make($request->all(), [
            'noidungdukien' => 'required',
        ], NhatkycongtacLibrary::getNhatkycongtacMessage() );

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $data_nhatkycb = array(
            'noidungdukien' => $request->noidungdukien,
            'ketquathuchien' => $request->ketquathuchien,
            'updated_at' => Carbon::now()
        );
        DB::table('tbl_nhatkycanbo')->where('id', $idnhatky)->update( $data_nhatkycb );
        return response()->json(['success' => 'Cập nhật nhật ký cán bộ thành công ', 'url' => route('nhat-ky-cong-tac-cb.index')]);
    }

    public function nhatkycanbo_delete($idnhatky)
    {
        DB::table('tbl_nhatkycanbo')->where('id', $idnhatky)->delete();
        $message = array('type' => 'success', 'content' => 'Xóa nhật ký cán bộ thành công');
        return redirect()->route('nhat-ky-cong-tac-cb.index')->with('alert_message', $message);
    }

    //---------------------NHẬT KÝ ĐỘI-----------------------------------
    public function nhatkydoi_index(Request $request)
    {
        if(Session::get('userinfo')->idnhomquyen == config('user_config.idnhomquyen_canbo'))
        {
            $message = array('type' => 'error', 'content' => 'Bạn không có quyền ở đây');
            return redirect()->route('nhat-ky-cong-tac-cb.index')->with('alert_message', $message);
        }
        $idcanbo = Session::get('userinfo')->idcanbo;
        $id_iddonvi_iddoi = UserLibrary::getIdDonviIdDoiOfCanBo( $idcanbo, 'value' );
        if( $request->ajax() )
        {
            $arrWhere = NhatkycongtacLibrary::processArrWhereNhatkyDoiIndex( $request );
            $data['list_nhatkydoi'] = NhatkycongtacLibrary::getListNhatkyDoi( $id_iddonvi_iddoi, $arrWhere, 15 );
            return response()->json(['html' => view('cahtcore.nhatkycongtac.nhatkydoi_table', $data)->render()]);
        }
        else
        {
            $data['list_nhatkydoi'] = NhatkycongtacLibrary::getListNhatkyDoi( $id_iddonvi_iddoi, array(), 15 );
        }
        $data['page_name'] = 'Quản lý nhật ký đội';
        return view('cahtcore.nhatkycongtac.nhatkydoi_index', $data);
    }

    public function nhatkydoi_create($ngaynhatky = NULL)
    {
        $data['page_name'] = 'Thêm nhật ký công tác đội';
        return view('cahtcore.nhatkycongtac.nhatkydoi_create', $data);
    }

    public function nhatkydoi_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tuan' => 'required',
            'noidungdukien' => 'required',
        ], NhatkycongtacLibrary::getNhatkycongtacMessage() );

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $ngaudautuan_cuoituan = explode(' - ', $request->tuan);
        if( $ngaudautuan_cuoituan[0] == 'Invalid date' || $ngaudautuan_cuoituan[1] == 'Invalid date' || NhatkycongtacLibrary::checkMyDateDmY($ngaudautuan_cuoituan[0]) == FALSE || NhatkycongtacLibrary::checkMyDateDmY($ngaudautuan_cuoituan[1]) == FALSE )
        {
            return response()->json(['error' => array('Định dạng ngày đầu tuần hoặc cuối tuần sai, kiểm tra lại')]);
        }
        $int_ngaydautuan = strtotime( $ngaudautuan_cuoituan[0] );
        $int_ngaycuoituan = strtotime( $ngaudautuan_cuoituan[1] );
        $Y_m_d_ngaydautuan = date( 'Y-m-d', $int_ngaydautuan );
        $Y_m_d_ngaycuoituan = date( 'Y-m-d', $int_ngaycuoituan );

        if ( date('w', $int_ngaydautuan) != 1 || ( $int_ngaycuoituan - $int_ngaydautuan ) != 518400)    //  Từ thứ 2 đến CN có 6 bước nhảy 518400 = 6*86400
        {
            return response()->json(['error' => array('Chọn ngày đầu tuần (Thứ 2), ngày cuối tuần (Chủ nhật) và mỗi lần được chọn 01 tuần')]);
        }
        $idcanbo = Session::get('userinfo')->idcanbo;
        $id_iddonvi_iddoi = UserLibrary::getIdDonviIdDoiOfCanBo( $idcanbo, 'value' );
        if(NhatkycongtacLibrary::checkNhatkyDoiExist( $id_iddonvi_iddoi, $Y_m_d_ngaydautuan) == TRUE )
        {
            return response()->json(['error' => array('Nhật ký tuần từ '.$ngaudautuan_cuoituan[0].' đến '.$ngaudautuan_cuoituan[1].' của bạn đã tồn tại trong hệ thống. Chọn sửa thay vì thêm mới!')]);
        }
        
        $data_nhatkydoi = array(
            'idcanbo_creater' => $idcanbo,
            'id_iddonvi_iddoi' => $id_iddonvi_iddoi,
            'ngaydautuan' => $Y_m_d_ngaydautuan,
            'ngaycuoituan' => $Y_m_d_ngaycuoituan,
            'noidungdukien' => $request->noidungdukien,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );

        DB::table('tbl_nhatkydoi')->insert( $data_nhatkydoi );
        return response()->json(['success' => 'Thêm nhật ký đội thành công ', 'url' => route('nhat-ky-cong-tac-doi.index')]);
    }

    public function nhatkydoi_edit($idnhatkydoi)
    {
        $data['page_name'] = 'Sửa nhật ký đội';
        $data['nhatkydoi_info'] = NhatkycongtacLibrary::getNhatkyDoiInfo($idnhatkydoi);
        $data['idnhatkydoi'] = $idnhatkydoi;
        return view('cahtcore.nhatkycongtac.nhatkydoi_edit', $data);
    }

    public function nhatkydoi_update(Request $request, $idnhatkydoi)
    {
        $validator = Validator::make($request->all(), [
            'noidungdukien' => 'required',
        ], NhatkycongtacLibrary::getNhatkycongtacMessage() );

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $data_nhatkydoi = array(
            'noidungdukien' => $request->noidungdukien,
            'ketquathuchien' => $request->ketquathuchien,
            'updated_at' => Carbon::now()
        );
        DB::table('tbl_nhatkydoi')->where('id', $idnhatkydoi)->update( $data_nhatkydoi );
        return response()->json(['success' => 'Cập nhật nhật ký đội thành công ', 'url' => route('nhat-ky-cong-tac-doi.index')]);
    }

    public function nhatkydoi_delete($idnhatkydoi)
    {
        DB::table('tbl_nhatkydoi')->where('id', $idnhatkydoi)->delete();
        $message = array('type' => 'success', 'content' => 'Xóa nhật ký đội thành công');
        return redirect()->route('nhat-ky-cong-tac-doi.index')->with('alert_message', $message);
    }

    //-----------------------------THEO DÕI NHẬT KÝ------------------------------------

    public function theodoinhatky(Request $request)
    {
        if(Session::get('userinfo')->idnhomquyen == config('user_config.idnhomquyen_canbo'))
        {
            $message = array('type' => 'error', 'content' => 'Bạn không có quyền ở đây');
            return redirect()->route('nhat-ky-cong-tac-cb.index')->with('alert_message', $message);
        }
        $data['tungay'] = date('Y-m-d', strtotime(date('Y-m-d', time()). ' - 1 months'));
        $data['denngay'] = date('Y-m-d', strtotime(date('Y-m-d', time())));
        $data['page_name'] = 'Theo dõi nhật ký';
        $arrWhere = NhatkycongtacLibrary::processArrWhereTheodoinhatky( $data['tungay'], $data['denngay'], $request );
        $current_idcanbo = Session::get('userinfo')->idcanbo;
        $current_iduser = Session::get('userinfo')->iduser;
        $current_idrole = UserLibrary::getIdRoleUser( $current_iduser );
        $data['list_doicongtac'] = [];
        if( $current_idrole == config('user_config.idnhomquyen_capphodonvi') || $current_idrole == config('user_config.idnhomquyen_captruongdonvi') )   // lãnh đạo đơn vị
        {
            $data['list_doicongtac'] = UserLibrary::getListDoiLanhdaoQuanly($current_idcanbo, 'object');
        }
        elseif( $current_idrole == config('user_config.idnhomquyen_doitruong') )
        {
            $data['list_doicongtac'] = UserLibrary::getListDoiCanBo($current_idcanbo, 'object');
        }
        if(count($data['list_doicongtac']) == 0)
        {
            $message = array('type' => 'error', 'content' => 'Bạn là Lãnh đạo đơn vị nhưng chưa được thiết lập trong phần mềm phụ trách đội nào, liên hệ quản trị viên');
            return redirect()->route('nhat-ky-cong-tac-cb.index')->with('alert_message', $message);
        }
        $data['default_id_iddonvi_iddoi'] = ($request->id_iddonvi_iddoi != NULL) ? $request->id_iddonvi_iddoi : $data['list_doicongtac'][0]->id;
        $data['list_nhatkydoi'] = NhatkycongtacLibrary::getFullListNhatkyDoi( $data['default_id_iddonvi_iddoi'], $arrWhere['nhatkydoi'] );
        $data['list_canbo_nhatky'] = NhatkycongtacLibrary::formatNhatkycanboInDoi( NhatkycongtacLibrary::getFullListNhatkycanboInDoi( $data['default_id_iddonvi_iddoi'], $arrWhere['nhatkycanbo'] ) ) ;
        if( $request->ajax() )
        {
            return response()->json(['html' => view('cahtcore.nhatkycongtac.theodoinhatky_content', $data)->render()]);
        }
         
        return view('cahtcore.nhatkycongtac.theodoinhatky', $data);
    }

    public function multiDuyetNhatky(Request $request)
    {
        $list_nhatkydoi = $request->nhatkydoi;
        $list_nhatkycanbo = $request->nhatkycanbo;
        $id_status = $request->id_status;
        if($id_status == NULL) return response()->json(['error' => array('Trạng thái phải được chọn')]);
        if($list_nhatkydoi == NULL && $list_nhatkycanbo == NULL) return response()->json([ 'error' => array( 'Nhật ký cán bộ hoặc Nhật ký đội phải được chọn' ) ]);
        
        if( $list_nhatkydoi != NULL )
        {
            foreach ($list_nhatkydoi as $value)
            {
                $data_update = array(
                    'nhatky_status' => $id_status
                );
                DB::table('tbl_nhatkydoi')->where('id', $value)->update( $data_update );
            }
        }

        if( $list_nhatkycanbo != NULL )
        {
            foreach ($list_nhatkycanbo as $value)
            {
                DB::table('tbl_nhatkycanbo')->where('id', $value)->update( ['nhatky_status' => $id_status] );
            }
        }
        $arrWhere = NhatkycongtacLibrary::processArrWhereTheodoinhatky( NULL, NULL, $request );
        $data['default_id_iddonvi_iddoi'] = $request->id_iddonvi_iddoi;
        $data['list_nhatkydoi'] = NhatkycongtacLibrary::getFullListNhatkyDoi( $data['default_id_iddonvi_iddoi'], $arrWhere['nhatkydoi'] );
        $data['list_canbo_nhatky'] = NhatkycongtacLibrary::formatNhatkycanboInDoi( NhatkycongtacLibrary::getFullListNhatkycanboInDoi( $data['default_id_iddonvi_iddoi'], $arrWhere['nhatkycanbo'] ) ) ;
        return response()->json(['html' => view('cahtcore.nhatkycongtac.theodoinhatky_content', $data)->render()]);
    }

    //-----------------------------REPORT---------------------------------------------
    public function report_nhatkycanbo_gate_check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tungay' => 'required',
            'denngay' => 'required',
        ], NhatkycongtacLibrary::getNhatkycongtacMessage() );

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }
        $idcanbo = Session::get('userinfo')->idcanbo;
        $iddonvi = Session::get('userinfo')->iddonvi;
        $tungay = date('Y-m-d', strtotime($request->tungay));
        $denngay = date('Y-m-d', strtotime($request->denngay));
        $id_iddonvi_iddoi = ($request->id_iddonvi_iddoi) ? $request->id_iddonvi_iddoi : UserLibrary::getIdDonviIdDoiOfCanBo( $idcanbo, 'value' );
        
        if($request->redirect_type == 'report_nhatkycanbo')
        {
            return response()->json([ 'message' => 'Đang trích xuất dữ liệu', 'url' => '/nhat-ky-cong-tac/report-nhat-ky-canbo/'.$idcanbo.'/'.$tungay.'/'.$denngay, 'type' => 'info', 'show_alert' => TRUE]);
        }
        elseif($request->redirect_type == 'thongke_nhatkycanbo'){
            return response()->json([ 'message' => 'Đang trích xuất dữ liệu', 'url' => '/nhat-ky-cong-tac/thong-ke-nhat-ky-canbo/'.$idcanbo.'/'.$tungay.'/'.$denngay, 'type' => 'info', 'show_alert' => TRUE]);
        }
        elseif($request->redirect_type == 'report_nhatkydoi'){
            return response()->json([ 'message' => 'Đang trích xuất dữ liệu', 'url' => '/nhat-ky-cong-tac/report-nhat-ky-doi/'.$id_iddonvi_iddoi.'/'.$tungay.'/'.$denngay, 'type' => 'info', 'show_alert' => TRUE]);
        }
        elseif($request->redirect_type == 'thongke_nhatkydoi'){
            return response()->json([ 'message' => 'Đang trích xuất dữ liệu', 'url' => '/nhat-ky-cong-tac/thong-ke-nhat-ky-doi/'.$id_iddonvi_iddoi.'/'.$tungay.'/'.$denngay, 'type' => 'info', 'show_alert' => TRUE]);
        }
        elseif($request->redirect_type == 'thongketheodoi_nhatkycanbo'){
            return response()->json([ 'message' => 'Đang trích xuất dữ liệu', 'url' => '/nhat-ky-cong-tac/thong-ke-theo-Doi-nhat-ky-canbo/'.$id_iddonvi_iddoi.'/'.$tungay.'/'.$denngay, 'type' => 'info', 'show_alert' => TRUE]);
        }
        elseif($request->redirect_type == 'thongketheodonvi_nhatkycanbo'){
            return response()->json([ 'message' => 'Đang trích xuất dữ liệu', 'url' => '/nhat-ky-cong-tac/thong-ke-theo-Donvi-nhat-ky-canbo/'.$iddonvi.'/'.$tungay.'/'.$denngay, 'type' => 'info', 'show_alert' => TRUE]);
        }
        
    }

    public function report_nhatkycanbo($idcanbo, $tungay, $denngay)
    {
        $data['day_name'] = array( '1' => 'Thứ hai', '2' => 'Thứ ba', '3' => 'Thứ tư', '4' => 'Thứ năm', '5' => 'Thứ sáu', '6' => 'Thứ bảy', '0' => 'Chủ nhật');
        $data['tungay_ngaydautuan_cuoituan'] = UserLibrary::getNgayDauTuan_Cuoituan_Of_a_Day_Y_m_d($tungay);
        $data['denngay_ngaydautuan_cuoituan'] = UserLibrary::getNgayDauTuan_Cuoituan_Of_a_Day_Y_m_d($denngay);
        $nhatky_info = DB::table('tbl_nhatkycanbo')->where('idcanbo', $idcanbo)->whereDate('ngay', '>=', $data['tungay_ngaydautuan_cuoituan']['ngaydautuan'])->whereDate('ngay', '<=', $data['denngay_ngaydautuan_cuoituan']['ngaycuoituan'])->orderBy('ngay', 'ASC')->get();
        $data['nhatky_chuanhoa'] = [];
        foreach ($nhatky_info as $nhatky)
        {
            $data['nhatky_chuanhoa'][$nhatky->ngay] = $nhatky;
        }
        $list_ngay = UserLibrary::getListDayBettwenTwoDay_Y_m_d($data['tungay_ngaydautuan_cuoituan']['ngaydautuan'], $data['denngay_ngaydautuan_cuoituan']['ngaycuoituan']);
        $data['list_tuan'] = array_chunk($list_ngay, 7);
        $data['hoten'] = Session::get('userinfo')->hoten;
        $tungay_d_m_Y = date('d-m-Y', strtotime($tungay));
        $denngay_d_m_Y = date('d-m-Y', strtotime($denngay));
        $html_table = view('cahtcore.nhatkycongtac.view_report_nhatkycanbo', $data)->render();
        $str_for_doc = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=nhat-ky-can-bo ".$data['hoten']." tu ".$tungay_d_m_Y." den ".$denngay_d_m_Y.".doc");
        echo $str_for_doc;
    }

    public function thongke_nhatkycanbo($idcanbo, $tungay, $denngay)
    {
        $data['list_ngay_not_cuoituan'] = UserLibrary::getListDayBettwenTwoDay_Y_m_d($tungay, $denngay, FALSE);
        $data['list_ngay_full_nhatky_info'] = DB::table('tbl_nhatkycanbo')->where(array(['idcanbo', '=', $idcanbo], ['noidungdukien', '!=', NULL], ['ketquathuchien', '!=', NULL]))->whereDate('ngay', '>=', $tungay)->whereDate('ngay', '<=', $denngay)->pluck('ngay')->toArray();
        $data['ngaychuacapnhat'] = array_diff( $data['list_ngay_not_cuoituan'], $data['list_ngay_full_nhatky_info'] );
        
        $data['hoten'] = Session::get('userinfo')->hoten;
        $data['tungay_d_m_Y'] = date('d-m-Y', strtotime($tungay));
        $data['denngay_d_m_Y'] = date('d-m-Y', strtotime($denngay));
        $html_table = view('cahtcore.nhatkycongtac.thongke_nhatkycanbo', $data)->render();
        $str_for_doc = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=thong-ke-nhat-ky-can-bo ".$data['hoten']." tu ".$data['tungay_d_m_Y']." den ".$data['denngay_d_m_Y'].".doc");
        echo $str_for_doc;
    }

    public function thongketheoDoi_nhatkycanbo($id_iddonvi_iddoi, $tungay, $denngay)
    {
        $data['list_canbo'] = CanboLibrary::getListCanboOfDoi($id_iddonvi_iddoi);
        $data['list_ngay_not_cuoituan'] = UserLibrary::getListDayBettwenTwoDay_Y_m_d($tungay, $denngay, FALSE);
        $data['list_ngay_full_nhatky'] = DB::table('tbl_nhatkycanbo')->where(array(['id_iddonvi_iddoi', '=', $id_iddonvi_iddoi], ['noidungdukien', '!=', NULL], ['ketquathuchien', '!=', NULL]))->whereDate('ngay', '>=', $tungay)->whereDate('ngay', '<=', $denngay)->select('idcanbo', 'ngay')->get();
        $data['canbo_nhatky_chuanhoa'] = NhatkycongtacLibrary::chuanhoaNhatkycanbo($data['list_ngay_full_nhatky']);
        $data['tendoi'] = DB::table('tbl_doicongtac')->join('tbl_donvi_doi', 'tbl_donvi_doi.iddoi', '=', 'tbl_doicongtac.id' )->where('tbl_donvi_doi.id',$id_iddonvi_iddoi)->value('name');
        $data['tungay_d_m_Y'] = date('d-m-Y', strtotime($tungay));
        $data['denngay_d_m_Y'] = date('d-m-Y', strtotime($denngay));
        $html_table = view('cahtcore.nhatkycongtac.thongketheodoi_nhatkycanbo', $data)->render();
        $str_for_doc = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=thong-ke-nhat-ky-can-bo-doi ".$data['tendoi']." tu ".$data['tungay_d_m_Y']." den ".$data['denngay_d_m_Y'].".doc");
        echo $str_for_doc;
    }

    public function thongketheoDonvi_nhatkycanbo($iddonvi, $tungay, $denngay)
    {
        $data['tendonvi'] = DB::table('tbl_donvi')->where('id',$iddonvi)->value('name');
        $data['list_canbo_group_by_doi'] = NhatkycongtacLibrary::chuanhoaCanboGroupByDoi( CanboLibrary::getListCanboOfDonvi( $iddonvi, 'object', array(['tbl_donvi_doi.iddoi', '!=', config('user_config.id_doi_lanhdaodonvi')]) )); 
        $data['list_ngay_not_cuoituan'] = UserLibrary::getListDayBettwenTwoDay_Y_m_d($tungay, $denngay, FALSE);
        $data['list_ngay_full_nhatky'] = NhatkycongtacLibrary::getListNhatkyCanboOfDonvi($iddonvi, $tungay, $denngay);
        $data['canbo_nhatky_chuanhoa'] = NhatkycongtacLibrary::chuanhoaNhatkycanbo($data['list_ngay_full_nhatky']);
        $data['tungay_d_m_Y'] = date('d-m-Y', strtotime($tungay));
        $data['denngay_d_m_Y'] = date('d-m-Y', strtotime($denngay));
        $html_table = view('cahtcore.nhatkycongtac.thongketheodonvi_nhatkycanbo', $data)->render();
        $str_for_doc = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=thong-ke-nhat-ky-can-bo-doi ".$data['tendonvi']." tu ".$data['tungay_d_m_Y']." den ".$data['denngay_d_m_Y'].".doc");
        echo $str_for_doc;
    }

    public function report_nhatkytuan($id_iddonvi_iddoi, $tungay, $denngay)
    {
        $data['tendoi'] = DB::table('tbl_doicongtac')->join('tbl_donvi_doi', 'tbl_donvi_doi.iddoi', '=', 'tbl_doicongtac.id' )->where('tbl_donvi_doi.id',$id_iddonvi_iddoi)->value('name');
        $data['tungay_ngaydautuan_cuoituan'] = UserLibrary::getNgayDauTuan_Cuoituan_Of_a_Day_Y_m_d($tungay);
        $data['denngay_ngaydautuan_cuoituan'] = UserLibrary::getNgayDauTuan_Cuoituan_Of_a_Day_Y_m_d($denngay);
        $nhatky_info = DB::table('tbl_nhatkydoi')->where('id_iddonvi_iddoi', $id_iddonvi_iddoi)->whereDate('ngaydautuan', '>=', $data['tungay_ngaydautuan_cuoituan']['ngaydautuan'])->whereDate('ngaydautuan', '<=', $data['denngay_ngaydautuan_cuoituan']['ngaydautuan'])->orderBy('ngaydautuan', 'ASC')->get();
        $data['nhatky_chuanhoa'] = [];
        foreach ($nhatky_info as $nhatky)
        {
            $data['nhatky_chuanhoa'][$nhatky->ngaydautuan] = $nhatky;
        }
        $list_ngay = UserLibrary::getListDayBettwenTwoDay_Y_m_d($data['tungay_ngaydautuan_cuoituan']['ngaydautuan'], $data['denngay_ngaydautuan_cuoituan']['ngaycuoituan']);
        $data['list_tuan'] = array_chunk($list_ngay, 7);
        $tungay_d_m_Y = date('d-m-Y', strtotime($tungay));
        $denngay_d_m_Y = date('d-m-Y', strtotime($denngay));
        $html_table = view('cahtcore.nhatkycongtac.view_report_nhatkydoi', $data)->render();
        $str_for_doc = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=nhat-ky-doi ".$data['tendoi']." tu ".$tungay_d_m_Y." den ".$denngay_d_m_Y.".doc");
        echo $str_for_doc;
    }

    public function thongke_nhatkytuan($id_iddonvi_iddoi, $tungay, $denngay)
    {
        $data['tendoi'] = DB::table('tbl_doicongtac')->join('tbl_donvi_doi', 'tbl_donvi_doi.iddoi', '=', 'tbl_doicongtac.id' )->where('tbl_donvi_doi.id',$id_iddonvi_iddoi)->value('name');
        $data['tungay_ngaydautuan_cuoituan'] = UserLibrary::getNgayDauTuan_Cuoituan_Of_a_Day_Y_m_d($tungay);
        $data['denngay_ngaydautuan_cuoituan'] = UserLibrary::getNgayDauTuan_Cuoituan_Of_a_Day_Y_m_d($denngay);
        $data['list_day_full_nhatky_info'] = DB::table('tbl_nhatkydoi')->where(array(['id_iddonvi_iddoi', '=', $id_iddonvi_iddoi], ['noidungdukien', '!=', NULL], ['ketquathuchien', '!=', NULL]))->whereDate('ngaydautuan', '>=', $data['tungay_ngaydautuan_cuoituan']['ngaydautuan'])->whereDate('ngaydautuan', '<=', $data['denngay_ngaydautuan_cuoituan']['ngaydautuan'])->pluck('ngaydautuan')->toArray();
        $list_ngay = UserLibrary::getListDayBettwenTwoDay_Y_m_d($data['tungay_ngaydautuan_cuoituan']['ngaydautuan'], $data['denngay_ngaydautuan_cuoituan']['ngaycuoituan']);
        $data['list_Moday'] = UserLibrary::getDayInListDay_Y_m_d($list_ngay, 1);    //1 is value with attr w int of Monday
        $data['tuanchuacapnhat'] = array_diff($data['list_Moday'], $data['list_day_full_nhatky_info']);
        $tungay_d_m_Y = date('d-m-Y', strtotime($tungay));
        $denngay_d_m_Y = date('d-m-Y', strtotime($denngay));
        $html_table = view('cahtcore.nhatkycongtac.thongke_nhatkydoi', $data)->render();
        $str_for_doc = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=thong-ke-nhat-ky-doi ".$data['tendoi']." tu ".$tungay_d_m_Y." den ".$denngay_d_m_Y.".doc");
        echo $str_for_doc;
    }

    //------------------------------AJAX-------------------------------
    public function ajaxGetNhatkyCB($idnhatky)
    {
        $nhatky_info = DB::table('tbl_nhatkycanbo')->where('id', $idnhatky)->first();
        return response()->json($nhatky_info);
    }

    public function ajaxUpdateNhatkyCB(Request $request)
    {
        $idnhatky = $request->idnhatky;
        $dataUpdate = [
            'noidungdukien' => $request->noidungdukien,
            'ketquathuchien' => $request->ketquathuchien,
        ];
        $noidungdukien = $request->noidungdukien;
        $ketquathuchien = $request->ketquathuchien;
        DB::table('tbl_nhatkycanbo')->where('id', $idnhatky)->update($dataUpdate);
        return response()->json(['success' => 'Cập nhật thành công ']);
    }

    public function ajaxDeleteNhatkyCB(Request $request)
    {
        $idnhatky = $request->idnhatky;
        DB::table('tbl_nhatkycanbo')->where('id', $idnhatky)->delete();
        return response()->json(['success' => 'Xóa thành công ']);
    }

    public function ajaxUpdateNhatkyDoi(Request $request)
    {
        $idnhatky = $request->idnhatky;
        $dataUpdate = [
            'noidungdukien' => $request->noidungdukien,
            'ketquathuchien' => $request->ketquathuchien,
        ];
        $noidungdukien = $request->noidungdukien;
        $ketquathuchien = $request->ketquathuchien;
        DB::table('tbl_nhatkydoi')->where('id', $idnhatky)->update($dataUpdate);
        return response()->json(['success' => 'Cập nhật thành công ']);
    }

    public function ajaxDeleteNhatkyDoi(Request $request)
    {
        $idnhatky = $request->idnhatky;
        DB::table('tbl_nhatkydoi')->where('id', $idnhatky)->delete();
        return response()->json(['success' => 'Xóa thành công ']);
    }



}
