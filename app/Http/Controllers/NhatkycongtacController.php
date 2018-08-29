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
        $current_iddonvi =  UserLibrary::getIdDonViOfCanBo( Session::get('userinfo')->idcanbo );
        $data['list_doicongtac'] = UserLibrary::getListDoidonVi($current_iddonvi, 'object');
        if( $request->ajax() )
        {
            $arrWhere = NhatkycongtacLibrary::processArrWhereIndex( $request );
            $data['list_nhatky'] = NhatkycongtacLibrary::getListNhatkycanbo( $idcanbo, $arrWhere, 15);
            return response()->json(['html' => view('nhatkycongtac.nhatkycanbo_table', $data)->render()]);
        }
        else
        {
            $data['list_nhatky'] = NhatkycongtacLibrary::getListNhatkycanbo( $idcanbo, array(), 15);
        }



        return view('nhatkycongtac.index', $data);
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
            return response()->json(['error' => array('Nhật ký ngày '.$request->ngay.' của bạn đã tồn tại trong hệ thống')]);
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
    public function nhatkydoi_create($ngaynhatky = NULL)
    {
        $data['page_name'] = 'Thêm nhật ký công tác đội';
        if( $ngaynhatky != NULL && NhatkycongtacLibrary::checkMyDateDmY($ngaynhatky) ) $data['ngaydautuan'] = $ngaynhatky;
        return view('nhatkycongtac.nhatkydoi_create', $data);
    }

    public function nhatkydoi_store(Request $request)
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
            return response()->json(['error' => array('Nhật ký ngày '.$request->ngay.' của bạn đã tồn tại trong hệ thống')]);
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
}
