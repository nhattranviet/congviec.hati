<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\UserApp\UserLibrary;
use Redirect;
use Illuminate\Http\RedirectResponse;

class NhatkycongtacLibrary
{
    public function __construct()
    {
        
    }

    public static function getNhatkycongtacMessage()
    {
        return [
            'ngay.required' => 'Ngày dự kiến không được để trống',
            'ngay.date_format' => 'Ngày dự kiến phải đúng định dạng ngày-tháng-năm',
            'tuan.required' => 'Tuần dự kiến không được để trống',
            'noidungdukien.required' => 'Nội dung dự kiến không được để trống',
            'tungay.required' => 'Từ ngày không được để trống',
            'denngay.required' => 'Đến ngày không được để trống',
        ];
    }

    public static function processArrWhereNhatkycanboIndex($request)
    {
        $arrWhere = array();
        if($request->tungay != NULL)
        {
            $arrWhere[] = array('tbl_nhatkycanbo.ngay', '>=', date('Y-m-d', strtotime($request->tungay)));
        }

        if($request->denngay != NULL)
        {
            $arrWhere[] = array('tbl_nhatkycanbo.ngay', '<=', date('Y-m-d', strtotime($request->denngay)));
        }

        if($request->nhatky_status != NULL)
        {
            $arrWhere[] = array('nhatky_status', '=', $request->nhatky_status );
        }

        if($request->noidungdukien != NULL)
        {
            $arrWhere[] = array('noidungdukien', 'LIKE', '%'.$request->noidungdukien.'%' );
        }

        if($request->ketquathuchien != NULL)
        {
            $arrWhere[] = array('ketquathuchien', 'LIKE', '%'.$request->ketquathuchien.'%' );
        }
        return $arrWhere;
    }

    public static function processArrWhereNhatkyDoiIndex($request)
    {
        $arrWhere = array();
        if($request->tungay != NULL)
        {
            $arrWhere[] = array('tbl_nhatkydoi.ngaycuoituan', '>=', date('Y-m-d', strtotime($request->tungay)));
        }

        if($request->denngay != NULL)
        {
            $arrWhere[] = array('tbl_nhatkydoi.ngaydautuan', '<=', date('Y-m-d', strtotime($request->denngay)));
        }

        if($request->nhatky_status != NULL)
        {
            $arrWhere[] = array('nhatky_status', '=', $request->nhatky_status );
        }

        if($request->noidungdukien != NULL)
        {
            $arrWhere[] = array('noidungdukien', 'LIKE', '%'.$request->noidungdukien.'%' );
        }

        if($request->ketquathuchien != NULL)
        {
            $arrWhere[] = array('ketquathuchien', 'LIKE', '%'.$request->ketquathuchien.'%' );
        }
        return $arrWhere;
    }

    public static function processArrWhereTheodoinhatky($tungay_default = NULL, $denngay_default = NULL, $request)
    {
        $arrWhere = ['nhatkycanbo' => array(), 'nhatkydoi' => array() ];
        //----------------------------------NHATKYDOI------------------------------
        if($request->tungay != NULL)
        {
            $arrWhere['nhatkydoi'][] = array('tbl_nhatkydoi.ngaycuoituan', '>=', date('Y-m-d', strtotime($request->tungay)));
            $arrWhere['nhatkycanbo'][] = array('tbl_nhatkycanbo.ngay', '>=', date('Y-m-d', strtotime($request->tungay)));
        }
        else
        {
            $arrWhere['nhatkydoi'][] = array('tbl_nhatkydoi.ngaycuoituan', '>=', $tungay_default );
            $arrWhere['nhatkycanbo'][] = array('tbl_nhatkycanbo.ngay', '>=', $tungay_default );
        }

        if($request->denngay != NULL)
        {
            $arrWhere['nhatkydoi'][] = array('tbl_nhatkydoi.ngaydautuan', '<=', date('Y-m-d', strtotime($request->denngay)));
            $arrWhere['nhatkycanbo'][] = array('tbl_nhatkycanbo.ngay', '<=', date('Y-m-d', strtotime($request->denngay)));
        }
        else
        {
            $arrWhere['nhatkydoi'][] = array('tbl_nhatkydoi.ngaydautuan', '<=', $denngay_default );
            $arrWhere['nhatkycanbo'][] = array('tbl_nhatkycanbo.ngay', '<=', $denngay_default );
        }

        if($request->nhatky_status != NULL)
        {
            $arrWhere['nhatkydoi'][] = array('nhatky_status', '=', $request->nhatky_status );
            $arrWhere['nhatkycanbo'][] = array('nhatky_status', '=', $request->nhatky_status );
        }
        return $arrWhere;
    }

    public static function getListNhatkycanbo( $idcanbo, $arrWhere = array(), $paginage = 10 )
    {
        return DB::table('tbl_nhatkycanbo')
        ->where('idcanbo', $idcanbo)
        ->where($arrWhere)
        ->orderBy('ngay', 'DESC')
        ->select('tbl_nhatkycanbo.*')
        ->paginate($paginage);
    }

    public static function getFullListNhatkycanbo( $idcanbo, $arrWhere = array() )
    {
        return DB::table('tbl_nhatkycanbo')
        ->where('idcanbo', $idcanbo)
        ->where($arrWhere)
        ->orderBy('ngay', 'DESC')
        ->select('tbl_nhatkycanbo.*')
        ->get();
    }

    public static function getFullListNhatkycanboInDoi( $id_iddonvi_iddoi, $arrWhere = array() )
    {
        return DB::table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_canbo.idconnguoi', '=', 'tbl_connguoi.id')
        ->leftJoin('tbl_nhatkycanbo', 'tbl_nhatkycanbo.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_donvi_doi', 'tbl_canbo.id_iddonvi_iddoi', '=', 'tbl_donvi_doi.id')
        ->where('tbl_donvi_doi.id', $id_iddonvi_iddoi)
        ->where($arrWhere)
        ->orderBy('tbl_connguoi.order', 'ASC')
        ->orderBy('tbl_nhatkycanbo.ngay', 'DESC')
        ->select('tbl_nhatkycanbo.*', 'hoten')
        ->get();
    }

    public static function getListNhatkyDoi( $id_iddonvi_iddoi, $arrWhere = array(), $paginage = 10 )
    {
        return DB::table('tbl_nhatkydoi')
        ->where('id_iddonvi_iddoi', $id_iddonvi_iddoi)
        ->where($arrWhere)
        ->orderBy('ngaydautuan', 'DESC')
        ->select('tbl_nhatkydoi.*')
        ->paginate($paginage);
    }

    public static function getFullListNhatkyDoi( $id_iddonvi_iddoi, $arrWhere = array())
    {
        return DB::table('tbl_nhatkydoi')
        ->where('id_iddonvi_iddoi', $id_iddonvi_iddoi)
        ->where($arrWhere)
        ->orderBy('ngaydautuan', 'DESC')
        ->select('tbl_nhatkydoi.*')
        ->get();
    }

    public static function getNhatkyCBInfo($idnhatky)
    {
        return DB::table('tbl_nhatkycanbo')->where('id', $idnhatky)->first();
    }

    public static function getNhatkyDoiInfo($idnhatky)
    {
        return DB::table('tbl_nhatkydoi')->where('id', $idnhatky)->first();
    }

    public static function checkMyDateDmY($date)
    {
        $tempDate = explode('-', $date);
        return checkdate($tempDate[1], $tempDate[0], $tempDate[2]); // checkdate(month, day, year)
    }

    public static function formatNhatkycanboInDoi($list_canbo_nhatky)
    {
        $ret = [];
        foreach ($list_canbo_nhatky as $canbo_nhatky)
        {
            $ret[$canbo_nhatky->hoten][] = $canbo_nhatky;
        }
        return $ret;
    }

    public static function checkNhatkycanboExist( $idcanbo, $ngay )
    {
        if( DB::table('tbl_nhatkycanbo')->where(array( ['idcanbo', '=', $idcanbo ], ['ngay', '=', $ngay ] ))->count() > 0 )
        {
            return TRUE;
        }
        else {
            return FALSE;
        }
        
    }

    public static function checkNhatkyDoiExist( $id_iddonvi_iddoi, $ngaydautuan )
    {
        if( DB::table('tbl_nhatkydoi')->where( array( ['id_iddonvi_iddoi', '=', $id_iddonvi_iddoi ], ['ngaydautuan', '=', $ngaydautuan ] ) )->count() > 0 )
        {
            return TRUE;
        }
        else {
            return FALSE;
        }
        
    }

}
