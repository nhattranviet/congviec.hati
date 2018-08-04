<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;
use Session;
use Carbon\Carbon;

class NhanhokhauLibrary
{
    public $connection = 'nhanhokhau';
    public static function getListHosoIndex($keyword = NULL)
    {
        $data = DB::connection('nhanhokhau')->table('tbl_sohokhau')
            ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
            ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso');
        if($keyword != NULL)
        {
            $data = $data->where(array(
                ['hosohokhau_so', 'like', '%'.$keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->orWhere(array(
                ['hokhau_so', 'like', '%'.$keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->orWhere(array(
                ['hoten', 'like', '%'.$keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->select('tbl_nhankhau.*', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.id as idhoso', 'tbl_hoso.hokhau_so','tbl_sohokhau.id as idsohokhau')
            ->orderBy('idhoso', 'DESC')
            ->paginate(9);
        }
        else
        {
            $data = $data->where('idquanhechuho', 1)
            ->select('tbl_nhankhau.*', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.id as idhoso', 'tbl_hoso.hokhau_so','tbl_sohokhau.id as idsohokhau')
            ->orderBy('idhoso', 'DESC')
            ->paginate(9);
        }
        return $data;
    }

    public static function insertHoso($request, $get_id = TRUE)
    {
        $data_ho = array(
            'hosohokhau_so' => $request->hosohokhau_so,
            'hokhau_so' => $request->hokhau_so,
            'so_dktt_so' => $request->so_dktt_so,
            'so_dktt_toso' => $request->so_dktt_toso,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_hoso')->insertGetId( $data_ho );
        }
        else{
            return DB::connection('nhanhokhau')->table('tbl_hoso')->insert( $data_ho );
        }
    }

    public static function insertArrNhankhau($request, $i, $get_id = TRUE)
    {
            $nhankhau_data = array(
                'hoten' => $request->hoten[$i],
                'tenkhac' => $request->tenkhac[$i],
                'ngaysinh' => date('Y-m-d', strtotime($request->birthday[$i])),
                'idquoctich' => $request->idquoctich[$i],
                'idquocgia_nguyenquan' => $request->idquocgia_nguyenquan[$i],
                'idtinh_nguyenquan' => $request->idtinh_nguyenquan[$i],
                'idhuyen_nguyenquan' => $request->idhuyen_nguyenquan[$i],
                'idxa_nguyenquan' => $request->idxa_nguyenquan[$i],
                'chitiet_nguyenquan' => $request->chitiet_nguyenquan[$i],

                'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
                'idtinh_thuongtru' => $request->idtinh_thuongtru,
                'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
                'idxa_thuongtru' => $request->idxa_thuongtru,
                'chitiet_thuongtru' => $request->chitiet_thuongtru,

                'idquocgia_noiohiennay' => $request->idquocgia_noiohiennay[$i],
                'idtinh_noiohiennay' => $request->idtinh_noiohiennay[$i],
                'idhuyen_noiohiennay' => $request->idhuyen_noiohiennay[$i],
                'idxa_noiohiennay' => $request->idxa_noiohiennay[$i],
                'chitiet_noiohiennay' => $request->chitiet_noiohiennay[$i],

                'idquocgia_noisinh' => $request->idquocgia_noisinh[$i],
                'idtinh_noisinh' => $request->idtinh_noisinh[$i],
                'idhuyen_noisinh' => $request->idhuyen_noisinh[$i],
                'idxa_noisinh' => $request->idxa_noisinh[$i],
                'chitiet_noisinh' => $request->chitiet_noisinh[$i],

                'idquocgia_noilamviec' => $request->idquocgia_noilamviec[$i],
                'idtinh_noilamviec' => $request->idtinh_noilamviec[$i],
                'idhuyen_noilamviec' => $request->idhuyen_noilamviec[$i],
                'idxa_noilamviec' => $request->idxa_noilamviec[$i],
                'chitiet_noilamviec' => $request->chitiet_noilamviec[$i],

                'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc[$i],
                'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc[$i],
                'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc[$i],
                'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],
                'chitiet_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],

                'hochieu_so' => $request->hochieu_so[$i],
                'cmnd_so' => $request->cmnd_so[$i],
                'idtongiao' => $request->idtongiao[$i],
                'iddantoc' => $request->iddantoc[$i],
                'idtrinhdohocvan' => $request->idtrinhdohocvan[$i],
                'idnghenghiep' => $request->idnghenghiep[$i],
                'trinhdochuyenmon' => $request->trinhdochuyenmon[$i],
                'trinhdongoaingu' => $request->trinhdongoaingu[$i],
                'biettiengdantoc' => $request->biettiengdantoc[$i],
                'tomtatbanthan' => $request->description[$i],
                'tomtatgiadinh' => $request->descriptionFamily[$i],
                'tienan_tiensu' => $request->criminalRecord[$i],
                'gioitinh' => $request->gender[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );

            if( $get_id )
            {
                return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insertGetId( $nhankhau_data );
            }
            else
            {
                return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insert( $nhankhau_data );
            }
    }

    public static function insertNhankhauToSohokhau($request, $i, $idhoso, $idnhankhau, $get_id = 'TRUE')
    {
        $data_sohokhau_insert = array(
            'idhoso' => $idhoso,
            'idnhankhau' => $idnhankhau,
            'idquanhechuho' => $request->idquanhechuho[$i],
            'ngaydangky' => date('Y-m-d', strtotime($request->ngaydangky[$i])),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_sohokhau')->insertGetId( $data_sohokhau_insert );
        }
        else
        {
            return DB::connection('nhanhokhau')->table('tbl_sohokhau')->insert( $data_sohokhau_insert );
        }
    }

    public static function getListQuocgia($array_pluck = FALSE)
    {
        if($array_pluck)
        {
           return DB::table('tbl_quocgia')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_quocgia')->get();
        }
        
    }

    public static function getListTinhTP($idquocgia, $array_pluck = FALSE)
    {
        if ($array_pluck)
        {
            return DB::table('tbl_tinh_tp')->where('idquocgia', $idquocgia)->pluck('name', 'id')->toArray();
        }
        else
        {
            return DB::table('tbl_tinh_tp')->where('idquocgia', $idquocgia)->get();
        }
        
    }

    public static function getListHuyenTX($idtinhtp, $array_pluck = FALSE)
    {
        if($array_pluck)
        {
           return DB::table('tbl_huyen_tx')->where('idtinhtp', $idtinhtp)->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_huyen_tx')->where('idtinhtp', $idtinhtp)->get();
        }
        
    }

    public static function getListXaPhuongTT($idhuyentx, $array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_xa_phuong_tt')->where('idhuyentx', $idhuyentx)->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_xa_phuong_tt')->where('idhuyentx', $idhuyentx)->get();
        }
        
    }

    public static function getListMoiQuanHe($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->get();
        }
        
    }

    public static function getListTonGiao($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_tongiao')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_tongiao')->get();
        }
        
    }

    public static function getListDanToc($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_dantoc')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_dantoc')->get();
        }
        
    }

    public static function getListTrinhDoHocVan($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_trinhdohocvan')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_trinhdohocvan')->get();
        }
        
    }

    public static function getListNgheNghiep($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_nghenghiep')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_nghenghiep')->get();
        }
        
    }


}
