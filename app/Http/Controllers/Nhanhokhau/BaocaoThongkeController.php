<?php

namespace App\Http\Controllers\Nhanhokhau;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use App\UserApp\NhanhokhauLibrary;
use App\UserApp\UserLibrary;

use App\NhanKhau;
use App\QuocGia;
use App\Relation;
use App\Religion;
use App\Nation;

use App\Education;
use App\Career;
use App\Province;
use App\District;
use App\Ward;
use App\Brief;
use App\Hokhau;
use Session;


class BaocaoThongkeController extends Controller
{
    //Khai báo các thủ tục và địa giới
    public $thutuc_capmoi = 1;
    public $thutuc_caplai = 2;
    public $thutuc_capdoi = 3;
    public $thutuc_tach = 4;
    public $thutuc_dangkynhankhau = 5;
    public $thutuc_dieuchinhthaydoi = 6;
    public $thutuc_dangkynoimoi = 11;

    public $thutucxoa_chet = 7;
    public $thutucxoa_caqd = 8;
    public $thutucxoa_huy = 9;
    public $thutucxoa_nuocngoaive = 10;
    public $thutucxoa_dangkymoi = 11;

    public $thutuc_dangkytamtru = 12;
    public $thutuc_dieuchinhthaydoi_tamtru = 13;
    public $thutuc_giahantamtru = 14;
    public $thutuc_xoatamtru = 15;
    public $thutuc_capsotamtu = 16;

    public $current_huyen = 202;
    public $current_tinh = 19;
    public $current_idquocgia = 1;
    public $current_thanhthi = [3044];
    public $ago_14_year;

    public $list_truonghopxoa;
    //End khai báo các thủ tục và địa giới
    public $data;

    public $messages = [
        'keyword.required' => ':attribute Từ khóa tìm kiếm không được trống',
        'keyword.min' => ':attribute Từ khóa tìm kiếm dài ít nhất 3 ký tự',
        'tungay.required' => ':attribute Từ ngày không được trống',
        'denngay.required' => ':attribute Đến ngày không được trống',

        'khongcutru_ho.required' => 'Số hộ không cư trút tại địa phương không được để trống',
        'khongcutru_nhankhau.required' => 'Số nhân khẩu không cư trút tại địa phương không được để trống',
        'khongcutru_nhankhauthanhthi.required' => 'Số nhân khẩu thành thị không cư trút tại địa phương không được để trống',
        'khongcutru_nhankhaunu.required' => 'Số nhân khẩu nữ không cư trút tại địa phương không được để trống',
        'khongcutru_nhankhautu14.required' => 'Số nhân khẩu từ 14 tuôi không cư trút tại địa phương không được để trống',

        'khongcutru_ho.integer' => 'Số hộ không cư trút tại địa phương phải là dạng số nguyên',
        'khongcutru_nhankhau.integer' => 'Số nhân khẩu không cư trút tại địa phương phải là dạng số nguyên',
        'khongcutru_nhankhauthanhthi.integer' => 'Số nhân khẩu thành thị không cư trút tại địa phương phải là dạng số nguyên',
        'khongcutru_nhankhaunu.integer' => 'Số nhân khẩu nữ không cư trút tại địa phương phải là dạng số nguyên',
        'khongcutru_nhankhautu14.integer' => 'Số nhân khẩu từ 14 tuôi không cư trút tại địa phương phải là dạng số nguyên',

        'khongcutru_ho.min' => 'Số hộ không cư trút tại địa phương phải là lớn hơn :min',
        'khongcutru_nhankhau.min' => 'Số nhân khẩu không cư trút tại địa phương phải là lớn hơn :min',
        'khongcutru_nhankhauthanhthi.min' => 'Số nhân khẩu thành thị không cư trút tại địa phương phải là lớn hơn :min',
        'khongcutru_nhankhaunu.min' => 'Số nhân khẩu nữ không cư trút tại địa phương phải là lớn hơn :min',
        'khongcutru_nhankhautu14.min' => 'Số nhân khẩu từ 14 tuôi không cư trút tại địa phương phải là lớn hơn :min'
    ];

    public function __construct(NhanKhau $nhankhau, QuocGia $quocgia, Relation $relation, Religion $religion
        , Nation $nation, Education $education, Career $career, Province $province, District $district
        , Ward $ward, Brief $brief, Hokhau $hokhau) {

        $this->middleware('auth');
        $this->nhankhau = $nhankhau;
        $this->quocgia = $quocgia;
        $this->relation = $relation;
        $this->religion = $religion;
        $this->nation = $nation;
        $this->education = $education;
        $this->career = $career;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
        $this->brief = $brief;
        $this->hokhau = $hokhau;
    }

    public function getBaocaonhankhau()
    {
        $data['list_tongiao'] = NhanhokhauLibrary::getListTonGiao();
        $data['list_dantoc'] = NhanhokhauLibrary::getListDanToc();
        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['educations'] = NhanhokhauLibrary::getListTrinhDoHocVan();
        $data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $data['list_xa_phuong'] = DB::connection('nhanhokhau')->table('tbl_xa_phuong_tt')->where('idhuyentx', 202)->get();
        return view('nhankhau-layouts.thuongtru.thongke', $data);
    }

    public function getBaocaonhankhauToResult(Request $request)
    {

        if( $request->ngaydangky_tungay != NULL && $request->ngaydangky_denngay != NULL && strtotime($request->ngaydangky_tungay) > strtotime($request->ngaydangky_denngay) )
        {
            return response()->json(['error' => array('Đăng ký: từ ngày phải trước Đăng ký: đến ngày')]);
        }
        if($request->ngaysinh_tungay != NULL && $request->ngaysinh_denngay != NULL && strtotime($request->ngaysinh_tungay) > strtotime($request->ngaysinh_denngay) )
        {
            return response()->json(['error' => array('Ngày sinh: từ ngày phải trước Ngày sinh: đến ngày')]);
        }
        $arrWhere = array();
        
        if($request->hoten != NULL)
        {
            $arrWhere[] = array('hoten', 'LIKE', '%'.$request->hoten.'%');
        }

        if($request->ngaydangky_tungay != NULL)
        {
            $arrWhere[] = array('ngaydangky', '>=', date('Y-m-d', strtotime($request->ngaydangky_tungay)));
        }

        if($request->ngaydangky_denngay != NULL)
        {
            $arrWhere[] = array('ngaydangky', '<=', date('Y-m-d', strtotime($request->ngaydangky_denngay)));
        }

        if($request->ngaysinh_tungay != NULL)
        {
            $arrWhere[] = array('ngaysinh', '>=', date('Y-m-d', strtotime($request->ngaysinh_tungay)));
        }

        if($request->ngaysinh_denngay != NULL)
        {
            $arrWhere[] = array('ngaysinh', '<=', date('Y-m-d', strtotime($request->ngaysinh_denngay)));
        }

        if($request->namsinh != NULL)
        {
            
        }

        if($request->gender != 'all')
        {
            $arrWhere[] = array('gioitinh', '=', $request->gender);
        }

        if($request->tienan_tiensu != 'all')
        {
            if($request->tienan_tiensu == 1)
            {
                $arrWhere[] = array('tienan_tiensu', '!=', NULL);
            }elseif ($request->tienan_tiensu == 0)
            {
                $arrWhere[] = array('tienan_tiensu', '=', NULL);
            }
        }

        if($request->cmnd_so != 'all')
        {
            if($request->cmnd_so == 1)
            {
                $arrWhere[] = array('cmnd_so', '!=', NULL);
            }
            elseif ($request->cmnd_so == 0)
            {
                $arrWhere[] = array('cmnd_so', '=', NULL);
            }
        }

        if($request->idxa_thuongtru != 'all')
        {
            $arrWhere[] = array('idxa_thuongtru', '=', $request->idxa_thuongtru);
        }
        if($request->idtongiao != 'all')
        {
            $arrWhere[] = array('idtongiao', '=', $request->idtongiao);
        }
        if($request->idnghenghiep != 'all')
        {
            $arrWhere[] = array('idnghenghiep', '=', $request->idnghenghiep);
        }
        
        $data_temp = DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where($arrWhere);
        if($request->namsinh != NULL)
        {
            $data_temp = $data_temp->whereYear('ngaysinh', $request->namsinh);
        }
        $data['briefs'] = $data_temp->select('tbl_nhankhau.*', 'tbl_hoso.hokhau_so', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.id as idhoso')
        ->paginate(10);
        $data['total'] = $data['briefs']->total();
        return response()->json(['html' => view('nhankhau-layouts.thuongtru.search_view_report', $data)->render()]);
    }


    public function getThongke()
    {
        return view('nhankhau-layouts.thuongtru.thongke_to_report');
    }

    public function getThongkeToResult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tungay' => 'required',
            'denngay' => 'required',
            'khongcutru_ho' => 'required|integer|min:0',
            'khongcutru_nhankhau' => 'required|integer|min:0',
            'khongcutru_nhankhauthanhthi' => 'required|integer|min:0',
            'khongcutru_nhankhaunu' => 'required|integer|min:0',
            'khongcutru_nhankhautu14' => 'required|integer|min:0',
        ], $this->messages);

        if ($validator->fails()) {
          return response()->json(['error' => $validator->errors()->all()]);
        }

        if( strtotime($request->tungay) > strtotime($request->denngay) )
        {
            return response()->json(['error' => array('Báo cáo từ ngày phải trước Báo cáo đến ngày')]);
        }
        
        $this->ago_14_year = date('Y-m-d', strtotime(date('Y-m-d', time()). ' - 14 years'));
        $this->data['tungay'] = $request->tungay;
        $this->data['denngay'] = $request->denngay;

        //Khong cu tru
        $this->data['khongcutru_ho'] = $request->khongcutru_ho;
        $this->data['khongcutru_nhankhau'] = $request->khongcutru_nhankhau;
        $this->data['khongcutru_nhankhauthanhthi'] = $request->khongcutru_nhankhauthanhthi;
        $this->data['khongcutru_nhankhaunu'] = $request->khongcutru_nhankhaunu;
        $this->data['khongcutru_nhankhautu14'] = $request->khongcutru_nhankhautu14;
        //End Khong cu tru

        
        $this->data['thuongtru_tongnhankhau'] = 0;
        $this->data['thuongtru_count_thanhthi'] = 0;
        $this->data['thuongtru_gioitinh_nu'] = 0;
        $this->data['thuongtru_nk_better_14'] = 0;
        $this->data['thuongtru_tongsoho'] = 0;
        
        DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_hoso.deleted_at', NULL)
        ->where('tbl_sohokhau.deleted_at', NULL)
        ->orderBy('tbl_hoso.id')
        ->select('tbl_hoso.id as idhoso', 'idxa_thuongtru', 'gioitinh', 'ngaysinh', 'idquanhechuho')
        ->chunk( 1000, function($data_nhankhau) {
            foreach ($data_nhankhau as $nhankhau) {
                $this->data['thuongtru_tongnhankhau']++;

                if( $nhankhau->idquanhechuho == 1 ) $this->data['thuongtru_tongsoho']++;

                if( in_array($nhankhau->idxa_thuongtru, $this->current_thanhthi)  ) $this->data['thuongtru_count_thanhthi']++;

                if($nhankhau->gioitinh == 0) $this->data['thuongtru_gioitinh_nu']++;

                if($nhankhau->ngaysinh <= $this->ago_14_year) $this->data['thuongtru_nk_better_14']++;
            }
        } );
        //-----------------------------TAM TRU-------------------------
        $this->data['tamtru_tongso_nhankhau'] = 0;
        $this->data['tamtru_tongso_ho'] = 0;
        $this->data['arr_id_ho_tamtru'] = array();
        $this->data['tamtru_nk_better_14_total'] = 0;
        $this->data['tamtru_count_thanhthi'] = 0;
        $this->data['tamtru_gioitinh_nu'] = 0;

        $this->data['tamtru_ngoaitinhden_nk'] = 0;
        $this->data['tamtru_ngoaitinhden_ho'] = 0;
        $this->data['tamtru_ngoaitinhden_nk_thanhthi'] = 0;
        $this->data['tamtru_ngoaitinhden_nk_nu'] = 0;
        $this->data['tamtru_ngoaitinhden_nk_tren_14'] = 0;
        $this->data['tamtru_ngoaitinh_tronghuyen_den_nk'] = 0;
        $this->data['tamtru_ngoaitinh_tronghuyen_den_ho'] = 0;
        $this->data['tamtru_ngoaitinh_tronghuyenden_nk_thanhthi'] = 0;
        $this->data['tamtru_ngoaitinh_tronghuyen_nk_nu'] = 0;
        $this->data['tamtru_ngoaitinh_tronghuyen_nk_tren_14'] = 0;
        $this->data['tamtru_ngoaixa_trongtinh_den_nk'] = 0;
        $this->data['tamtru_ngoaixa_trongtinh_den_ho'] = 0;
        $this->data['tamtru_ngoaixa_trongtinh_den_nk_thanhthi'] = 0;
        $this->data['tamtru_ngoaixa_trongtinh_den_nk_nu'] = 0;
        $this->data['tamtru_ngoaixa_trongtinh_den_nk_tren_14'] = 0;


        $denngay_Y_m_d = date('Y-m-d', strtotime($request->denngay));
        $data_tamtru_chunk = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['tbl_sotamtru.deleted_at', '=', NULL],
            ['tbl_tamtru.deleted_at', '=', NULL],
        ))
        ->whereDate('tamtru_denngay', '>=', $denngay_Y_m_d)
        ->whereDate('tamtru_tungay', '<=', $denngay_Y_m_d)
        ->orderBy('tbl_tamtru.id')
        ->select( 'sotamtru_so', 'tbl_sotamtru.type', 'idsotamtru', 'idquanhechuho', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idxa_thuongtru', 'idhuyen_thuongtru', 'idtinh_thuongtru', 'gioitinh', 'ngaysinh', 'tamtru_tungay', 'tamtru_denngay')
        ->chunk(1000, function($list_nhankhau){
            foreach($list_nhankhau as $nhankhau)
            {
                $this->data['tamtru_tongso_nhankhau']++;
                if( $nhankhau->type == 'hogiadinh' && $nhankhau->idquanhechuho == 1 ) $this->data['tamtru_tongso_ho']++;
                if($nhankhau->ngaysinh <= $this->ago_14_year)   $this->data['tamtru_nk_better_14_total']++;
                if( in_array($nhankhau->idxa_tamtru, $this->current_thanhthi) ) $this->data['tamtru_count_thanhthi']++;
                if($nhankhau->gioitinh == 0) $this->data['tamtru_gioitinh_nu']++;
                if( $nhankhau->idtinh_thuongtru != $this->current_tinh )    //Ngoài tỉnh đến
                {
                    $this->data['tamtru_ngoaitinhden_nk']++;
                    if( $nhankhau->idquanhechuho == 1)
                    {
                        $this->data['tamtru_ngoaitinhden_ho']++;
                    }
                    if( in_array($nhankhau->idxa_tamtru, $this->current_thanhthi) ) $this->data['tamtru_ngoaitinhden_nk_thanhthi']++;
                    if($nhankhau->gioitinh == 0) $this->data['tamtru_ngoaitinhden_nk_nu']++;
                    if($nhankhau->ngaysinh <= $this->ago_14_year) $this->data['tamtru_ngoaitinhden_nk_tren_14']++;
                }
                elseif($nhankhau->idhuyen_thuongtru != $this->current_huyen)    //Ngoài huyện trong tỉnh đến
                {
                    $this->data['tamtru_ngoaitinh_tronghuyen_den_nk']++;
                    if( $nhankhau->idquanhechuho == 1)
                    {
                        $this->data['tamtru_ngoaitinh_tronghuyen_den_ho']++;
                    }
                    if( in_array($nhankhau->idxa_tamtru, $this->current_thanhthi) ) $this->data['tamtru_ngoaitinh_tronghuyenden_nk_thanhthi']++;
                    if($nhankhau->gioitinh == 0) $this->data['tamtru_ngoaitinh_tronghuyen_nk_nu']++;
                    if($nhankhau->ngaysinh <= $this->ago_14_year) $this->data['tamtru_ngoaitinh_tronghuyen_nk_tren_14']++;
                }

                if( $nhankhau->idtinh_thuongtru == $this->current_tinh && $nhankhau->idxa_thuongtru != $nhankhau->idxa_tamtru ) //Ngoài xã, trong tỉnh đến
                {
                    $this->data['tamtru_ngoaixa_trongtinh_den_nk']++;
                    if( $nhankhau->idquanhechuho == 1)
                    {
                        $this->data['tamtru_ngoaixa_trongtinh_den_ho']++;
                    }
                    if( in_array($nhankhau->idxa_tamtru, $this->current_thanhthi) ) $this->data['tamtru_ngoaixa_trongtinh_den_nk_thanhthi']++;
                    if($nhankhau->gioitinh == 0) $this->data['tamtru_ngoaixa_trongtinh_den_nk_nu']++;
                    if($nhankhau->ngaysinh <= $this->ago_14_year) $this->data['tamtru_ngoaixa_trongtinh_den_nk_tren_14']++;
                }
                
            }
        });
        
        $this->list_truonghopxoa = DB::connection('nhanhokhau')->table('tbl_thutuccutru')->where('type', 'xoathuongtru')->pluck('id')->toArray();
        //History

        $this->data['thuongtru_ho_capmoi'] = 0;
        $this->data['thuongtru_ho_caplai'] = 0;
        $this->data['thuongtru_ho_capdoi'] = 0;
        $this->data['thuongtru_ho_tach'] = 0;
        $this->data['thuongtru_ho_ngoaitinh'] = 0;
        $this->data['thuongtru_ho_ngoaihuyen'] = 0;
        $this->data['thuongtru_ho_dieuchinhthaydoi'] = 0;
        $this->data['thuongtru_ho_xoa'] = 0;
        $this->data['thuongtru_ho_dangkynoimoi'] = 0;
        $this->data['thuongtru_ho_chuyenkhau_ngoaihuyen'] = 0;
        $this->data['thuongtru_ho_chuyenkhau_ngoaitinh'] = 0;
        $this->data['tamtru_dangky_ho'] = 0;
        $this->data['tamtru_ngoaitinhden_dangky_ho'] = 0;
        $this->data['thuongtru_nk_ngoaitinh'] = 0;
        $this->data['thuongtru_nk_ngoaihuyen'] = 0;
        $this->data['thuongtru_nk_ngoainuoc'] = 0;
        $this->data['thuongtru_nk_dangky'] = 0;
        $this->data['thuongtru_nk_moisinh'] = 0;
        $this->data['thuongtru_nk_dieuchinhthaydoi'] = 0;
        $this->data['thuongtru_nk_xoa'] = 0;
        $this->data['thuongtru_nk_chet'] = 0;
        $this->data['thuongtru_nk_caqd'] = 0;
        $this->data['thuongtru_nk_huy'] = 0;
        $this->data['thuongtru_nk_dangkynoimoi'] = 0;
        $this->data['thuongtru_nk_chuyenkhau_ngoaihuyen'] = 0;
        $this->data['thuongtru_nk_chuyenkhau_ngoaitinh'] = 0;
        $this->data['tamtru_dangky_nk'] = 0;
        $this->data['tamtru_ngoaitinhden_dangky_nk'] = 0;
        $this->data['tamtru_dangky_canhan_so'] = 0;
        $this->data['tamtru_giahantamtru_nk'] = 0;

        $data_history_chunk = DB::connection('nhanhokhau')->table('tbl_history_cutru')
        ->whereDate('date_action', '>=', date('Y-m-d', strtotime($request->tungay))) 
        ->whereDate('date_action', '<=', date('Y-m-d', strtotime($request->denngay)))
        ->orderBy('id')
        ->select('moisinh', 'idthutuccutru', 'type', 'idtinh_thuongtru', 'idtinh_thuongtrutruoc', 'idhuyen_thuongtrutruoc', 'idquocgia_thuongtrutruoc', 'idtinh_thuongtrumoi', 'idhuyen_thuongtrumoi')
        ->chunk(1000, function($list_history){
            foreach ($list_history as $value)
            {
                //--------------thống kê theo hộ---------------------
                if($value->type == 'hogiadinh')
                {
                    //----------THƯỜNG TRÚ-------------
                    if($value->idthutuccutru == $this->thutuc_capmoi) $this->data['thuongtru_ho_capmoi']++;
                    if($value->idthutuccutru == $this->thutuc_caplai) $this->data['thuongtru_ho_caplai']++;
                    if($value->idthutuccutru == $this->thutuc_capdoi) $this->data['thuongtru_ho_capdoi']++;
                    if($value->idthutuccutru == $this->thutuc_tach) $this->data['thuongtru_ho_tach']++;

                    if( $value->idtinh_thuongtrutruoc != NULL && $value->idtinh_thuongtrutruoc != $this->current_tinh ) $this->data['thuongtru_ho_ngoaitinh']++;
                    if($value->idhuyen_thuongtrutruoc != NULL && $value->idhuyen_thuongtrutruoc != $this->current_huyen) $this->data['thuongtru_ho_ngoaihuyen']++;
                    if($value->idthutuccutru == $this->thutuc_dieuchinhthaydoi) $this->data['thuongtru_ho_dieuchinhthaydoi']++;
                    //------------Xóa thường trú---------------
                    if( in_array( $value->idthutuccutru, $this->list_truonghopxoa ) )
                    {
                        $this->data['thuongtru_ho_xoa']++;
                        if($value->idthutuccutru == $this->thutucxoa_dangkymoi)
                        {
                            $this->data['thuongtru_ho_dangkynoimoi']++;
                            if($value->idhuyen_thuongtrumoi != NULL && $value->idhuyen_thuongtrumoi != $this->current_huyen )
                            {
                                $this->data['thuongtru_ho_chuyenkhau_ngoaihuyen']++;
                            }

                            if($value->idtinh_thuongtrumoi != NULL && $value->idtinh_thuongtrumoi != $this->current_tinh )
                            {
                                $this->data['thuongtru_ho_chuyenkhau_ngoaitinh']++;
                            }
                        }
                    }
                    //------------End xóa thường trú-----------
                    //----------END THƯỜNG TRÚ-------------


                    //-------------TẠM TRÚ
                    if( $value->idthutuccutru == $this->thutuc_capsotamtu ) $this->data['tamtru_dangky_ho']++;
                    if( $value->idtinh_thuongtru != $this->current_tinh )   //Ngoài tỉnh đến
                    {
                        if( $value->idthutuccutru == $this->thutuc_capsotamtu ) $this->data['tamtru_ngoaitinhden_dangky_ho']++;
                    }
                    //-------------END TẠM TRÚ
                }
                //--------------END thống kê theo hộ---------------------


                //--------------thống kê theo NHÂN KHẨU---------------------
                else
                {
                    //----------------THƯỜNG TRÚ
                    if( $value->idtinh_thuongtrutruoc != NULL && $value->idtinh_thuongtrutruoc != $this->current_tinh ) $this->data['thuongtru_nk_ngoaitinh']++;
                    if($value->idhuyen_thuongtrutruoc != NULL && $value->idhuyen_thuongtrutruoc != $this->current_huyen) $this->data['thuongtru_nk_ngoaihuyen']++;
                    if($value->idquocgia_thuongtrutruoc != NULL && $value->idquocgia_thuongtrutruoc != $this->current_idquocgia) $this->data['thuongtru_nk_ngoainuoc']++;

                    if($value->idthutuccutru == $this->thutuc_dangkynhankhau)
                    {
                        $this->data['thuongtru_nk_dangky']++;
                        if($value->moisinh != NULL) $this->data['thuongtru_nk_moisinh']++;
                    }

                    if($value->idthutuccutru == $this->thutuc_dieuchinhthaydoi) $this->data['thuongtru_nk_dieuchinhthaydoi']++;

                    //------------Xóa thường trú---------------
                    if( $value->idthutuccutru == $this->thutucxoa_chet )
                    {
                        $this->data['thuongtru_nk_xoa']++;
                        $this->data['thuongtru_nk_chet']++;
                    }

                    if( $value->idthutuccutru == $this->thutucxoa_caqd )
                    {
                        $this->data['thuongtru_nk_xoa']++;
                        $this->data['thuongtru_nk_caqd']++;
                    }

                    if( $value->idthutuccutru == $this->thutucxoa_huy )
                    {
                        $this->data['thuongtru_nk_xoa']++;
                        $this->data['thuongtru_nk_huy']++;
                    }

                    if( $value->idthutuccutru == $this->thutucxoa_dangkymoi )
                    {
                        $this->data['thuongtru_nk_xoa']++;
                        $this->data['thuongtru_nk_dangkynoimoi']++;
                        if($value->idhuyen_thuongtrumoi != NULL && $value->idhuyen_thuongtrumoi != $this->current_huyen )
                        {
                            $this->data['thuongtru_nk_chuyenkhau_ngoaihuyen']++;
                        }

                        if($value->idtinh_thuongtrumoi != NULL && $value->idtinh_thuongtrumoi != $this->current_tinh )
                        {
                            $this->data['thuongtru_nk_chuyenkhau_ngoaitinh']++;
                        }
                    }
                    //------------END Xóa thường trú---------------
                    //----------------END THƯỜNG TRÚ

                    //----------------TẠM TRÚ-----------------
                    if( $value->idthutuccutru == $this->thutuc_dangkytamtru ) $this->data['tamtru_dangky_nk']++;
                    if( $value->idtinh_thuongtru != $this->current_tinh )   //Ngoài tỉnh đến
                    {
                        if( $value->idthutuccutru == $this->thutuc_dangkytamtru ) $this->data['tamtru_ngoaitinhden_dangky_nk']++;
                    }
                    if( $value->idthutuccutru == $this->thutuc_capsotamtu ) $this->data['tamtru_dangky_canhan_so']++;
                    
                    if( $value->idthutuccutru == $this->thutuc_giahantamtru ) $this->data['tamtru_giahantamtru_nk']++;
                    //----------------END TẠM TRÚ-----------------
                    
                }
                //--------------END thống kê theo NHÂN KHẨU---------------------
            }
        });
        
        $html_table = view('nhankhau-layouts.ajax_component.view_report_hk15', $this->data)->render();
        $str = UserLibrary::create_docfile_landscape_hk15($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=thong-ke-".$request->tungay." den ".$request->denngay.".doc");
        echo $str;
    }

    public function getHK01($id_in_sohokhau)
    {
        $data['nhankhau'] = NhanhokhauLibrary::getChitietNhankhauFromIdInSohokhau($id_in_sohokhau);
        $html_table = view('nhankhau-layouts.ajax_component.view_report_hk01', $data)->render();
        $str = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=mau-hk-01.doc");
        echo $str;
    }

    public function getHK07(Request $request, $data_give)
    {
        $data_info = json_decode( base64_decode( $data_give ), TRUE); //dd($data_info); //getChitietNhankhauFromListIdInSohokhau
        $data['lydo'] = ($data_info['lydo'] != null) ? $data_info['lydo'] : '....................................................................................................................<br>................................................................................................................................................................' ;
        $data['noichuyenden'] = ($data_info['noichuyenden'] != null) ? $data_info['noichuyenden'] : '..............................................................................................................................<br>................................................................................................................................................................' ;
        $data['nhankhau'] = NhanhokhauLibrary::getChitietNhankhauFromIdInSohokhau($data_info['nguoichuyen']);
        $data['tenquanhechuho'] = DB::table('tbl_moiquanhe')->where('id', $data['nhankhau']->idquanhechuho)->value('name');
        $data['chuhoinfo'] = NhanhokhauLibrary::getChuho($data['nhankhau']->idhoso);
        $data['nhankhauchuyencung'] = ($data_info['nguoichuyencung'] != null) ?  NhanhokhauLibrary::getChitietNhankhauFromListIdInSohokhau($data_info['nguoichuyencung']) : NULL ; //dd($data['nhankhauchuyencung']);
        $html_table = view('nhankhau-layouts.ajax_component.view_report_hk07', $data)->render();
        $str = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=mau-hk-07_".$data['nhankhau']->hoten.".doc");
        echo $str;
    }

    public function getHK07FromIdinSohokhau(Request $request, $id_in_sohokhau)
    {
        // $idnhankhau = DB::connection('nhanhokhau')
        $data_info = json_decode( base64_decode( $data_give ), TRUE); //dd($data_info); //getChitietNhankhauFromListIdInSohokhau
        $data['lydo'] = ($data_info['lydo'] != null) ? $data_info['lydo'] : '....................................................................................................................<br>................................................................................................................................................................' ;
        $data['noichuyenden'] = ($data_info['noichuyenden'] != null) ? $data_info['noichuyenden'] : '..............................................................................................................................<br>................................................................................................................................................................' ;
        $data['nhankhau'] = NhanhokhauLibrary::getChitietNhankhauFromIdInSohokhau($data_info['nguoichuyen']);
        $data['tenquanhechuho'] = DB::table('tbl_moiquanhe')->where('id', $data['nhankhau']->idquanhechuho)->value('name');
        $data['chuhoinfo'] = NhanhokhauLibrary::getChuho($data['nhankhau']->idhoso);
        $data['nhankhauchuyencung'] = ($data_info['nguoichuyencung'] != null) ?  NhanhokhauLibrary::getChitietNhankhauFromListIdInSohokhau($data_info['nguoichuyencung']) : NULL ; //dd($data['nhankhauchuyencung']);
        $html_table = view('nhankhau-layouts.ajax_component.view_report_hk07', $data)->render();
        $str = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=mau-hk-07_".$data['nhankhau']->hoten.".doc");
        echo $str;
    }

    public function getHK03(Request $request, $id_in_sohokhau)
    {
        $data['nhankhau'] = NhanhokhauLibrary::getChitietNhankhauFromIdInSohokhau($id_in_sohokhau);
        $data['tenquanhechuho'] = DB::table('tbl_moiquanhe')->where('id', $data['nhankhau']->idquanhechuho)->value('name');
        $data['chuhoinfo'] = NhanhokhauLibrary::getChuho($data['nhankhau']->idhoso);
        $html_table = view('nhankhau-layouts.ajax_component.view_report_hk03', $data)->render();
        $str = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=mau-hk-07_".$data['nhankhau']->hoten.".doc");
        echo $str;
    }

    public function getHK04(Request $request, $id_in_sohokhau)
    {
        $data['nhankhau'] = NhanhokhauLibrary::getChitietNhankhauFromIdInSohokhau($id_in_sohokhau);
        $data['tenquanhechuho'] = DB::table('tbl_moiquanhe')->where('id', $data['nhankhau']->idquanhechuho)->value('name');
        $data['chuhoinfo'] = NhanhokhauLibrary::getChuho($data['nhankhau']->idhoso);
        $html_table = view('nhankhau-layouts.ajax_component.view_report_hk04', $data)->render();
        $str = UserLibrary::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=mau-hk-07_".$data['nhankhau']->hoten.".doc");
        echo $str;
    }

}
