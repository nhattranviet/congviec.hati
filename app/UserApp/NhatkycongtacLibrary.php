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
            'noidungdukien.required' => 'Nội dung dự kiến không được để trống',
        ];
    }

    public static function processArrWhereIndex($request)
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

    public static function getListNhatkycanbo( $idcanbo, $arrWhere = array(), $paginage = 10 )
    {
        return DB::table('tbl_nhatkycanbo')
        ->where('idcanbo', $idcanbo)
        ->where($arrWhere)
        ->orderBy('ngay', 'DESC')
        ->select('tbl_nhatkycanbo.*')
        ->paginate($paginage);
    }

    public static function checkMyDateDmY($date)
    {
        $tempDate = explode('-', $date);
        return checkdate($tempDate[1], $tempDate[0], $tempDate[2]); // checkdate(month, day, year)
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

}
