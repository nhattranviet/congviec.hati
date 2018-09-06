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
use App\UserApp\LichcongtacLibrary;
use App\UserApp\UserLibrary;
use App\UserApp\CanboLibrary;
use Illuminate\Support\Facades\Redirect;

class LichcongtacController extends Controller
{
    public function index(Request $request, $iddonvi = NULL)
    {
        $idcanbo = Session::get('userinfo')->idcanbo;
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
        $data['page_name'] = 'Quản lý lịch công tác '.$tendonvi;
        return view('cahtcore.lichcongtac.index', $data);
    }

    public function create($iddonvi = NULL)
    {
        $current_donvi = ($iddonvi != NULL) ? $iddonvi : Session::get('userinfo')->iddonvi;
        $tendonvi = DB::table('tbl_donvi')->where('id',$current_donvi)->value('name');
        $data['list_lanhdao'] = CanboLibrary::getListCanboOfDonvi( $current_donvi, 'object', array(['tbl_donvi_doi.iddoi', '=', config('user_config.id_doi_lanhdaodonvi')]) );
        $data['page_name'] = 'Thêm lịch công tác của '.$tendonvi;
        $data['iddonvi'] = $current_donvi;
        return view('cahtcore.lichcongtac.create', $data);
    }

    public function store(Request $request, $iddonvi)
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
            return redirect()->route('lich-cong-tac.index', $iddonvi)->with('alert_message', $message);
        }
        elseif($request->submit == 'saveandnew')
        {
            return redirect()->route('lich-cong-tac.create', $iddonvi)->with('alert_message', $message);
        }
        
        // 

    }
}
