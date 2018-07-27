<?php

namespace App\UserApp;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class CongviecLibrary
{
    public function __construct()
    {
        return TRUE;
    }

    public static function getDonViOfCanBo($idcanbo)
    {
        return DB::table('tbl_canbo')->join('tbl_donvi_doi', 'tbl_canbo.id_iddonvi_iddoi', '=', 'tbl_donvi_doi.id')->where('tbl_canbo.id', $idcanbo)->value('iddonvi');
    }
    
    public static function get_curr_id_iddonvi_iddoi_lanhdao($iddonvi)
    {
        return DB::table('tbl_donvi_doi')->where( array(
            ['iddonvi', $iddonvi],
            ['iddoi', '=', 2]
        ) )->value('id');
    }

    // public static function check_role_congviec($idcongviec)
    // {
    //     $congviec_info = DB::table('tbl_congviec_chuyentiep')->join('tbl_congviec', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')->whereRaw("tbl_congviec_chuyentiep.id = ( SELECT max(id) FROM tbl_congviec_chuyentiep WHERE  idcongviec = $idcongviec) ")->select('idcanbonhan', 'id_iddonvi_iddoi_nhan', 'idcanbo_creater')->first();
    //     if($congviec_info == NULL)
    //     {
    //         return FALSE;
    //     }
    //     if( Session::get('userinfo')->idcanbo == $congviec_info->idcanbo_creater )
    //     {
    //         return TRUE;
    //     }

    //     if(Session::get('userinfo')->idnhomquyen == $this->idnhomquyen_captruongdonvi || Session::get('userinfo')->idnhomquyen == $this->idnhomquyen_capphodonvi)   // lãnh đạo đơn vị
    //     {
    //         $list_doi_quanly = $this->get_id_iddonvi_iddoi_quanly( Session::get('userinfo')->idcanbo );
    //         if($list_doi_quanly == NULL)
    //         {
    //             return FALSE;
    //         }

    //         foreach( $list_doi_quanly as $doi )
    //         {
    //             if($doi->id == $congviec_info->id_iddonvi_iddoi_nhan)
    //             {
    //                 return TRUE;
    //             }
    //         }
    //         return FALSE;
    //     }
    //     elseif(Session::get('userinfo')->idnhomquyen == $this->idnhomquyen_doitruong)    // Đội trưởng
    //     {
    //         if(Session::get('userinfo')->id_iddonvi_iddoi == $congviec_info->id_iddonvi_iddoi_nhan)
    //         {
    //             return TRUE;
    //         }
    //         return FALSE;
    //     }
    //     else {  //Cán bộ và đội phó
    //         if( $congviec_info->idcanbonhan == Session::get('userinfo')->idcanbo )
    //         {
    //             return TRUE;
    //         }
    //         else
    //         {
    //             return FALSE;
    //         }
    //     }
    // }

    // public static function get_permission_user_info( $idcanbo )
    // {
    //     $permission_user_info['idcanbo'] = array( $idcanbo );
    //     $canbo_data = DB::table('users')
    //     ->join('tbl_nhomquyen', 'tbl_nhomquyen.id', '=', 'users.idnhomquyen')
    //     ->join('tbl_canbo', 'tbl_canbo.id', '=', 'users.idcanbo')
    //     ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
    //     ->where('idcanbo', $idcanbo)
    //     ->select('idnhomquyen', 'id_iddonvi_iddoi')
    //     ->first();
    //     print_r( $canbo_data ); die;
    //     if($idnhomquyen == $this->idnhomquyen_doitruong)
    //     {
    //         $permission_user_info['id_iddonvi_iddoi'] = array( Session::get('userinfo')->id_iddonvi_iddoi );
    //     }

    //     if(Session::get('userinfo')->idnhomquyen == $this->idnhomquyen_captruongdonvi || Session::get('userinfo')->idnhomquyen == $this->idnhomquyen_capphodonvi)   // lãnh đạo đơn vị
    //     {
    //         $list_doi_quanly = $this->get_id_iddonvi_iddoi_quanly( Session::get('userinfo')->idcanbo );
    //         if( $list_doi_quanly == NULL )
    //         {
    //             $permission_user_info['id_iddonvi_iddoi'] == array();
    //         }
    //         foreach( $list_doi_quanly as $doi )
    //         {
    //             $permission_user_info['id_iddonvi_iddoi'][] = $doi->id;
    //         }
    //     }
    // }

    // public static function get_id_iddonvi_iddoi_quanly( $idlanhdao )
    // {
    //     return $data['list_doicongtac'] = DB::table('tbl_lanhdaodonvi_quanlydoi')
    //         ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_lanhdaodonvi_quanlydoi.idcanbo')
    //         ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_lanhdaodonvi_quanlydoi.id_iddonvi_iddoi')
    //         ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
    //         ->where('idcanbo', $idlanhdao)
    //         ->select('tbl_donvi_doi.id', 'tbl_doicongtac.name')
    //         ->get()->toArray();
    // }


}
