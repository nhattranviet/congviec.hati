<?php

namespace App\Http\Controllers\Nhanhokhau;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Facades\DB;
use Auth;

class HomeNhanhokhauController extends Controller
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
    public function index()
    {
        $current_date = date('Y-m-d', time());
        $ago_14_year = date('Y-m-d', strtotime($current_date. ' - 14 years'));

        $data['thuongtru_tongsoho'] = DB::connection('nhanhokhau')->table('tbl_hoso')->where('deleted_at', NULL)->count();
        $data_sonhankhau = DB::connection('nhanhokhau')->table('tbl_sohokhau')
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

        $data['tamtru_tongso_so'] = DB::connection('nhanhokhau')->table('tbl_sotamtru')->where('deleted_at', NULL)->count();

        $data_tamtru = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['tbl_sotamtru.deleted_at', '=', NULL],
            ['tbl_tamtru.deleted_at', '=', NULL],
        ));
        $data['tamtru_sonhankhau'] = $data_tamtru->count();
        $data['tamtru_nhankhau_better_14'] = $data_tamtru->whereDate('ngaysinh', '<=', $ago_14_year)->count();
        
        $data['tamtru_gioitinhnu'] = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['tbl_sotamtru.deleted_at', '=', NULL],
            ['tbl_tamtru.deleted_at', '=', NULL],
        ))
        ->where('gioitinh',0)->count();

        $data['thuongtru_hosohokhau'] = DB::connection('nhanhokhau')->table('tbl_sohokhau')
            ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
            ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
            ->where( 'idquanhechuho', 1 )
            ->select('hosohokhau_so', 'hokhau_so', 'hoten', 'idxa_thuongtru', 'idhoso')
            ->orderBy('idhoso', 'DESC')
            ->take(5)->get();
        
        $data['tamtru_hosohokhau'] = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id' , '=', 'tbl_tamtru.idsotamtru')
        ->where( 'idquanhechuho', 1 )
        ->select('sotamtru_so', 'hoten', 'idxa_tamtru', 'idsotamtru' )
        ->orderBy('idsotamtru', 'DESC')
        ->take(5)->get();
        return view('home', $data);
    }
}
