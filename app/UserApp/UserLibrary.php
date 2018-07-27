<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;

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
            }else{
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


}
