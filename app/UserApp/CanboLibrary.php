<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\UserApp\UserLibrary;
use Redirect;
use Illuminate\Http\RedirectResponse;

class CanboLibrary
{
    public function __construct()
    {
        
    }

    public static function processArrWhere($request)
    {
        $arrWhere = array();
        if ($request->hoten) {
            $arrWhere[] = array('hoten', 'LIKE', '%'.$request->hoten.'%');
        }

        if ($request->email) {
            $arrWhere[] = array('email', 'LIKE', '%'.$request->email.'%');
        }

        if ($request->iddonvi && $request->iddonvi != 'all') {
            $arrWhere[] = array('tbl_donvi.id', '=', $request->iddonvi);
        }

        if ($request->iddoicongtac && $request->iddoicongtac != 'all') {
            $arrWhere[] = array('tbl_donvi_doi.id', '=', $request->iddoicongtac);
        }
        return $arrWhere;
    }

    public static function getListCanbo($arrWhere = array())
    {
        return DB::table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->join('tbl_nhomquyen', 'tbl_nhomquyen.id', '=', 'users.idnhomquyen')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->join('tbl_doicongtac', 'tbl_donvi_doi.iddoi', '=', 'tbl_doicongtac.id')
        ->join('tbl_donvi', 'tbl_donvi_doi.iddonvi', '=', 'tbl_donvi.id')
        ->where( $arrWhere )
        ->select('tbl_canbo.id', 'hoten', 'tbl_chucvu.name as tenchucvu', 'email', 'tbl_donvi.name as tendonvi', 'tbl_doicongtac.name as tendoi', 'tbl_nhomquyen.name as tennhomquyen', 'users.active', 'users.id as iduser', 'username')
        ->orderBy('tbl_canbo.id', 'desc')
        ->paginate(15);
    }

    public static function getAllListCanbo($arrWhere = array())
    {
        return DB::table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->join('tbl_nhomquyen', 'tbl_nhomquyen.id', '=', 'users.idnhomquyen')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->join('tbl_doicongtac', 'tbl_donvi_doi.iddoi', '=', 'tbl_doicongtac.id')
        ->join('tbl_donvi', 'tbl_donvi_doi.iddonvi', '=', 'tbl_donvi.id')
        ->where( $arrWhere )
        ->select('tbl_canbo.id', 'hoten', 'tbl_chucvu.name as tenchucvu', 'email', 'tbl_donvi.name as tendonvi', 'tbl_doicongtac.name as tendoi', 'tbl_nhomquyen.name as tennhomquyen', 'users.active', 'users.id as iduser', 'username')
        ->orderBy('tbl_canbo.id', 'desc')
        ->get();
    }

    public static function getCanboInfo($id, $type = 'idcanbo')
    {
        $data = DB::table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->select('username', 'tbl_canbo.id as idcanbo', 'hoten', 'idcapbac', 'idchucvu', 'email', 'id_iddonvi_iddoi', 'idnhomquyen', 'iddonvi', 'iddoi', 'tbl_donvi_doi.id as id_iddonvi_iddoi', 'active', 'users.id as userid', 'tbl_connguoi.id as idconnguoi');
        if($type = 'idcanbo')
        {
            $data = $data->where('tbl_canbo.id', $id)->first();
        }
        else
        {
            $data = $data->where('users.id', $id)->first();
        }
        return $data;
    }

    public static function getCanboFullInfo($id, $type = 'idcanbo')
    {
        $data = DB::table('tbl_canbo')
        ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_nhomquyen', 'tbl_nhomquyen.id', '=', 'users.idnhomquyen')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->leftJoin('tbl_tongiao', 'tbl_tongiao.id', '=', 'tbl_connguoi.idtongiao')
        ->leftJoin('tbl_nghenghiep', 'tbl_nghenghiep.id', '=', 'tbl_connguoi.idnghenghiep')
        ->leftJoin('tbl_dantoc', 'tbl_dantoc.id', '=', 'tbl_connguoi.iddantoc')
        ->leftJoin('tbl_capbac', 'tbl_capbac.id', '=', 'tbl_canbo.idcapbac')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->join('tbl_donvi', 'tbl_donvi.id', '=', 'tbl_donvi_doi.iddonvi')
        ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi');
        if($type = 'idcanbo')
        {
            $data = $data->where('tbl_canbo.id', $id)
            ->select('tbl_canbo.id as idcanbo', 'users.id as iduser', 'tbl_nghenghiep.name as tennghenghiep', 'tbl_dantoc.name as tendantoc', 'tbl_tongiao.name as tentongiao', 'tbl_chucvu.id as idchucvu', 'tbl_chucvu.name as tenchucvu', 'tbl_nhomquyen.name as tennhomquyen', 'tbl_connguoi.hoten', 'tbl_doicongtac.name as tendoicongtac', 'tbl_donvi.name as tendonvi', 'tbl_capbac.name as tencapbac', 'tbl_capbac.id as idcapbac', 'users.username', 'users.email')
            ->first();
        }
        else{
            $data = $data->where('users.id', $id)
            ->select('tbl_canbo.id as idcanbo', 'users.id as iduser', 'tbl_nghenghiep.name as tennghenghiep', 'tbl_dantoc.name as tendantoc', 'tbl_tongiao.name as tentongiao', 'tbl_chucvu.id as idchucvu', 'tbl_chucvu.name as tenchucvu', 'tbl_nhomquyen.name as tennhomquyen', 'tbl_connguoi.hoten', 'tbl_doicongtac.name as tendoicongtac', 'tbl_donvi.name as tendonvi', 'tbl_capbac.name as tencapbac', 'tbl_capbac.id as idcapbac', 'users.username', 'users.email')
            ->first();
        }
        return $data;
    }

    public static function getListCanboOfDoi($id_iddonvi_iddoi, $type = 'object')
    {
        $data = DB::table('tbl_canbo')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->where('id_iddonvi_iddoi', $id_iddonvi_iddoi);
        if($type = 'object')
        {
            $data = $data->select('tbl_canbo.id', 'hoten', 'tbl_chucvu.name as tenchucvu')->get()->toArray();
        }
        else{
            $data = $data->pluck('tbl_canbo.id');
        }
        return $data;
    }

    

    public static function getListDonvi($arrWhere = array())
    {
        return DB::table('tbl_donvi')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getListCapbac($arrWhere = array())
    {
        return DB::table('tbl_capbac')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getListChucvu($arrWhere = array())
    {
        return DB::table('tbl_chucvu')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getListNhomquyen($arrWhere = array())
    {
        return DB::table('tbl_nhomquyen')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getListQuocgia($arrWhere = array())
    {
        return DB::table('tbl_quocgia')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getListQuanhe($arrWhere = array())
    {
        return DB::table('tbl_moiquanhe')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getListTongiao($arrWhere = array())
    {
        return DB::table('tbl_tongiao')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getListDantoc($arrWhere = array())
    {
        return DB::table('tbl_dantoc')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getListHocvan($arrWhere = array())
    {
        return DB::table('tbl_trinhdohocvan')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getListNghenghiep($arrWhere = array())
    {
        return DB::table('tbl_nghenghiep')->where($arrWhere)->orderBy('id', 'ASC')->get();
    }

    public static function getIdConnguoi( $idcanbo )
    {
        return DB::table('tbl_canbo')->where('id', $idcanbo)->value('idconnguoi');
    }

}
