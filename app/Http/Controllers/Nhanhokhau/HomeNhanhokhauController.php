<?php

namespace App\Http\Controllers\Nhanhokhau;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Facades\DB;
use Auth;

class HomeNhanhokhauController extends Controller
{
    public $data;
    public $ago_14_year;
    public $current_thanhthi = [3044];
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
        $this->data['thuongtru_tongsoho'] = DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->where('tbl_sohokhau.deleted_at', NULL)->distinct()
        ->count('idhoso');

        $this->data['thuongtru_tongnhankhau'] = DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->where('tbl_sohokhau.deleted_at', NULL)
        ->count();

        $this->data['tamtru_tongso_so'] = DB::connection('nhanhokhau')->table('tbl_sotamtru')
        ->where('tbl_sotamtru.deleted_at', NULL)
        ->count();

        $this->data['tamtru_sonhankhau'] = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->where('tbl_tamtru.deleted_at', NULL)->distinct()
        ->count();

        $this->data['thuongtru_hosohokhau'] = DB::connection('nhanhokhau')->table('tbl_sohokhau')
            ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
            ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
            ->where(array(
                ['tbl_sohokhau.deleted_at', '=', NULL],
                ['tbl_hoso.deleted_at', '=', NULL],
                ['idquanhechuho', '=' ,  1]
            ))
            ->select('hosohokhau_so', 'hokhau_so', 'hoten', 'idxa_thuongtru', 'idhoso')
            ->orderBy('idhoso', 'DESC')
            ->take(5)->get();
        
        $this->data['tamtru_hosohokhau'] = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id' , '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
                ['tbl_sotamtru.deleted_at', '=', NULL],
                ['tbl_tamtru.deleted_at', '=', NULL],
                ['idquanhechuho', '=' ,  1]
            ))
        ->select('sotamtru_so', 'hoten', 'idxa_tamtru', 'idsotamtru' )
        ->orderBy('idsotamtru', 'DESC')
        ->take(5)->get();
        return view('nhankhau-layouts.home', $this->data);
    }
}
