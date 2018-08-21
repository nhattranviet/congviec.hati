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
        $this->ago_14_year = date('Y-m-d', strtotime(date('Y-m-d', time()). ' - 14 years'));
        $this->data['thuongtru_tongsoho'] = 0;
        $this->data['thuongtru_tongnhankhau'] = 0;
        $this->data['thuongtru_gioitinh_nu'] = 0;
        $this->data['thuongtru_nhankhau_better_14'] = 0;
        DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_hoso.deleted_at', NULL)
        ->where('tbl_sohokhau.deleted_at', NULL)
        ->orderBy('tbl_hoso.id')
        ->select('tbl_hoso.id as idhoso', 'idxa_thuongtru', 'gioitinh', 'ngaysinh', 'idquanhechuho')
        ->chunk( 1000, function($data_nhankhau) {
            foreach ($data_nhankhau as $nhankhau) {
                $this->data['thuongtru_tongnhankhau']++;

                if( $nhankhau->idquanhechuho == 1 ) $this->data['thuongtru_tongsoho']++;

                if($nhankhau->gioitinh == 0) $this->data['thuongtru_gioitinh_nu']++;

                if($nhankhau->ngaysinh <= $this->ago_14_year) $this->data['thuongtru_nhankhau_better_14']++;
            }
        } );

        $this->data['tamtru_gioitinhnu'] = 0;
        $this->data['tamtru_nhankhau_better_14'] = 0;
        $this->data['tamtru_sonhankhau'] = 0;
        $this->data['tamtru_tongso_ho'] = 0;
        $data_tamtru_chunk = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['tbl_sotamtru.deleted_at', '=', NULL],
            ['tbl_tamtru.deleted_at', '=', NULL],
        ))
        ->orderBy('tbl_tamtru.id')
        ->select( 'sotamtru_so', 'tbl_sotamtru.type', 'idsotamtru', 'idquanhechuho', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idxa_thuongtru', 'idhuyen_thuongtru', 'idtinh_thuongtru', 'gioitinh', 'ngaysinh', 'tamtru_tungay', 'tamtru_denngay')
        ->chunk(1000, function($list_nhankhau){
            foreach($list_nhankhau as $nhankhau)
                {
                    $this->data['tamtru_sonhankhau']++;
                    if( $nhankhau->idquanhechuho == 1 ) $this->data['tamtru_tongso_ho']++;
                    if($nhankhau->ngaysinh <= $this->ago_14_year)   $this->data['tamtru_nhankhau_better_14']++;
                    if($nhankhau->gioitinh == 0) $this->data['tamtru_gioitinhnu']++;
                }
            });

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
