<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\UserApp\UserLibrary;
use Redirect;
use Illuminate\Http\RedirectResponse;

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

    public static function getCongviecOfCanbo( $request, $idcanbo, $paginate_number = 10, $arrWhere = array() )
    {
        $data = DB::table( 'tbl_congviec' )
            ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
            ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec');
            if( count($arrWhere) > 0 )
            {
                $data = $data->where( $arrWhere );
            }
            $data = $data->whereRaw('tbl_congviec_chuyentiep.id = (SELECT max(id) FROM tbl_congviec_chuyentiep WHERE tbl_congviec_chuyentiep.idcongviec = tbl_congviec.id  ) ')
            ->where(function ($query) use ($idcanbo) {
                $query->where('idcanbonhan', $idcanbo)
                ->orWhere('idcanbo_creater', $idcanbo);
            })
            ->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' );

            if( $request->idstatus == 3 )
                {
                   $data = $data->orderBy('hancongviec', 'ASC');
                }
                else
                {
                    $data = $data->orderBy('tbl_congviec.id', 'DESC');
                }
                $data = $data->paginate($paginate_number, ['tbl_congviec.id']);
            
        return $data;
    }

    public static function getCongviecOfCanboQuahan($idcanbo )
    {
        $current_day = date('Y-m-d', time());
        $data = DB::table( 'tbl_congviec' )
            ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
            ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
            ->whereRaw('tbl_congviec_chuyentiep.id = (SELECT max(id) FROM tbl_congviec_chuyentiep WHERE tbl_congviec_chuyentiep.idcongviec = tbl_congviec.id  ) ')
            ->where('idstatus', 1)
            ->whereDate('hancongviec', '<=' , $current_day)
            ->where(function ($query) use ($idcanbo) {
                $query->where('idcanbonhan', $idcanbo)
                ->orWhere('idcanbo_creater', $idcanbo);
            })
            ->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
            ->orderBy('hancongviec', 'ASC');
            $data = $data->get();
        return $data;
    }

    public static function getCongviecOfDoiPhuTrachQuahan($current_idcanbo, $arrListdoi)
    {
        $current_day = date('Y-m-d', time());
        $data = DB::table( 'tbl_congviec' )
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
        ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec')
        ->whereRaw('tbl_congviec_chuyentiep.id = (SELECT max(id) FROM tbl_congviec_chuyentiep WHERE tbl_congviec_chuyentiep.idcongviec = tbl_congviec.id  ) ')
        ->where('idstatus', 1)
        ->whereDate('hancongviec', '<=' , $current_day)
        ->where(function($query) use ($arrListdoi, $current_idcanbo) {
            $query->whereIn('id_iddonvi_iddoi_nhan', $arrListdoi)
            ->orWhere('idcanbonhan', $current_idcanbo)
            ->orWhere('idcanbo_creater', $current_idcanbo);
        })
        ->select( 'tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' )
        ->orderBy('hancongviec', 'ASC');
        $data = $data->get();
        return $data;
    }

    public static function processArrWhereCongviec($request)
    {
        $arrWhere = array();
        if($request->sotailieu != NULL)
        {
            $arrWhere[] = array('sotailieu', 'LIKE', '%'.$request->sotailieu.'%');
        }

        if($request->trichyeu != NULL)
        {
            $arrWhere[] = array('trichyeu', 'LIKE', '%'.$request->trichyeu.'%');
        }

        if($request->ngaytao_tungay != NULL)
        {
            $arrWhere[] = array('tbl_congviec.created_at', '>=', date('Y-m-d', strtotime($request->ngaytao_tungay)));
        }

        if($request->ngaytao_denngay != NULL)
        {
            $arrWhere[] = array('tbl_congviec.created_at', '<=', date('Y-m-d', strtotime($request->ngaytao_denngay)));
        }

        if($request->idstatus != NULL)
        {
            if( $request->idstatus == 3 )   // Quá hạn
            {
                $current_day = date('Y-m-d', time());
                $arrWhere[] = array('idstatus', '=', 1 );
                $arrWhere[] = array('hancongviec', '<=', $current_day );
            }
            else
            {
                $arrWhere[] = array('idstatus', '=', $request->idstatus );
            }
        }

        return $arrWhere;
    }

    public static function getCongviecOfDoiPhuTrach($request, $current_idcanbo, $arrListdoi, $paginate_number = 10, $arrWhere = array())
    {
        $data = DB::table( 'tbl_congviec' )
        ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_congviec.idcanbo_creater')
        ->join('tbl_congviec_chuyentiep', 'tbl_congviec.id', '=', 'tbl_congviec_chuyentiep.idcongviec');
        if( count($arrWhere) > 0 )
        {
            $data = $data->where( $arrWhere );
        }
        $data = $data->whereRaw('tbl_congviec_chuyentiep.id = (SELECT max(id) FROM tbl_congviec_chuyentiep WHERE tbl_congviec_chuyentiep.idcongviec = tbl_congviec.id  ) ')
        ->where(function($query) use ($arrListdoi, $current_idcanbo) {
            $query->whereIn('id_iddonvi_iddoi_nhan', $arrListdoi)
            ->orWhere('idcanbonhan', $current_idcanbo)
            ->orWhere('idcanbo_creater', $current_idcanbo);
        })
        ->select('tbl_congviec.id as idcongviec', 'idcanbo_creater', 'sotailieu', 'trichyeu', 'chitiet', 'tbl_congviec.ghichu', 'noisoanthao', 'hancongviec', 'hanxuly', 'thoigiangiao', 'thoigianhoanthanh', 'idstatus', 'tbl_congviec.created_at' );
        if( $request->idstatus == config('user_config.congviec_idstatus_quahan') )
        {
            $data = $data->orderBy('hancongviec', 'ASC');
        }
        else
        {
            $data = $data->orderBy('tbl_congviec.id', 'DESC');
        }
        $data = $data->paginate($paginate_number, ['tbl_congviec.id']);
        return $data;
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

    public static function getUserMethodRoleInfo( $iduser, $method )
    {
        return DB::table('tbl_user_chucnang')
        ->join('tbl_chucnang', 'tbl_chucnang.id', '=', 'tbl_user_chucnang.idchucnang')
        ->join('tbl_level', 'tbl_level.id', '=', 'tbl_user_chucnang.idlevel')
        ->join('tbl_modules', 'tbl_modules.id', '=', 'tbl_chucnang.idmodule')
        ->where( array( ['method', '=', $method ], ['iduser', '=', $iduser], ['idmodule', '=', config('user_config.id_module_congviec') ] ) )
        ->select('keyword', 'idlevel')->first();
    }

    public static function checkPermissionCongviec($idcongviec, $iduser, $idcanbo, $method )
    {
        $data = CongviecLibrary::getUserMethodRoleInfo($iduser, $method);
        if( $data == NULL ){
            return FALSE;
        }
        if($data->idlevel == NULL || $data->idlevel == config('user_config.max_level_id') )
        {   
            return TRUE;
        }
        else
        {   
            $current_role = UserLibrary::getCanboRole($idcanbo);
            $own_congviec = CongviecLibrary::getCongviecOwner( $idcongviec );
            if( $data->keyword == 'idcanbo' )
            {
                if( in_array( $current_role['idcanbo'], $own_congviec['idcanbo'] ) )
                {
                    return TRUE;
                }
            }
            elseif( $data->keyword == 'id_iddonvi_iddoi' )
            {
                if( in_array( $current_role['idcanbo'], $own_congviec['idcanbo'] ) )
                {
                    return TRUE;
                }
                
                if( in_array( $own_congviec['id_iddonvi_iddoi'], $current_role['id_iddonvi_iddoi'] ) )
                {
                    return TRUE;
                }
            }

        }
        return FALSE;
    }



}
