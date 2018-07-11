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
        'sotailieu.unique' => 'Số tài liệu/Ký hiệu này đã tồn tại trong hệ thống',
    ];
    public $curr_donvi = 11;
    public function index()
    {
        echo 'index';
    }
    public function create()
    {
        $data['page_name'] = "Thêm mới công việc";
        $data['list_lanhdao'] = DB::table('tbl_canbo')
        ->join('tbl_nguoi', 'tbl_nguoi.idnguoi', '=', 'tbl_canbo.idnguoi')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->select('idcanbo', 'hoten', 'tenchucvu')
        ->where(array(
            ['iddonvi', '=', $this->curr_donvi]
        ))
        ->whereNotIn('idchucvu', [1, 2, 13])
        ->get();
        return view('congviec.create', $data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'sotailieu' => 'required',
            'noisoanthao' => 'required'

        ], $this->messages);

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }


        die;
        //Ghi log cua ho so
        for ($i=0; $i < count($fullname); $i++)
        {
            if($request->idquanhechuho[$i] == 1)
            {
                $data_log = array(
                    'idthutuccutru' => $this->thutuc_capmoi,
                    'type' => 'hogiadinh',
                    'idhoso' => $idBrief,
                    'date_action' => date('Y-m-d', strtotime($request->ngaydangky[$i])),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc[$i],
                    'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc[$i],
                    'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc[$i],
                    'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],
                    'chitiet_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],
                );
                DB::table('tbl_history_cutru')->insert( $data_log );
            }
            break;
        }
        
        

        return response()->json(['success' => 'Thêm nhân khẩu thành công ', 'url' => route('chi-tiet-ho-khau', $idBrief)]);
    }
}
