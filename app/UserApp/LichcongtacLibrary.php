<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\UserApp\UserLibrary;
use Redirect;
use Illuminate\Http\RedirectResponse;


class LichcongtacLibrary
{
    public function __construct()
    {
        
    }

    public static function getLichcongtacMessage()
    {
        return [
            'gio.required' => 'Giờ công việc không được để trống',
            'ngay.required' => 'Ngày công việc được để trống',
            'ngay.date_format' => 'Ngày phải đúng định dạng ngày-tháng-năm',
            'noidungcongviec.required' => 'Nội dung công việc không được để trống',
            'lanhdaothamdu.required' => 'Lãnh đạo tham dự không được để trống',
            'idlanhdaotruc.required' => 'Lãnh đạo trực không được để trống'
        ];
    }

    public static function getListCongviec( $iddonvi, $arrWhere = array(), $paginage = 10 )
    {
        return DB::table('tbl_lichcongtac')
        ->join('tbl_donvi_doi', 'tbl_lichcongtac.id_iddonvi_iddoi', '=', 'tbl_donvi_doi.id')
        ->where('iddonvi', $iddonvi)
        ->where($arrWhere)
        ->orderBy('ngay', 'DESC')
        ->select('tbl_lichcongtac.*')
        ->paginate($paginage);
    }

    public static function getLanhdaoCongviec($idcongviec)
    {
        $data = DB::table('tbl_lichcongtac')
        ->join('tbl_lichcongtac_lanhdao', 'tbl_lichcongtac.id', '=', 'tbl_lichcongtac_lanhdao.idcongviec')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_lichcongtac_lanhdao.idlanhdao')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->join('tbl_donvi', 'tbl_donvi.id', '=', 'tbl_donvi_doi.iddonvi')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('idcongviec', $idcongviec)
        ->orderBy('order', 'ASC')
        ->select('hoten', 'iddonvi', 'tbl_donvi.name as tendonvi', 'tbl_chucvu.name as tenchucvu')->get();
        $str = '';
        // 
        if($data)
        {
            if( count( $data ) == count(UserLibrary::getListLanhDaoOfDonVi( $data[0]->iddonvi )) )
            {
                if($data[0]->iddonvi == config('user_config.iddonvi_bangiamdoc'))
                {
                    $str = 'Các đ/c trong Ban Giám đốc';
                }else{
                    $str = 'Các đ/c lãnh đạo '.$data[0]->tendonvi;
                }
                
            }
            else
            {
                foreach ($data as $lanhdao)
                {
                    $str .= 'Đ/c '.$lanhdao->hoten.' - '.$lanhdao->tenchucvu.', ';
                }
                $str = rtrim($str, ", ");
            }
            
        }
        return $str;
    }

    public static function getListLichcongtac( $iddonvi, $request, $paginate = 10)
    {
        $data = DB::table('tbl_lichcongtac')
        ->join('tbl_donvi_doi', 'tbl_lichcongtac.id_iddonvi_iddoi', '=', 'tbl_donvi_doi.id')
        ->where('iddonvi', $iddonvi);
        if($request != NULL && $request->tungay != NULL) $data = $data->whereDate('ngay', '>=', date('Y-m-d', strtotime($request->tungay)));
        if($request != NULL && $request->denngay != NULL) $data = $data->whereDate('ngay', '<=', date('Y-m-d', strtotime($request->denngay)));
        if($request != NULL && $request->noidungcongviec != NULL) $data = $data->where('noidungcongviec', 'LIKE', '%'.$request->noidungcongviec.'%' );
        $data = $data->orderBy('ngay', 'DESC')
        ->select('tbl_lichcongtac.*');
        if($paginate != NULL)
        {
            $data = $data->paginate($paginate);
        }
        else{
            $data = $data->get();
        }
        
        return $data;
    }

    public static function getListLichcongtacInTuanToShow( $iddonvi, $tungay = NULL, $denngay = NULL)
    {
        $data = DB::table('tbl_lichcongtac')
        ->join('tbl_donvi_doi', 'tbl_lichcongtac.id_iddonvi_iddoi', '=', 'tbl_donvi_doi.id')
        ->where('iddonvi', $iddonvi);
        if($tungay != NULL) $data = $data->whereDate('ngay', '>=', $tungay);
        if($denngay != NULL) $data = $data->whereDate('ngay', '<=', $denngay);
        $data = $data->orderBy('ngay', 'ASC')
        ->select('tbl_lichcongtac.*')->get()->toArray();
        return $data;
    }

    public static function getListLichcongtacInNgayToShow( $iddonvi, $ngay = NULL)
    {
        $data = DB::table('tbl_lichcongtac')
        ->join('tbl_donvi_doi', 'tbl_lichcongtac.id_iddonvi_iddoi', '=', 'tbl_donvi_doi.id')
        ->where('iddonvi', $iddonvi);
        if($ngay != NULL) $data = $data->whereDate('ngay', '=', $ngay);
        $data = $data->orderBy('ngay', 'ASC')
        ->select('tbl_lichcongtac.*')->get()->toArray();
        return $data;
    }

    public static function getCongviecInfo($idcongviec)
    {
        return DB::table('tbl_lichcongtac_lanhdao')
        ->join('tbl_lichcongtac', 'tbl_lichcongtac.id', '=', 'tbl_lichcongtac_lanhdao.idcongviec')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_lichcongtac_lanhdao.idlanhdao')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->where('idcongviec',$idcongviec)
        ->select('tbl_lichcongtac.*', 'idlanhdao', 'iddonvi')
        ->get()->toArray();
    }

    public static function getCongviecLanhdao($idcongviec)
    {
        return DB::table('tbl_lichcongtac_lanhdao')->where('id',$idcongviec)->select('idlanhdao')->get();
    }

    public static function getListLanhdaotructuan( $iddonvi, $request, $paginate = 10)
    {
        $data = DB::table('tbl_canbo')
        ->join('tbl_lanhdao_tructuan', 'tbl_lanhdao_tructuan.idlanhdao', '=', 'tbl_canbo.id')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('tbl_lanhdao_tructuan.iddonvi', $iddonvi);
        if($request != NULL && $request->tungay != NULL) $data = $data->whereDate('ngaycuoituan', '>=', date('Y-m-d', strtotime($request->tungay)));
        if($request != NULL && $request->denngay != NULL) $data = $data->whereDate('ngaydautuan', '<=', date('Y-m-d', strtotime($request->denngay)));
        if($request != NULL && $request->idlanhdaotruc != NULL) $data = $data->where('idlanhdao', '=', $request->idlanhdaotruc );
        $data = $data->orderBy('ngaydautuan', 'DESC')
        ->select('tbl_lanhdao_tructuan.id', 'hoten', 'ngaydautuan', 'ngaycuoituan', 'tbl_chucvu.name as tenchucvu')
        ->paginate($paginate);
        return $data;
    }

    public static function getLanhdaotructuan( $iddonvi, $ngaydautuan)
    {
        $data = DB::table('tbl_canbo')
        ->join('tbl_lanhdao_tructuan', 'tbl_lanhdao_tructuan.idlanhdao', '=', 'tbl_canbo.id')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('tbl_lanhdao_tructuan.iddonvi', $iddonvi)
        ->where('ngaydautuan', $ngaydautuan)
        ->select('tbl_lanhdao_tructuan.id', 'hoten', 'ngaydautuan', 'ngaycuoituan', 'tbl_chucvu.name as tenchucvu')
        ->first();
        return $data;
    }


    

}
