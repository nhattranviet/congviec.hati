<?php

namespace App\Http\Controllers\Nhanhokhau;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use App\UserApp\NhanhokhauLibrary;


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

    //-----------THƯỜNG TRÚ------------------
    public $thuongtru_ho_capmoi = 0;
    public $thuongtru_ho_caplai = 0;
    public $thuongtru_ho_capdoi = 0;
    public $thuongtru_ho_tach = 0;
    public $thuongtru_ho_ngoaitinh = 0;
    public $thuongtru_ho_ngoaihuyen = 0;
    public $thuongtru_ho_dangkynoimoi = 0;
    public $thuongtru_ho_chuyenkhau_ngoaihuyen = 0;
    public $thuongtru_ho_chuyenkhau_ngoaitinh = 0;
    public $thuongtru_ho_xoa = 0;
    
    public $thuongtru_nk_ngoaitinh = 0;
    public $thuongtru_nk_ngoaihuyen = 0;
    public $thuongtru_nk_ngoainuoc = 0;
    public $thuongtru_nk_dangky = 0;
    public $thuongtru_nk_moisinh = 0;
    
    public $thuongtru_nk_xoa = 0;
    public $thuongtru_nk_chet = 0;
    public $thuongtru_nk_caqd = 0;
    public $thuongtru_nk_huy = 0;
    public $thuongtru_nk_dangkynoimoi = 0;

    public $thuongtru_nk_chuyenkhau_ngoaihuyen = 0;
    public $thuongtru_nk_chuyenkhau_ngoaitinh = 0;
    public $thuongtru_nk_dieuchinhthaydoi = 0;
    //-----------END THƯỜNG TRÚ------------------

    //----------------TẠM TRÚ----------------
    public $tamtru_gioitinh_nu = 0;
    public $tamtru_nk_better_14_total = 0;
    public $tamtru_tongso_ho = 0;
    public $tamtru_tongso_nhankhau = 0;
    public $tamtru_count_thanhthi = 0;
    public $arr_id_ho_tamtru = array();


    public $tamtru_ngoaitinhden_ho = 0;
    public $tamtru_ngoaitinhden_nk = 0;
    public $tamtru_ngoaitinhden_nk_thanhthi = 0;
    public $tamtru_ngoaitinhden_nk_nu = 0;
    public $tamtru_ngoaitinhden_nk_tren_14 = 0;

    public $tamtru_ngoaitinh_tronghuyen_den_nk = 0;
    public $tamtru_ngoaitinh_tronghuyen_den_ho = 0;
    public $tamtru_ngoaitinh_tronghuyenden_nk_thanhthi = 0;
    public $tamtru_ngoaitinh_tronghuyen_nk_nu = 0;
    public $tamtru_ngoaitinh_tronghuyen_nk_tren_14 = 0;

    public $tamtru_ngoaixa_trongtinh_den_nk = 0;
    public $tamtru_ngoaixa_trongtinh_den_ho = 0;

    public $tamtru_ngoaixa_trongtinh_den_nk_thanhthi = 0;
    public $tamtru_ngoaixa_trongtinh_den_nk_nu = 0;
    public $tamtru_ngoaixa_trongtinh_den_nk_tren_14 = 0;

    public $tamtru_dangky_ho = 0;
    public $tamtru_dangky_nk = 0;
    public $tamtru_ngoaitinhden_dangky_ho = 0;
    public $tamtru_ngoaitinhden_dangky_nk = 0;
    public $tamtru_dangky_canhan_so = 0;
    public $tamtru_giahantamtru_nk = 0;
    //--------------END TẠM TRÚ----------------

    

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
        // if($request->namsinh != NULL)
        // {
        //     $data_temp = $data_temp->whereYear('ngaysinh', $request->namsinh);
        // }
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
            // 'khongcutru_ho' => 'required|integer|min:0',
            // 'khongcutru_nhankhau' => 'required|integer|min:0',
            // 'khongcutru_nhankhauthanhthi' => 'required|integer|min:0',
            // 'khongcutru_nhankhaunu' => 'required|integer|min:0',
            // 'khongcutru_nhankhautu14' => 'required|integer|min:0',
        ], $this->messages);

        if ($validator->fails()) {
          return response()->json(['error' => $validator->errors()->all()]);
        }

        if( strtotime($request->tungay) > strtotime($request->denngay) )
        {
            return response()->json(['error' => array('Báo cáo từ ngày phải trước Báo cáo đến ngày')]);
        }
        
        $this->ago_14_year = date('Y-m-d', strtotime(date('Y-m-d', time()). ' - 14 years'));

        $thuongtru_tongsoho = DB::connection('nhanhokhau')->table('tbl_hoso')->where('deleted_at', NULL)->count();
        $data_sonhankhau = DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_hoso.deleted_at', NULL);
        $thuongtru_tongnhankhau = $data_sonhankhau->count();

        $thuongtru_count_thanhthi = 0;
        $thuongtru_gioitinh_nu = 0;
        $data_exec = $data_sonhankhau->select('idxa_thuongtru', 'gioitinh')->get();
        foreach ($data_exec as $value) {
            if( in_array($value->idxa_thuongtru, $this->current_thanhthi)  ) $thuongtru_count_thanhthi++;
            if($value->gioitinh == 0) $thuongtru_gioitinh_nu++;
        }

        $thuongtru_nk_better_14 = $data_sonhankhau->whereDate('ngaysinh', '<=', $this->ago_14_year)->count();
       

        //-----------------------------TAM TRU--------------------

        
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
                $this->tamtru_tongso_nhankhau++;
                // if( $nhankhau->type = 'hogiadinh' && ! in_array( $nhankhau->idsotamtru, $this->arr_id_ho_tamtru ) )
                if( $nhankhau->type == 'hogiadinh' && ! in_array( $nhankhau->idsotamtru, $this->arr_id_ho_tamtru ) )
                {
                    $this->arr_id_ho_tamtru[] = $nhankhau->idsotamtru;
                }

                if($nhankhau->ngaysinh <= $this->ago_14_year)
                {
                    $this->tamtru_nk_better_14_total++;
                }

                if( in_array($nhankhau->idxa_tamtru, $this->current_thanhthi) ) $this->tamtru_count_thanhthi++;
                if($nhankhau->gioitinh == 0) $this->tamtru_gioitinh_nu++;
                if( $nhankhau->idtinh_thuongtru != $this->current_tinh )    //Ngoài tỉnh đến
                {
                    $this->tamtru_ngoaitinhden_nk++;
                    if( $nhankhau->idquanhechuho == 1)
                    {
                        $this->tamtru_ngoaitinhden_ho++;
                    }
                    if( in_array($nhankhau->idxa_tamtru, $this->current_thanhthi) ) $this->tamtru_ngoaitinhden_nk_thanhthi++;
                    if($nhankhau->gioitinh == 0) $this->tamtru_ngoaitinhden_nk_nu++;
                    if($nhankhau->ngaysinh <= $this->ago_14_year) $this->tamtru_ngoaitinhden_nk_tren_14++;
                }
                elseif($nhankhau->idhuyen_thuongtru != $this->current_huyen)    //Ngoài huyện trong tỉnh đến
                {
                    $this->tamtru_ngoaitinh_tronghuyen_den_nk++;
                    if( $nhankhau->idquanhechuho == 1)
                    {
                        $this->tamtru_ngoaitinh_tronghuyen_den_ho++;
                    }
                    if( in_array($nhankhau->idxa_tamtru, $this->current_thanhthi) ) $this->tamtru_ngoaitinh_tronghuyenden_nk_thanhthi++;
                    if($nhankhau->gioitinh == 0) $this->tamtru_ngoaitinh_tronghuyen_nk_nu++;
                    if($nhankhau->ngaysinh <= $this->ago_14_year) $this->tamtru_ngoaitinh_tronghuyen_nk_tren_14++;
                }

                if( $nhankhau->idtinh_thuongtru == $this->current_tinh && $nhankhau->idxa_thuongtru != $nhankhau->idxa_tamtru ) //Ngoài xã, trong tỉnh đến
                {
                    $this->tamtru_ngoaixa_trongtinh_den_nk++;
                    if( $nhankhau->idquanhechuho == 1)
                    {
                        $this->tamtru_ngoaixa_trongtinh_den_ho++;
                    }
                    if( in_array($nhankhau->idxa_tamtru, $this->current_thanhthi) ) $this->tamtru_ngoaixa_trongtinh_den_nk_thanhthi++;
                    if($nhankhau->gioitinh == 0) $this->tamtru_ngoaixa_trongtinh_den_nk_nu++;
                    if($nhankhau->ngaysinh <= $this->ago_14_year) $this->tamtru_ngoaixa_trongtinh_den_nk_tren_14++;
                }
                
            }
        });
        
        // die;
        // dd($this->arr_id_ho_tamtru);
        $this->tamtru_tongso_ho = count($this->arr_id_ho_tamtru);
        
        $this->list_truonghopxoa = DB::connection('nhanhokhau')->table('tbl_thutuccutru')->where('type', 'xoathuongtru')->pluck('id')->toArray();
        //History
        
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
                    if($value->idthutuccutru == $this->thutuc_capmoi) $this->thuongtru_ho_capmoi++;
                    if($value->idthutuccutru == $this->thutuc_caplai) $this->thuongtru_ho_caplai++;
                    if($value->idthutuccutru == $this->thutuc_capdoi) $this->thuongtru_ho_capdoi++;
                    if($value->idthutuccutru == $this->thutuc_tach) $this->thuongtru_ho_tach++;

                    if( $value->idtinh_thuongtrutruoc != NULL && $value->idtinh_thuongtrutruoc != $this->current_tinh ) $this->thuongtru_ho_ngoaitinh++;
                    if($value->idhuyen_thuongtrutruoc != NULL && $value->idhuyen_thuongtrutruoc != $this->current_huyen) $this->thuongtru_ho_ngoaihuyen++;
                    if($value->idthutuccutru == $this->thutuc_dieuchinhthaydoi) $this->thuongtru_nk_dieuchinhthaydoi++;
                    //------------Xóa thường trú---------------
                    if( in_array( $value->idthutuccutru, $this->list_truonghopxoa ) )
                    {
                        $this->thuongtru_ho_xoa++;
                        if($value->idthutuccutru == $this->thutucxoa_dangkymoi)
                        {
                            $this->thuongtru_ho_dangkynoimoi++;
                            if($value->idhuyen_thuongtrumoi != NULL && $value->idhuyen_thuongtrumoi != $this->current_huyen )
                            {
                                $this->thuongtru_ho_chuyenkhau_ngoaihuyen++;
                            }

                            if($value->idtinh_thuongtrumoi != NULL && $value->idtinh_thuongtrumoi != $this->current_tinh )
                            {
                                $this->thuongtru_ho_chuyenkhau_ngoaitinh++;
                            }
                        }
                    }
                    //------------End xóa thường trú-----------
                    //----------END THƯỜNG TRÚ-------------


                    //-------------TẠM TRÚ
                    if( $value->idthutuccutru == $this->thutuc_capsotamtu ) $this->tamtru_dangky_ho++;
                    if( $value->idtinh_thuongtru != $this->current_tinh )   //Ngoài tỉnh đến
                    {
                        if( $value->idthutuccutru == $this->thutuc_capsotamtu ) $this->tamtru_ngoaitinhden_dangky_ho++;
                    }
                    //-------------END TẠM TRÚ
                }
                //--------------END thống kê theo hộ---------------------


                //--------------thống kê theo NHÂN KHẨU---------------------
                else
                {
                    //----------------THƯỜNG TRÚ
                    if( $value->idtinh_thuongtrutruoc != NULL && $value->idtinh_thuongtrutruoc != $this->current_tinh ) $this->thuongtru_nk_ngoaitinh++;
                    if($value->idhuyen_thuongtrutruoc != NULL && $value->idhuyen_thuongtrutruoc != $this->current_huyen) $this->thuongtru_nk_ngoaihuyen++;
                    if($value->idquocgia_thuongtrutruoc != NULL && $value->idquocgia_thuongtrutruoc != $this->current_idquocgia) $this->thuongtru_nk_ngoainuoc++;

                    if($value->idthutuccutru == $this->thutuc_dangkynhankhau)
                    {
                        $this->thuongtru_nk_dangky++;
                        if($value->moisinh != NULL) $this->thuongtru_nk_moisinh++;
                    }
                    if($value->idthutuccutru == $this->thutuc_dieuchinhthaydoi) $this->thuongtru_nk_dieuchinhthaydoi++;

                    //------------Xóa thường trú---------------
                    if( $value->idthutuccutru == $this->thutucxoa_chet )
                    {
                        $this->thuongtru_nk_xoa++;
                        $this->thuongtru_nk_chet++;
                    }

                    if( $value->idthutuccutru == $this->thutucxoa_caqd )
                    {
                        $this->thuongtru_nk_xoa++;
                        $this->thuongtru_nk_caqd++;
                    }

                    if( $value->idthutuccutru == $this->thutucxoa_huy )
                    {
                        $this->thuongtru_nk_xoa++;
                        $this->thuongtru_nk_huy++;
                    }

                    if( $value->idthutuccutru == $this->thutucxoa_dangkymoi )
                    {
                        $this->thuongtru_nk_xoa++;
                        $this->thuongtru_nk_dangkynoimoi++;
                        if($value->idhuyen_thuongtrumoi != NULL && $value->idhuyen_thuongtrumoi != $this->current_huyen )
                        {
                            $this->thuongtru_nk_chuyenkhau_ngoaihuyen++;
                        }

                        if($value->idtinh_thuongtrumoi != NULL && $value->idtinh_thuongtrumoi != $this->current_tinh )
                        {
                            $this->thuongtru_nk_chuyenkhau_ngoaitinh++;
                        }
                    }
                    //------------END Xóa thường trú---------------
                    //----------------END THƯỜNG TRÚ


                    //----------------TẠM TRÚ-----------------
                    if( $value->idthutuccutru == $this->thutuc_dangkytamtru ) $this->tamtru_dangky_nk++;
                    if( $value->idtinh_thuongtru != $this->current_tinh )   //Ngoài tỉnh đến
                    {
                        if( $value->idthutuccutru == $this->thutuc_dangkytamtru ) $this->tamtru_ngoaitinhden_dangky_nk++;
                    }
                    if( $value->idthutuccutru == $this->thutuc_capsotamtu ) $this->tamtru_dangky_canhan_so++;
                    
                    if( $value->idthutuccutru == $this->thutuc_giahantamtru ) $this->tamtru_giahantamtru_nk++;
                    //----------------END TẠM TRÚ-----------------
                    
                }
                //--------------END thống kê theo NHÂN KHẨU---------------------
            }
        });
        
         $html_table = '
            <style>
                table{
                    width: 100%;
                }
                table tr{
                    text-align: center;
                }

                table tr:first-child{
                    font-weight: bold;
                }

                table tr td{
                    padding: 5px;
                }
            </style>
         ';

        $html_table .= '<h5>I) HỘ, NHÂN KHẨU ĐĂNG KÝ THƯỜNG TRÚ:</h5>
        <p>Tổng số: ...  hộ; ... nhân khẩu</p>
        <p>Trong đó: ...  NK thành thị; NK nữ; NK từ 14 tuổi trở lên.</p>';

        $html_table .= '<h5>II) CÁC LOẠI HỘ, NHÂN KHẨU</h5>
        <table border="1" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="10">HỘ, NHÂN KHẨU ĐĂNG KÝ THƯỜNG TRÚ</td>
                </tr>
                <tr>
                    <td colspan="5" rowspan="2">TỔNG SỐ</td>
                    <td colspan="5">KHÔNG CƯ TRÚ TẠI NƠI ĐÃ ĐĂNG KÝ THƯỜNG TRÚ</td>
                </tr>
                <tr>
                    <td colspan="2">Tổng số</td>
                    <td rowspan="2">NK Thành thị</td>
                    <td rowspan="2">NK Nữ</td>
                    <td rowspan="2">NK từ 14 tuổi trở lên</td>
                </tr>
                <tr>
                    <td>Hộ</td>
                    <td>NK</td>
                    <td>NK Thành thị</td>
                    <td>NK Nữ</td>
                    <td>NK từ 14 tuổi trở lên</td>
                    <td>Hộ</td>
                    <td>NK</td>
                </tr>

                <tr>
                    <td>'.$thuongtru_tongsoho.'</td>
                    <td>'.$thuongtru_tongnhankhau.'</td>
                    <td>'.$thuongtru_count_thanhthi.'</td>
                    <td>'.$thuongtru_gioitinh_nu.'</td>
                    <td>'.$thuongtru_nk_better_14.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table border="1" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="15"> HỘ, NHÂN KHẨU ĐĂNG KÝ TẠM TRÚ</td>
                </tr>
                <tr>
                    <td colspan="2">Tổng số</td>
                    <td rowspan="3">NK Thành thị</td>
                    <td rowspan="3">NK Nữ</td>
                    <td rowspan="3"> NK từ 14 tuổi trởlên</td>
                    <td colspan="5">Ngoài tỉnh đến</td>
                    <td colspan="5"> Ngoài huyện trong tỉnh đến</td>
                </tr>
                <tr>
                    <td rowspan="2">Hộ</td>
                    <td rowspan="2">NK</td>
                    <td colspan="2">Tổng số</td>
                    <td rowspan="2">NK Thành thị</td>
                    <td rowspan="2">NK Nữ</td>
                    <td rowspan="2"> NK từ 14 tuổi trởlên</td>
                    <td colspan="2">Tổng số</td>
                    <td rowspan="2">NK Thành thị</td>
                    <td rowspan="2">NK Nữ</td>
                    <td rowspan="2"> NK từ 14 tuổi trởlên</td>
                </tr>
                <tr>
                    <td>Hộ</td>
                    <td>NK</td>
                    <td>Hộ</td>
                    <td>NK</td>
                </tr>
                <tr>
                    <td>'.$this->tamtru_tongso_ho.'</td>
                    <td>'.$this->tamtru_tongso_nhankhau.'</td>
                    <td>'.$this->tamtru_count_thanhthi.'</td>
                    <td>'.$this->tamtru_gioitinh_nu.'</td>
                    <td>'.$this->tamtru_nk_better_14_total.'</td>
                    <td>'.$this->tamtru_ngoaitinhden_ho.'</td>
                    <td>'.$this->tamtru_ngoaitinhden_nk.'</td>
                    <td>'.$this->tamtru_ngoaitinhden_nk_thanhthi.'</td>
                    <td>'.$this->tamtru_ngoaitinhden_nk_nu.'</td>
                    <td>'.$this->tamtru_ngoaitinhden_nk_tren_14.'</td>
                    <td>'.$this->tamtru_ngoaitinh_tronghuyen_den_ho.'</td>
                    <td>'.$this->tamtru_ngoaitinh_tronghuyen_den_nk.'</td>
                    <td>'.$this->tamtru_ngoaitinh_tronghuyenden_nk_thanhthi.'</td>
                    <td>'.$this->tamtru_ngoaitinh_tronghuyen_nk_nu.'</td>
                    <td>'.$this->tamtru_ngoaitinh_tronghuyen_nk_tren_14.'</td>
                </tr>
            </tbody>
        </table>
        <br>

        <table border="1" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="5">HỘ, NHÂN KHẨU ĐĂNG KÝ TẠM TRÚ</td>
                    <td colspan="4">NHÂN KHẨU LƯU TRÚ</td>
                    <td colspan="2">NHÂN KHẨU TẠM VẮNG</td>
                    <td rowspan="4">ĐỐI TƯỢNG QUẢN LÝ</td>
                </tr>
                <tr>
                    <td colspan="5">Ngoài xã trong tỉnhđến</td>
                    <td rowspan="3">Tổng số</td>
                    <td colspan="3">Trong đó</td>
                    <td rowspan="3">Tổng số</td>
                    <td rowspan="3">Nữ</td>
                </tr>
                <tr>
                    <td colspan="2">Tổng số</td>
                    <td rowspan="2">NK Thành thị</td>
                    <td rowspan="2">NK Nữ</td>
                    <td rowspan="2">NK từ 14 tuổi trởlên</td>
                    <td rowspan="2">Hộ gia đình</td>
                    <td rowspan="2">Cơ sở cho thuê lưutrú</td>
                    <td rowspan="2">Nữ</td>
                </tr>
                <tr>
                    <td>Hộ</td>
                    <td>NK</td>
                </tr>
                <tr>
                    <td>'.$this->tamtru_ngoaixa_trongtinh_den_ho.'</td>
                    <td>'.$this->tamtru_ngoaixa_trongtinh_den_nk.'</td>
                    <td>'.$this->tamtru_ngoaixa_trongtinh_den_nk_thanhthi.'</td>
                    <td>'.$this->tamtru_ngoaixa_trongtinh_den_nk_nu.'</td>
                    <td>'.$this->tamtru_ngoaixa_trongtinh_den_nk_tren_14.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <br>
        <h5>III) KẾT QUẢ ĐĂNG KÝ, QUẢN LÝ CƯ TRÚ</h5>
        <table border="1" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="6">ĐĂNG KÝ THƯỜNG TRÚ</td>
                    <td colspan="7">XÓA ĐĂNG KÝ THƯỜNGTRÚ</td>
                </tr>
                <tr>
                    <td colspan="2">Tổng số</td>
                    <td rowspan="2">NK mới sinh</td>
                    <td colspan="2">Ngoài tỉnh đến</td>
                    <td rowspan="2">Định cư ở nước ngoài về (NK)</td>
                    <td colspan="2">Tổng số</td>
                    <td colspan="5">Trong đó</td>
                </tr>
                <tr>
                    <td>Hộ</td>
                    <td>NK</td>
                    <td>Hộ</td>
                    <td>NK</td>
                    <td>Hộ</td>
                    <td>NK</td>
                    <td>Chết, mất tích</td>
                    <td>Tuyển dụng vào CA, QĐ</td>
                    <td>Hủy kết quả đăng ký</td>
                    <td>Định cư ở nước ngoài về</td>
                    <td>Đăng ký thường trú nơi cư trú mới</td>
                </tr>
                <tr>
                    <td>'.($this->thuongtru_ho_capmoi + $this->thuongtru_ho_tach).'</td>
                    <td>'.$this->thuongtru_nk_dangky.'</td>
                    <td>'.$this->thuongtru_nk_moisinh.'</td>
                    <td>'.$this->thuongtru_ho_ngoaitinh.'</td>
                    <td>'.$this->thuongtru_nk_ngoaitinh.'</td>
                    <td>'.$this->thuongtru_nk_ngoainuoc.'</td>
                    <td>'.$this->thuongtru_ho_xoa.'</td>
                    <td>'.$this->thuongtru_nk_xoa.'</td>
                    <td>'.$this->thuongtru_nk_chet.'</td>
                    <td>'.$this->thuongtru_nk_caqd.'</td>
                    <td>'.$this->thuongtru_nk_huy.'</td>
                    <td>0</td>
                    <td>'.$this->thuongtru_nk_dangkynoimoi.'</td>
                </tr>
            </tbody>
        </table>
        <br>
        <table  border="1" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="4">CẤP GIẤY CHUYỂN HỘ KHẨU</td>
                    <td colspan="5">CẤP MỚI, CẤP LẠI, CẤP ĐỔI, TÁCH SỔ HỘ KHẨU</td>
                    <td rowspan="3">ĐIỀU CHỈNH THAY ĐỔI (trường hợp)</td>
                </tr>
                <tr>
                    <td colspan="2">Tổng số</td>
                    <td colspan="2">Đi ngoài tỉnh</td>
                    <td rowspan="2">Tổng số</td>
                    <td colspan="4">Trong đó</td>
                </tr>
                <tr>
                    <td>Hộ</td>
                    <td>NK</td>
                    <td>Hộ</td>
                    <td>NK</td>
                    <td>Cấp mới</td>
                    <td>Cấp lại</td>
                    <td>Cấp đổi</td>
                    <td>Tách Sổ</td>
                </tr>
                <tr>
                    <td>'.$this->thuongtru_ho_dangkynoimoi.'</td>
                    <td>'.$this->thuongtru_nk_dangkynoimoi.'</td>
                    <td>'.$this->thuongtru_ho_chuyenkhau_ngoaitinh.'</td>
                    <td>'.$this->thuongtru_nk_chuyenkhau_ngoaitinh.'</td>
                    <td>'.( $this->thuongtru_ho_capmoi + $this->thuongtru_ho_caplai + $this->thuongtru_ho_capdoi + $this->thuongtru_ho_tach ).'</td>
                    <td>'.$this->thuongtru_ho_capmoi.'</td>
                    <td>'.$this->thuongtru_ho_caplai.'</td>
                    <td>'.$this->thuongtru_ho_capdoi.'</td>
                    <td>'.$this->thuongtru_ho_tach.'</td>
                    <td>'.$this->thuongtru_nk_dieuchinhthaydoi.'</td>
                </tr>
            </tbody>
        </table>
        <br>
        <table border="1" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="6">ĐĂNG KÝ TẠM TRÚ</td>
                    <td colspan="4">
                        TIẾP NHẬN THÔNG BÁOLƯU TRÚ</td>
                    <td colspan="2">KHAI BÁO TẠM VẮNG</td>
                </tr>
                <tr>
                    <td colspan="2">Tổng số</td>
                    <td colspan="2">Ngoài tỉnh đến</td>
                    <td rowspan="2">Cấp Sổ tạm trú</td>
                    <td rowspan="2">Gia hạn tạm trú</td>
                    <td rowspan="2">Tổng số (NK)</td>
                    <td colspan="3">Hình thức thông báo</td>
                    <td rowspan="2">Tổng số</td>
                    <td rowspan="2">Nữ</td>
                </tr>
                <tr>
                    <td>Hộ</td>
                    <td>NK</td>
                    <td>Hộ</td>
                    <td>NK</td>
                    <td>Trực tiếp</td>
                    <td>Điện thoại</td>
                    <td>Qua mạng</td>
                </tr>
                <tr>
                    <td>'.$this->tamtru_dangky_ho.'</td>
                    <td>'.$this->tamtru_dangky_nk.'</td>
                    <td>'.$this->tamtru_ngoaitinhden_dangky_ho.'</td>
                    <td>'.$this->tamtru_ngoaitinhden_dangky_nk.'</td>
                    <td>'.($this->tamtru_dangky_ho + $this->tamtru_dangky_canhan_so).'</td>
                    <td>'.$this->tamtru_giahantamtru_nk.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        ';
        echo $html_table; die;
        return response()->json(['html' => $html_table]);
    }
}
