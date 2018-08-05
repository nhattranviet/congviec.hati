<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;
use Session;

class UserLibrary
{
    public function __construct()
    {
        
    }
    //-----------------------CAN BO------------------------------

    // Lấy iddonvi của cán bộ
    public static function getIdDonViOfCanBo( $idcanbo )
    {
        return DB::table('tbl_canbo')->join('tbl_donvi_doi', 'tbl_canbo.id_iddonvi_iddoi', '=', 'tbl_donvi_doi.id')->where('tbl_canbo.id', $idcanbo)->value('iddonvi');
    }
    
    // Lấy iddonvi_iddoi của lãnh đạo trong đơn vị nào đó
    public static function getIdDonviIddoiLanhdaoOfDonVi($iddonvi)
    {
        return DB::table('tbl_donvi_doi')->where( array(
            ['iddonvi', $iddonvi],
            ['iddoi', '=', config('user_config.id_doi_lanhdaodonvi')]
        ) )->value('id');
    }


    // Lấy danh sách đội thuộc quản lý của id lãnh đạo nào đó, trả về dạng mảng 1 chiều hoặc object
    public static function getListDoiLanhdaoQuanly( $idcanbo_lanhdao, $type = 'array' )
    {
        $data = DB::table('tbl_lanhdaodonvi_quanlydoi')
            ->join('tbl_canbo', 'tbl_canbo.id', '=', 'tbl_lanhdaodonvi_quanlydoi.idcanbo')
            ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_lanhdaodonvi_quanlydoi.id_iddonvi_iddoi')
            ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
            ->where('idcanbo', $idcanbo_lanhdao);
            if( $type == 'array')
            {
                $data = $data->select('tbl_donvi_doi.id')->pluck('tbl_donvi_doi.id')->toArray();
            }
            else{
                $data = $data->select('tbl_donvi_doi.id', 'tbl_doicongtac.name')->get();
            }
            return $data;
    }

    // Lấy danh sách đội thuộc đơn vị
    public static function getListDoidonVi( $iddonvi, $type = 'object' )
    {
        $data = DB::table('tbl_donvi_doi')
        ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
        ->where('iddonvi', $iddonvi );
        if( $type == 'array' )
        {
            $data = $data->pluck('tbl_donvi_doi.id');
        }
        else
        {
            $data = $data->select('name', 'tbl_donvi_doi.id')->get();
        }
        return $data;
    }

    //Lấy danh sách lãnh đạo của đơn vị
    public static function getListLanhDaoOfDonVi( $iddonvi )
    {
        $id_iddonvi_iddoi = UserLibrary::getIdDonviIddoiLanhdaoOfDonVi($iddonvi);
        return DB::table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->select('tbl_canbo.id', 'hoten', 'tbl_chucvu.name')
        ->where(array(
            ['id_iddonvi_iddoi', '=', $id_iddonvi_iddoi]
        ))
        ->get();
    }

    //Lấy iddonvi_iddoi của cán bộ, trả về object hoặc giá trị  value, array, object
    public static function getIdDonviIdDoiOfCanBo( $idcanbo, $type = '' )
    {
        $data = DB::table('tbl_canbo')
            ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
            ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
            ->where('tbl_canbo.id', $idcanbo);
            if( $type == 'value')
            {
                $data = $data->value('tbl_donvi_doi.id');
            }
            elseif( $type == 'array' )
            {
                $data = $data->pluck('tbl_donvi_doi.id')->toArray();
            }
            else
            {
                $data = $data->select('tbl_donvi_doi.id', 'tbl_doicongtac.name')->get();
            }
            
            return $data;
    }

    //Lấy iddonvi_iddoi của cán bộ, trả về object hoặc giá trị  value, array, object
    public static function getIdDonviIdDoiOfUser( $iduser, $type = '' )
    {
        $data = DB::table('tbl_canbo')
            ->join('users', 'tbl_canbo.id', '=', 'users.idcanbo')
            ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
            ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
            ->where('users.id', $iduser);
            if( $type == 'value')
            {
                $data = $data->value('tbl_donvi_doi.id');
            }
            elseif( $type == 'object' )
            {
                $data = $data->select('tbl_donvi_doi.id', 'tbl_doicongtac.name')->get();
            }
            
            return $data;
    }

    

    //-----------------------END CAN BO------------------------------


    //-----------------------USER------------------------------

    public static function getIdRoleUser($iduser)
    {
        return DB::table('users')
        ->join('tbl_nhomquyen', 'tbl_nhomquyen.id', '=', 'users.idnhomquyen')
        ->where('users.id', $iduser)
        ->value('idnhomquyen');
    }

    //-----------------------END USER--------------------------

    //-----------------------PHÂN QUYỀN------------------------

    //Get current role of canbo
    public static function getCanboRole( $idcanbo )
    {
        $canboRoleInfo['idcanbo'] = $idcanbo;
        $current_idnhomquyen = UserLibrary::getIdRoleUser( Session::get('userinfo')->iduser );
        if( $current_idnhomquyen == config('user_config.idnhomquyen_doitruong') )
        {
            $canboRoleInfo['id_iddonvi_iddoi'] = UserLibrary::getIdDonviIdDoiOfCanBo( $idcanbo, 'array' );
        }

        if( $current_idnhomquyen == config('user_config.idnhomquyen_capphodonvi') || $current_idnhomquyen == config('user_config.idnhomquyen_captruongdonvi') )
        {
            $canboRoleInfo['id_iddonvi_iddoi'] = UserLibrary::getListDoiLanhdaoQuanly( $idcanbo, 'array' );
        }
        return $canboRoleInfo;
    }

    public static function getListRole()
    {
        return DB::table('tbl_nhomquyen')->get();
    }

    public static function getListDonvi()
    {
        return DB::table('tbl_donvi')->where('loaidonvi', '!=', 'bgd')->get();
    }

    public static function getListModule()
    {
        return DB::table('tbl_modules')->get();
    }

    public static function getListLevel()
    {
        return DB::table('tbl_level')->get();
    }

    public static function getListChucnang($idmodule)
    {
        return DB::table('tbl_modules')
            ->join('tbl_chucnang', 'tbl_modules.id', '=', 'tbl_chucnang.idmodule')
            ->where('idmodule', $idmodule)
            ->select('tbl_chucnang.id', 'tbl_chucnang.name')
            ->get();
    }

    public static function getUserByDonVi( $arrDonvi )
    {
        $data = DB::table('tbl_canbo')
        ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->join('tbl_nhomquyen', 'tbl_nhomquyen.id', '=', 'users.idnhomquyen')
        ->whereIn( 'iddonvi', $arrDonvi )
        ->select('users.id as iduser', 'idnhomquyen', 'iddonvi')
        ->get()->toArray();
        return $data;
    }

    public static function getChucnangByModule( $arrModule )
    {
        $data = DB::table('tbl_chucnang')
        ->join('tbl_modules', 'tbl_chucnang.idmodule', '=', 'tbl_modules.id')
        ->whereIn( 'idmodule', $arrModule )
        ->select('tbl_chucnang.id as idchucnang')
        ->get()->toArray();
        return $data;
    }

    public static function destroyCurrentRole( $iduser, $arrModule )
    {
        $list_chucnang = DB::table('tbl_chucnang')
        ->join('tbl_modules', 'tbl_modules.id', '=', 'tbl_chucnang.idmodule')
        ->whereIn('idmodule', $arrModule)
        ->pluck('tbl_chucnang.id')->toArray();
        if( count($list_chucnang) >= 1 )
        {
            DB::table('tbl_user_chucnang')->where('iduser', $iduser )->whereIn('idchucnang', $list_chucnang)->delete();
        }
    }

    public static function getUserRoleModule($iduser, $idmodule)
    {
        return DB::table('tbl_user_chucnang')
        ->join('tbl_chucnang', 'tbl_chucnang.id', '=', 'tbl_user_chucnang.idchucnang')
        ->where(array(['iduser', '=', $iduser], ['idmodule', '=', $idmodule]))
        ->pluck('idlevel', 'idchucnang')->toArray();
    }

    //-----------------------end PHÂN QUYỀN------------------------


    //------------------HELPER-------------------------------------


    public static function vn_str_filter ($str = 'Đây là dòng để test'){
            $unicode = array(
                'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
                'd'=>'đ',
                'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
                'i'=>'í|ì|ỉ|ĩ|ị',
                'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
                'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
                'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
                'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'D'=>'Đ',
                'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
                'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
                '' => ' '
            );
            
        foreach($unicode as $nonUnicode=>$uni){
                $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
            return strtolower($str);
    }




    //------------------END HELPER--------------------


}
