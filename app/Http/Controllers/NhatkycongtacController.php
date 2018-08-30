<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Session;
// use App\UserApp\CongviecLibrary;
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
            return response()->json(['html' => view('nhatkycongtac.nhatkycanbo_table', $data)->render()]);
        }
        else
        {
            $data['list_nhatky'] = NhatkycongtacLibrary::getListNhatkycanbo( $idcanbo, array(), 15);
        }



        return view('nhatkycongtac.nhatkycanbo_index', $data);
    }

    public function nhatkycanbo_create($ngaynhatky = NULL)
    {
        $data['page_name'] = 'Thêm nhật ký công tác cán bộ';
        if( $ngaynhatky != NULL && NhatkycongtacLibrary::checkMyDateDmY($ngaynhatky) ) $data['ngay'] = $ngaynhatky;
        return view('nhatkycongtac.nhatkycanbo_create', $data);
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
        return response()->json(['success' => 'Thêm nhật ký cán bộ thành công ', 'url' => route('nhat-ky-cong-tac.index')]);
    }

    public function nhatkycanbo_edit($idnhatky)
    {
        $data['page_name'] = 'Sửa nhật ký cán bộ';
        $data['nhatky_info'] = NhatkycongtacLibrary::getNhatkyCBInfo($idnhatky);
        $data['idnhatky'] = $idnhatky;
        return view('nhatkycongtac.nhatkycanbo_edit', $data);
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
        $idcanbo = Session::get('userinfo')->idcanbo;
        $id_iddonvi_iddoi = UserLibrary::getIdDonviIdDoiOfCanBo( $idcanbo, 'value' );
        if( $request->ajax() )
        {
            $arrWhere = NhatkycongtacLibrary::processArrWhereNhatkyDoiIndex( $request );
            $data['list_nhatkydoi'] = NhatkycongtacLibrary::getListNhatkyDoi( $id_iddonvi_iddoi, $arrWhere, 15 );
            return response()->json(['html' => view('nhatkycongtac.nhatkydoi_table', $data)->render()]);
        }
        else
        {
            $data['list_nhatkydoi'] = NhatkycongtacLibrary::getListNhatkyDoi( $id_iddonvi_iddoi, array(), 15 );
        }
        return view('nhatkycongtac.nhatkydoi_index', $data);
    }

    public function nhatkydoi_create($ngaynhatky = NULL)
    {
        $data['page_name'] = 'Thêm nhật ký công tác đội';
        return view('nhatkycongtac.nhatkydoi_create', $data);
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

        if ( date('w', $int_ngaydautuan) != 1 && ( $int_ngaycuoituan - $int_ngaydautuan ) != 518400)    //  Từ thứ 2 đến CN có 6 bước nhảy 518400 = 6*86400
        {
            return response()->json(['error' => array('Chọn ngày đầu tuần (Thứ 2), ngày cuối tuần (Chủ nhật) và chỉ được chọn 01 tuần')]);
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
        return view('nhatkycongtac.nhatkydoi_edit', $data);
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

    
}
