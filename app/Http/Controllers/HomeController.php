<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        echo $_SESSION['curr_donvi']; die;
        echo Session::get('id' );die;
        $current_date = date('Y-m-d', time());
        $ago_14_year = date('Y-m-d', strtotime($current_date. ' - 14 years'));

        $data['thuongtru_tongsoho'] = DB::table('tbl_hoso')->where('deleted_at', NULL)->count();
        $data_sonhankhau = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_hoso.deleted_at', NULL);
        $data['thuongtru_tongnhankhau'] = $data_sonhankhau->count();

        $gioitinh_nu = 0;
        $data_exec = $data_sonhankhau->select('idxa_thuongtru', 'gioitinh')->get();
        foreach ($data_exec as $value) {
            if($value->gioitinh == 0) $gioitinh_nu++;
        }

        $data['thuongtru_gioitinh_nu'] = $gioitinh_nu;

        $data['thuongtru_nhankhau_better_14'] = $data_sonhankhau->whereDate('ngaysinh', '<=', $ago_14_year)->count();

        $data['tamtru_tongso_so'] = DB::table('tbl_sotamtru')->where('deleted_at', NULL)->count();

        $data_tamtru = DB::table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['tbl_sotamtru.deleted_at', '=', NULL],
            ['tbl_tamtru.deleted_at', '=', NULL],
        ));
        $data['tamtru_sonhankhau'] = $data_tamtru->count();
        $data['tamtru_nhankhau_better_14'] = $data_tamtru->whereDate('ngaysinh', '<=', $ago_14_year)->count();
        
        $data['tamtru_gioitinhnu'] = DB::table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['tbl_sotamtru.deleted_at', '=', NULL],
            ['tbl_tamtru.deleted_at', '=', NULL],
        ))
        ->where('gioitinh',0)->count();

        $data['thuongtru_hosohokhau'] = DB::table('tbl_sohokhau')
            ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
            ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
            ->where( 'idquanhechuho', 1 )
            ->select('hosohokhau_so', 'hokhau_so', 'hoten', 'idxa_thuongtru', 'idhoso')
            ->orderBy('idhoso', 'DESC')
            ->take(5)->get();
        
        $data['tamtru_hosohokhau'] = DB::table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id' , '=', 'tbl_tamtru.idsotamtru')
        ->where( 'idquanhechuho', 1 )
        ->select('sotamtru_so', 'hoten', 'idxa_tamtru', 'idsotamtru' )
        ->orderBy('idsotamtru', 'DESC')
        ->take(5)->get();
            // print_r($data['thuongtru_hosohokhau']); die;
        return view('home', $data);
    }
}
