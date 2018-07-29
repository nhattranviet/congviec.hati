<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\UserApp\UserLibrary;

class CongviecLibrary
{
    public function __construct()
    {
        
    }

    public static function getIdCanboXulybandau( $idcongviec )
    {
        return DB::table('tbl_congviec_chuyentiep')->where( array(
            ['idcongviec', '=', $idcongviec],
            ['order', '=', 0],
        ) )->value('idcanbonhan');
    }

    public static function getCongviecInfo( $idcongviec )
    {
        return DB::table('tbl_congviec')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('tbl_congviec.id',$idcongviec)
        ->select('tbl_congviec.*', 'hoten')->first();
    }

    public static function getCongviecChuyentiepInfo ($idcongviec)
    {
        return DB::table('tbl_congviec_chuyentiep')
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec_chuyentiep.idcanbonhan')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->where('idcongviec', $idcongviec)
        ->orderBy('timechuyentiep', 'ASC')
        ->select('tbl_congviec_chuyentiep.*', 'hoten')
        ->get()->toArray();
    }

    public static function getMaxNode( $idcongviec )
    {
        return DB::table('tbl_congviec_chuyentiep')->where('idcongviec',$idcongviec)->max('id');
    }

    public static function logCongviec($request, $idcongviec, $content )
    {
        $data_log = array(
            'idcongviec' => $idcongviec,
            'user_agent' => $request->header('User-Agent'),
            'ip' => $request->ip(),
            'content' => $content,
            'idcanbo' => Session::get('userinfo')->idcanbo,
            'username' => Session::get('userinfo')->username,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );
        DB::table('tbl_congviec_log')->insert($data_log);
    }

    public static function getCongviecOwner($idcongviec)
    {
        $own = array();
        $congviec_info = DB::table( 'tbl_congviec' )
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
        ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
        ->where( 'tbl_congviec.id', $idcongviec)
        ->whereRaw('tbl_congviec_chuyentiep.id = (SELECT max(id) FROM tbl_congviec_chuyentiep WHERE tbl_congviec_chuyentiep.idcongviec = tbl_congviec.id  ) ')
        ->select( 'idcanbo_creater', 'idcanbonhan', 'id_iddonvi_iddoi_nhan' )
        ->first();
        $own['idcanbo'] = array( $congviec_info->idcanbo_creater, $congviec_info->idcanbonhan );

        $own['id_iddonvi_iddoi'] = $congviec_info->id_iddonvi_iddoi_nhan;
        return $own;
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

    


}
