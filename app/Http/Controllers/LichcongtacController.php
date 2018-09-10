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
use App\UserApp\NhatkycongtacLibrary;
use App\UserApp\LichcongtacLibrary;
use App\UserApp\UserLibrary;
use App\UserApp\CanboLibrary;
use Illuminate\Support\Facades\Redirect;

class LichcongtacController extends Controller
{

    public function index(Request $request)
    {
        $iddonvi = Session::get('userinfo')->iddonvi;
        $data['iddonvi'] = $iddonvi;
        if( $request->ajax() )
        {
            $data['list_congviec'] = LichcongtacLibrary::getListLichcongtac($iddonvi, $request, 15 );
            $data['congviec_lanhdao'] = [];
            if( count($data['list_congviec']) > 0 )
            {
                foreach($data['list_congviec'] as $congviec)
                {
                    $data['congviec_lanhdao'][$congviec->id] = LichcongtacLibrary::getLanhdaoCongviec($congviec->id);
                }
            }
            return response()->json(['html' => view('cahtcore.lichcongtac.lichcongtac_table', $data)->render()]);
        }
        else
        {
            $data['list_congviec'] = LichcongtacLibrary::getListLichcongtac( $iddonvi, NULL, 15);
        }
        $data['congviec_lanhdao'] = [];
        if(count( $data['list_congviec'] ) > 0)
        {
            foreach($data['list_congviec'] as $congviec)
            {
                $data['congviec_lanhdao'][$congviec->id] = LichcongtacLibrary::getLanhdaoCongviec($congviec->id);
            }
        }
        $tendonvi = DB::table('tbl_donvi')->where('id',$iddonvi)->value('name');
        $data['page_name'] = 'Quản lý lịch công tác lãnh đạo '.$tendonvi;
        return view('cahtcore.lichcongtac.index', $data);
    }

    public function create()
    {
        $iddonvi = Session::get('userinfo')->iddonvi;
        $tendonvi = DB::table('tbl_donvi')->where('id',$iddonvi)->value('name');
        $data['list_lanhdao'] = CanboLibrary::getListCanboOfDonvi( $iddonvi, 'object', array(['tbl_donvi_doi.iddoi', '=', config('user_config.id_doi_lanhdaodonvi')]) );
        $data['page_name'] = 'Thêm lịch công tác của lãnh đạo '.$tendonvi;
        $data['iddonvi'] = $iddonvi;
        return view('cahtcore.lichcongtac.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ngay' => 'required|date_format:d-m-Y',
            'gio' => 'required',
            'lanhdaothamdu' => 'required',
            'noidungcongviec' => 'required',

        ], LichcongtacLibrary::getLichcongtacMessage() );

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $iddonvi = Session::get('userinfo')->iddonvi;

        $data_insert = [
            'ngay' => date('Y-m-d', strtotime($request->ngay)).' ' .$request->gio.':00',
            'noidungcongviec' => $request->noidungcongviec,
            'diadiem' => ($request->diadiem_select != NULL) ? $request->diadiem_select : $request->diadiemkhac ,
            'donvichutri' => $request->donvichutri,
            'idcanbo_creater' => Session::get('userinfo')->idcanbo,
            'id_iddonvi_iddoi' => UserLibrary::getIdDonviIddoiLanhdaoOfDonVi ($iddonvi),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $idcongviec = DB::table('tbl_lichcongtac')->insertGetId($data_insert);
        $data_lanhdao_congviec = [];
        foreach ($request->lanhdaothamdu as $lanhdao)
        {
            $data_lanhdao_congviec[] = [
                'idcongviec' => $idcongviec,
                'idlanhdao' => $lanhdao,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        DB::table('tbl_lichcongtac_lanhdao')->insert($data_lanhdao_congviec);
        $message = array('type' => 'success', 'content' => 'Thêm công việc thành công');
        if($request->submit == 'save')
        {
            return redirect()->route('lich-cong-tac.index')->with('alert_message', $message);
        }
        elseif($request->submit == 'saveandnew')
        {
            return redirect()->route('lich-cong-tac.create')->with('alert_message', $message);
        }
    }

    public function edit($idcongviec)
    {
        $data['congviec_info'] = LichcongtacLibrary::getCongviecInfo($idcongviec);
        $data['arrLanhdao'] = [];
        foreach($data['congviec_info'] as $congviec)
        {
            $data['arrLanhdao'][] =  $congviec->idlanhdao;
        }
        $tendonvi = DB::table('tbl_donvi')->where('id',$data['congviec_info'][0]->iddonvi)->value('name');
        $data['list_lanhdao'] = CanboLibrary::getListCanboOfDonvi( $data['congviec_info'][0]->iddonvi, 'object', array(['tbl_donvi_doi.iddoi', '=', config('user_config.id_doi_lanhdaodonvi')]) );
        $data['page_name'] = 'Sửa lịch công tác của '.$tendonvi;
        $data['iddonvi'] = $data['congviec_info'][0]->iddonvi;
        $data['idcongviec'] = $idcongviec;
        return view('cahtcore.lichcongtac.edit', $data);
    }

    public function update(Request $request, $idcongviec)
    {
        $validator = Validator::make($request->all(), [
            'ngay' => 'required|date_format:d-m-Y',
            'gio' => 'required',
            'lanhdaothamdu' => 'required',
            'noidungcongviec' => 'required',

        ], LichcongtacLibrary::getLichcongtacMessage() );

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $data_update = [
            'ngay' => date('Y-m-d', strtotime($request->ngay)).' ' .$request->gio.':00',
            'noidungcongviec' => $request->noidungcongviec,
            'diadiem' => ($request->diadiem_select != NULL) ? $request->diadiem_select : $request->diadiemkhac ,
            'donvichutri' => $request->donvichutri,
            'updated_at' => Carbon::now()
        ];
        DB::table('tbl_lichcongtac')->where('id', $idcongviec)->update($data_update);
        
        $congviec_info = LichcongtacLibrary::getCongviecInfo($idcongviec);
        $arrLanhdaoDB = [];
        foreach($congviec_info as $congviec)
        {
            $arrLanhdaoDB[] =  $congviec->idlanhdao;
        }

        $lanhdao_add = array_diff($request->lanhdaothamdu, $arrLanhdaoDB);
        $lanhdao_diff = array_diff($arrLanhdaoDB, $request->lanhdaothamdu);
        if(count($lanhdao_add) > 0)
        {
            $arr_add = [];
            foreach($lanhdao_add as $lanhdao)
            {
                $arr_add[] = ['idcongviec' => $idcongviec, 'idlanhdao' => $lanhdao];
            }
            DB::table('tbl_lichcongtac_lanhdao')->insert($arr_add);
        }

        if(count($lanhdao_diff) > 0)
        {
            DB::table('tbl_lichcongtac_lanhdao')->where('idcongviec', $idcongviec)->whereIn('idlanhdao', $lanhdao_diff)->delete();            
        }
        
        $message = array('type' => 'success', 'content' => 'Sửa công việc thành công');
        return redirect()->route('lich-cong-tac.index', $congviec_info[0]->iddonvi)->with('alert_message', $message);
    }

    public function delete($idcongviec)
    {
        $congviec_info = LichcongtacLibrary::getCongviecInfo($idcongviec);
        DB::table('tbl_lichcongtac_lanhdao')->where('idcongviec',$idcongviec)->delete();
        DB::table('tbl_lichcongtac')->where('id',$idcongviec)->delete();
        $message = array('type' => 'success', 'content' => 'Xóa công việc thành công');
        return redirect()->route('lich-cong-tac.index', $congviec_info[0]->iddonvi)->with('alert_message', $message);
    }

    public function create_lanhdaotructuan()
    {
        $iddonvi = Session::get('userinfo')->iddonvi;
        $tendonvi = DB::table('tbl_donvi')->where('id',$iddonvi)->value('name');
        $data['list_lanhdao'] = CanboLibrary::getListCanboOfDonvi( $iddonvi, 'object', array(['tbl_donvi_doi.iddoi', '=', config('user_config.id_doi_lanhdaodonvi')]) );
        $data['page_name'] = 'Thêm lịch công tác của lãnh đạo '.$tendonvi;
        $data['iddonvi'] = $iddonvi;
        return view('cahtcore.lichcongtac.create_lanhdaotructuan', $data);
    }

    public function store_lanhdaotructuan (Request $request)
    {
        $iddonvi = Session::get('userinfo')->iddonvi;
        $validator = Validator::make($request->all(), [
            'tuan' => 'required',
            'idlanhdaotruc' => 'required',
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
        if( DB::table('tbl_lanhdao_tructuan')->where(array(['iddonvi', '=', $iddonvi], ['ngaydautuan', '=', $Y_m_d_ngaydautuan], ['ngaycuoituan', '=', $Y_m_d_ngaycuoituan]))->count() > 0 )
        {
            return response()->json(['error' => array('Tuần từ '.$ngaudautuan_cuoituan[0].' đến '.$ngaudautuan_cuoituan[1].' của đơn vị bạn đã có lãnh đạo trực. Chọn sửa thay vì thêm mới!')]);
        }
        
        $data = array(
            'idcanbo_creater' => $idcanbo,
            'iddonvi' => $iddonvi,
            'idlanhdao' => $request->idlanhdaotruc,
            'ngaydautuan' => $Y_m_d_ngaydautuan,
            'ngaycuoituan' => $Y_m_d_ngaycuoituan,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );

        DB::table('tbl_lanhdao_tructuan')->insert( $data );
        return response()->json(['success' => 'Thêm lãnh đạo trực thành công ', 'url' => route('lich-cong-tac.index_lanhdaotructuan', $iddonvi)]);
    }

    public function edit_lanhdaotructuan($id = NULL)
    {
        $data['tructuan_info'] = DB::table('tbl_lanhdao_tructuan')->where('id',$id)->first();
        $data['list_lanhdao'] = CanboLibrary::getListCanboOfDonvi( $data['tructuan_info']->iddonvi, 'object', array(['tbl_donvi_doi.iddoi', '=', config('user_config.id_doi_lanhdaodonvi')]) );
        $tendonvi = DB::table('tbl_donvi')->where('id',$data['tructuan_info']->iddonvi)->value('name');
        $data['page_name'] = 'Sửa lãnh đạo trực tuần của '.$tendonvi;
        $data['id'] = $id;
        $data['iddonvi'] = $data['tructuan_info']->iddonvi;
        return view('cahtcore.lichcongtac.edit_lanhdaotructuan', $data);
    }

    public function update_lanhdaotructuan (Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'idlanhdaotruc' => 'required',
        ], NhatkycongtacLibrary::getNhatkycongtacMessage() );
        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }
        $data = array(
            'idlanhdao' => $request->idlanhdaotruc,
            'updated_at' => Carbon::now()
        );

        DB::table('tbl_lanhdao_tructuan')->where('id', $id)->update( $data );
        $data['tructuan_info'] = DB::table('tbl_lanhdao_tructuan')->where('id',$id)->first();
        $message = array('type' => 'success', 'content' => 'Sửa thành công');
        return redirect()->route('lich-cong-tac.index_lanhdaotructuan', $data['tructuan_info']->iddonvi)->with('alert_message', $message);
    }

    public function index_lanhdaotructuan(Request $request)
    {
        $iddonvi = Session::get('userinfo')->iddonvi;
        $data['list_lanhdao'] = CanboLibrary::getListCanboOfDonvi( $iddonvi, 'object', array(['tbl_donvi_doi.iddoi', '=', config('user_config.id_doi_lanhdaodonvi')]) ); //dd($data['list_lanhdao']);
        $data['iddonvi'] = $iddonvi;
        if( $request->ajax() )
        {
            $data['list_lanhdaotructuan'] = LichcongtacLibrary::getListLanhdaotructuan($iddonvi, $request, 15 );
            return response()->json( [ 'html' => view('cahtcore.lichcongtac.lanhdaotructuan_table', $data)->render() ] );
        }
        else
        {
            $data['list_lanhdaotructuan'] = LichcongtacLibrary::getListLanhdaotructuan( $iddonvi, NULL, 15);
        }
        $tendonvi = DB::table('tbl_donvi')->where('id',$iddonvi)->value('name');
        $data['page_name'] = 'Quản lý lịch công tác lãnh đạo '.$tendonvi;
        return view('cahtcore.lichcongtac.index_lanhdaotructuan', $data);
    }

    public function delete_lanhdaotructuan($idtructuan)
    {
        $data['tructuan_info'] = DB::table('tbl_lanhdao_tructuan')->where('id',$idtructuan)->first();
        DB::table('tbl_lanhdao_tructuan')->where('id', $idtructuan)->delete();
        $message = array('type' => 'success', 'content' => 'Xóa thành công');
        return redirect()->route('lich-cong-tac.index_lanhdaotructuan', $data['tructuan_info']->iddonvi)->with('alert_message', $message);
    }

    public function show()
    {
        $iddonvi = Session::get('userinfo')->iddonvi;
        $data['tendonvi'] = 'PHÒNG '. DB::table('tbl_donvi')->where('id',$iddonvi)->value('kyhieu');
        $current_day = date('Y-m-d', time());
        $day_name = array( '1' => 'Thứ hai', '2' => 'Thứ ba', '3' => 'Thứ tư', '4' => 'Thứ năm', '5' => 'Thứ sáu', '6' => 'Thứ bảy', '0' => 'Chủ nhật');
        $data['tuan'] = UserLibrary::getNgayDauTuan_Cuoituan_Of_a_Day_Y_m_d( $current_day );
        $w = date('w', time());
        $data['current_day_name'] = $day_name[$w].' ngày '. date('d-m-Y', time()); 
        $data['tructuan'] = LichcongtacLibrary::getLanhdaotructuan( $iddonvi, $data['tuan']['ngaydautuan']);
        $data['data_tuan'] = LichcongtacLibrary::getListLichcongtacInTuanToShow( $iddonvi, $data['tuan']['ngaydautuan'], $data['tuan']['ngaycuoituan']);
        $data['data_ngay'] = LichcongtacLibrary::getListLichcongtacInNgayToShow( $iddonvi, $current_day);
        $data['congviec_lanhdao'] = [];
        if( $data['data_ngay'] != NULL )
        {
            foreach ($data['data_ngay'] as $congviec)
            {
                $data['congviec_lanhdao'][$congviec->id] = LichcongtacLibrary::getLanhdaoCongviec($congviec->id);
            }
            
        }
        $data['iddonvi'] = $iddonvi;
        $data['app_url'] = 'http://congviec.hati/lich-cong-tac/show';
        
        return view('cahtcore.lichcongtac.show', $data);
    }

    public function export($tungay, $denngay)
    {
        $iddonvi = Session::get('userinfo')->iddonvi;
        $data['list_ngay'] = UserLibrary::getListDayBettwenTwoDay_Y_m_d($tungay, $denngay);
        $data['day_name'] = array( '1' => 'Thứ hai', '2' => 'Thứ ba', '3' => 'Thứ tư', '4' => 'Thứ năm', '5' => 'Thứ sáu', '6' => 'Thứ bảy', '0' => 'Chủ nhật');
        $data['iddonvi'] = $iddonvi;
        $data['infodonvi'] = DB::table('tbl_donvi')->where('id', $iddonvi)->first();
        $data['data_tuan'] = LichcongtacLibrary::getListLichcongtacInTuanToShow( $iddonvi, $tungay, $denngay, 'ASC');
        $data['tungay'] = date('d-m-Y', strtotime($tungay));
        $data['denngay'] = date('d-m-Y', strtotime($denngay));
        $data['congviec_lanhdao'] = [];
        if( count($data['data_tuan']) > 0 )
        {
            foreach($data['data_tuan'] as $congviec)
            {
                $data['congviec_lanhdao'][$congviec->id] = LichcongtacLibrary::getLanhdaoCongviec($congviec->id);
            }
        }
        
        $data['list_congviec_chuanhoa_theo_buoi'] = [];
        foreach ($data['data_tuan'] as $ngay)
        {
            $int_time = strtotime($ngay->ngay);
            $buoi = (date('H', $int_time) > 12) ? 'Chiều' : 'Sáng';
            $ngay_Y_m_d = date('Y-m-d', $int_time);
            $data['list_congviec_chuanhoa_theo_buoi'][$ngay_Y_m_d][$buoi][] = $ngay; 
        }
        $lanhdaotruc_info = LichcongtacLibrary::getLanhdaotructuan($iddonvi, $tungay);
        $data['lanhdaotruc'] = ($lanhdaotruc_info) ? 'Đồng chí '.$lanhdaotruc_info->hoten.' - '. $lanhdaotruc_info->tenchucvu : '..........'; //dd($data['lanhdaotruc']);
        $html = view('cahtcore.lichcongtac.view_report_lichcongtac', $data)->render(); //echo $html; die;
        $str_for_doc = UserLibrary::create_docfile_landscape_nomal($html);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=lich-cong-ta-tu-".$data['tungay']." den ".$data['denngay'].".doc");
        echo $str_for_doc;
        // echo $html;

    }

    public function gate_check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tungay' => 'required|date_format:d-m-Y',
            'denngay' => 'required|date_format:d-m-Y',
        ], LichcongtacLibrary::getLichcongtacMessage() );

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }
        $int_ngaydautuan = strtotime( $request->tungay );
        $int_ngaycuoituan = strtotime( $request->denngay );
        $Y_m_d_ngaydautuan = date( 'Y-m-d', $int_ngaydautuan );
        $Y_m_d_ngaycuoituan = date( 'Y-m-d', $int_ngaycuoituan );

        if ( date('w', $int_ngaydautuan) != 1 || ( $int_ngaycuoituan - $int_ngaydautuan ) != 518400)    //  Từ thứ 2 đến CN có 6 bước nhảy 518400 = 6*86400
        {
            return response()->json(['error' => array('Trích xuất Lịch công tác phải chọn ngày đầu tuần (Thứ 2), ngày cuối tuần (Chủ nhật) và mỗi lần được chọn 01 tuần')]);
        }
        $iddonvi = Session::get('userinfo')->iddonvi;
        
        if($request->redirect_type == 'report_lichcongtactuan')
        {
            return response()->json([ 'message' => 'Đang trích xuất dữ liệu', 'url' => '/lich-cong-tac/export/'.$iddonvi.'/'.$Y_m_d_ngaydautuan.'/'.$Y_m_d_ngaycuoituan, 'type' => 'info', 'show_alert' => TRUE]);
        }
        
    }
}
