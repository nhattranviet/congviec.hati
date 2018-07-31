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
            'idmodule' => config('user_config.id_module_congviec'),
            'name_object' => 'idcongviec',
            'value_object' => $idcongviec,
            'user_agent' => $request->header('User-Agent'),
            'ip' => $request->ip(),
            'content' => $content,
            'idcanbo' => Session::get('userinfo')->idcanbo,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );
        // print_r($data_log); die;
        DB::table('tbl_log')->insert($data_log);
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

    public function checkPermissionCongviec( $method, $iduser, $url_redirect = '/' , $message = 'Bạn không có quyền ở đây' )
    {
        $data = DB::table('tbl_user_chucnang')
        ->join('tbl_chucnang', 'tbl_chucnang.id', '=', 'tbl_user_chucnang.idchucnang')
        ->join('tbl_level', 'tbl_level.id', '=', 'tbl_user_chucnang.idlevel')
        ->where( array( ['method', '=', $method ], ['iduser', '=', $iduser] ) )
        ->select('keyword', 'idlevel')->first()->roArray();
    }

    


}
