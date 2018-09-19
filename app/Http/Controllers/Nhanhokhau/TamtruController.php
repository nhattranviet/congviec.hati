<?php

namespace App\Http\Controllers\Nhanhokhau;
use App\Http\Controllers\Controller;
use App\Rules\NhankhauRule;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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

use App\UserApp\NhanhokhauLibrary;
use App\UserApp\TamtruLibrary;

class TamtruController extends Controller
{
    public $thutuc_dangkytamtru = 12;
    public $thutuc_dieuchinhthaydoi_tamtru = 13;
    public $thutuc_giahantamtru = 14;
    public $thutuc_xoatamtru = 15;
    public $thutuc_capsotamtu = 16;

    function __construct(NhanKhau $nhankhau, QuocGia $quocgia, Relation $relation, Religion $religion
        , Nation $nation, Education $education, Career $career, Province $province, District $district
        , Ward $ward, Brief $brief, Hokhau $hokhau) {
        // $this->middleware('auth');
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $data['briefs'] = TamtruLibrary::getTamtruDataIndex($request->keyword);
        if( $request->ajax() )
        {
            return response()->json(['html' => view('nhankhau-layouts.ajax_component.tamtru_nhankhautable', $data)->render()]);
        }
        return view('nhankhau-layouts.tamtru.index', $data);
    }

    public function getChitietSotamtru($idsotamtru)
    {
        $data['list_thongtinsotamtru'] = TamtruLibrary::getChitietSotamtru($idsotamtru);
        $data['idsotamtru'] = $idsotamtru;
        return view('nhankhau-layouts.tamtru.chitiethosotamtru', $data);
    }

    public function getChitietnhankhauTamtru($idnhankhau, $idsotamtru)
    {
        $data['nhankhau'] = TamtruLibrary::getChitietNhankhauTamtru($idnhankhau, $idsotamtru);
        return view('nhankhau-layouts.tamtru.chitietnhankhautamtru', $data);
    }

    public function getAddnhankhau($idsotamtru)
    {
        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));

        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHeNotChuHo();
        $data['sotamtru'] = TamtruLibrary::getChitietSotamtru($idsotamtru, TRUE);
        return view('nhankhau-layouts.tamtru.addnhankhau', $data);
    }

    public function postAddnhankhau(Request $request, $idsotamtru)
    {
        $validator = Validator::make($request->all(), TamtruLibrary::getPostAddnhankhauRule(), TamtruLibrary::getMessageRule());
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $sotamtru_info = TamtruLibrary::getChitietSotamtru($idsotamtru, TRUE);
        $idnhankhau = TamtruLibrary::insertNhankhauTamtruToNhanKhauTable($request, $sotamtru_info, TRUE);
        TamtruLibrary::insertDataTamtru($request, $idsotamtru, $idnhankhau);
        $data_log = array(
            'idthutuccutru' => $this->thutuc_dangkytamtru, 'type' => 'nhankhau', 'idnhankhau' => $idnhankhau, 'idsotamtru' => $idsotamtru, 'date_action' => date('Y-m-d', strtotime($request->ngaydangky)),
            'idquocgia_thuongtru' => $sotamtru_info->idquocgia_thuongtru, 'idtinh_thuongtru' => $sotamtru_info->idtinh_thuongtru, 'idhuyen_thuongtru' => $sotamtru_info->idhuyen_thuongtru, 'idxa_thuongtru' => $sotamtru_info->idxa_thuongtru, 'chitiet_thuongtru' => $sotamtru_info->chitiet_thuongtru,
            'idquocgia_tamtru' => $sotamtru_info->idquocgia_tamtru, 'idtinh_tamtru' => $sotamtru_info->idtinh_tamtru, 'idhuyen_tamtru' => $sotamtru_info->idhuyen_tamtru, 'idxa_tamtru' => $sotamtru_info->idxa_tamtru, 'chitiet_tamtru' => $sotamtru_info->chitiet_tamtru,
        );
        NhanhokhauLibrary::logCutru($data_log);
        return response()->json(['success' => 'Đăng ký thường trú thành công ', 'url' => route('chi-tiet-so-tam-tru', $idsotamtru)]);
    }

    public function getSuanhankhau($idnhankhau, $idsotamtru)
    {
        $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $data['nhankhau'] = TamtruLibrary::getChitietNhankhauTamtru($idnhankhau, $idsotamtru);

        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));
        return view('nhankhau-layouts.tamtru.editnhankhau', $data);
    }

    public function postSuanhankhau(Request $request, $idnhankhau, $idsotamtru)
    {
        $validator = Validator::make($request->all(), TamtruLibrary::getPostSuanhankhauRule($idsotamtru), TamtruLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $data_sotamtru = array(
            'sotamtru_so' => $request->sotamtru_so,
            'idquocgia_tamtru' => $request->idquocgia_tamtru,
            'idtinh_tamtru' => $request->idtinh_tamtru,
            'idhuyen_tamtru' => $request->idhuyen_tamtru,
            'idxa_tamtru' => $request->idxa_tamtru,
            'chitiet_tamtru' => $request->chitiet_tamtru,
            'ngaydangky' => date('Y-m-d', strtotime($request->ngaydangky)),
            'updated_at' => Carbon::now(),
        );
        DB::connection('nhanhokhau')->table('tbl_sotamtru')->where( 'id',$idsotamtru )->update( $data_sotamtru );

        TamtruLibrary::updateNhankhauTamtru($request, $idnhankhau);

        $data_tamtru = array(
            'tamtru_tungay' => date('Y-m-d', strtotime($request->tamtru_tungay)),
            'tamtru_denngay' => date('Y-m-d', strtotime($request->tamtru_denngay)),
        );

        DB::connection('nhanhokhau')->table('tbl_tamtru')->where('id', $request->idtamtru)->update($data_tamtru);

        //--------------Ghi log cua ho so----------------------
        
        $data_log = array(
            'idthutuccutru' => $this->thutuc_dieuchinhthaydoi_tamtru,
            'type' => 'nhankhau',
            'idsotamtru' => $idsotamtru,
            'idnhankhau' => $idnhankhau,
            'date_action' => date('Y-m-d', strtotime($request->ngaysua)),
            'ghichu' => $request->ghichu,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log );
        //--------------End ghi log cua ho so----------------------

        return response()->json(['success' => 'Đăng ký thường trú thành công ', 'url' => route('chi-tiet-so-tam-tru', $idsotamtru)]);
    }

    public function getAddSoTamTruCaNhan()
    {
        $data['educations'] = NhanhokhauLibrary::getListTrinhDoHocVan();
        $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['careers'] = NhanhokhauLibrary::getListNgheNghiep();

        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));
        return view('nhankhau-layouts.tamtru.add_sotamtrucanhan', $data);
    }

    public function postAddSoTamTruCaNhan(Request $request)
    {
        $validator = Validator::make($request->all(), TamtruLibrary::getPostAddSoTamTruCaNhanRule(), TamtruLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }
        $id_sotamtru = TamtruLibrary::insertDataSotamtru( $request, 'nhankhau' );
        $id_nhankhau = TamtruLibrary::postAddNhankhauSoTamTruCaNhan($request);
        TamtruLibrary::addTamtruCaNhan($request, $id_sotamtru, $id_nhankhau);
        //------------------Log nhan khau
        $data_log_nhankhau = array(
            'idthutuccutru' => $this->thutuc_dangkytamtru,
            'type' => 'nhankhau',
            'idnhankhau' => $id_nhankhau,
            'idsotamtru' => $id_sotamtru,
            'date_action' => date('Y-m-d', strtotime($request->ngaydangky)),
            'created_at' => Carbon::now(),
            'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
            'idtinh_thuongtru' => $request->idtinh_thuongtru,
            'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
            'idxa_thuongtru' => $request->idxa_thuongtru,
            'chitiet_thuongtru' => $request->idxa_thuongtru,
            'idquocgia_tamtru' => $request->idquocgia_tamtru,
            'idtinh_tamtru' => $request->idtinh_tamtru,
            'idhuyen_tamtru' => $request->idhuyen_tamtru,
            'idxa_tamtru' => $request->idxa_tamtru,
            'chitiet_tamtru' => $request->chitiet_tamtru,
        );
        NhanhokhauLibrary::logCutru($data_log_nhankhau);

        $data_log_sotamtru = array(
            'idthutuccutru' => $this->thutuc_capsotamtu, 'type' => 'nhankhau', 'idnhankhau' => $id_nhankhau, 'idsotamtru' => $id_sotamtru,
            'date_action' => date('Y-m-d', strtotime($request->ngaydangky)), 'created_at' => Carbon::now(),
            'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
            'idtinh_thuongtru' => $request->idtinh_thuongtru,
            'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
            'idxa_thuongtru' => $request->idxa_thuongtru,
            'chitiet_thuongtru' => $request->idxa_thuongtru,
            'idquocgia_tamtru' => $request->idquocgia_tamtru,
            'idtinh_tamtru' => $request->idtinh_tamtru,
            'idhuyen_tamtru' => $request->idhuyen_tamtru,
            'idxa_tamtru' => $request->idxa_tamtru,
            'chitiet_tamtru' => $request->chitiet_tamtru,
        );
        NhanhokhauLibrary::logCutru($data_log_sotamtru);
        return response()->json(['success' => 'Thêm nhân khẩu thành công ', 'url' => route('tam-tru.index')]);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['educations'] = NhanhokhauLibrary::getListTrinhDoHocVan();
        $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['careers'] = NhanhokhauLibrary::getListNgheNghiep();

        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));

        return view('nhankhau-layouts.tamtru.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), TamtruLibrary::getStoreRule(), TamtruLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }
        
        $num = $this->checkexistChuho( $request->idquanhechuho );
        if($num == 0)
        {
            return response()->json(['error' => array('Trong hồ sơ chủ hộ không được trống')]);
        }
        elseif($num > 1)
        {
            return response()->json(['error' => array('Chủ hộ chỉ được duy nhất 01 người')]);
        }
        $id_sotamtru = TamtruLibrary::insertDataSotamtru($request, 'hogiadinh');
        //--------------------Log tạm trú hộ gia đình---------------------------
        $data_log = array(
            'idthutuccutru' => $this->thutuc_capsotamtu,
            'type' => 'hogiadinh',
            'idsotamtru' => $id_sotamtru,
            'date_action' => date('Y-m-d', strtotime($request->ngaydangky)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
            'idtinh_thuongtru' => $request->idtinh_thuongtru,
            'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
            'idxa_thuongtru' => $request->idxa_thuongtru,
            'chitiet_thuongtru' => $request->idxa_thuongtru,

            'idquocgia_tamtru' => $request->idquocgia_tamtru,
            'idtinh_tamtru' => $request->idtinh_tamtru,
            'idhuyen_tamtru' => $request->idhuyen_tamtru,
            'idxa_tamtru' => $request->idxa_tamtru,
            'chitiet_tamtru' => $request->idxa_tamtru,
        );
        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log );
        //--------------------End Log tạm trú hộ gia đình-----------------------

        $num_nhankhau = count($request->hoten);
        for ($i=0; $i < $num_nhankhau; $i++)
        {
            $id_nhankhau = TamtruLibrary::insertArrNhankhau($request, $i);
            TamtruLibrary::arrDataTamTru($request, $i, $id_sotamtru, $id_nhankhau);
            //------------------Log nhan khau
            $data_log_nhankhau = array(
                'idthutuccutru' => $this->thutuc_dangkytamtru,
                'type' => 'nhankhau',
                'idnhankhau' => $id_nhankhau,
                'idsotamtru' => $id_sotamtru,
                'date_action' => date('Y-m-d', strtotime($request->ngaydangky)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

                'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
                'idtinh_thuongtru' => $request->idtinh_thuongtru,
                'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
                'idxa_thuongtru' => $request->idxa_thuongtru,
                'chitiet_thuongtru' => $request->idxa_thuongtru,

                'idquocgia_tamtru' => $request->idquocgia_tamtru,
                'idtinh_tamtru' => $request->idtinh_tamtru,
                'idhuyen_tamtru' => $request->idhuyen_tamtru,
                'idxa_tamtru' => $request->idxa_tamtru,
                'chitiet_tamtru' => $request->chitiet_tamtru,
            );
            DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log_nhankhau );
            //------------------End log nhan khau
        }
        return response()->json(['success' => 'Thêm nhân khẩu thành công ', 'url' => route('tam-tru.index')]);

    }

    public function getXoaTamTruNhanKhau($idnhankhau, $idsotamtru)
    {
        if( DB::connection('nhanhokhau')->table('tbl_tamtru')->where( array(['idnhankhau', '=', $idnhankhau ], ['idsotamtru', '=', $idsotamtru], ['type', '=', 'hogiadinh']) )->value('idquanhechuho') == 1 )
        {
            $message = array('type' => 'warning', 'content' => 'Người này là chủ hộ, bạn phải thay chủ hộ trước khi xóa tạm trú');
            return redirect()->route('get-thay-doi-chu-ho-tam-tru', $idsotamtru)->with('alert_message', $message);
        }
        $data['nhankhau'] = TamtruLibrary::getChitietNhankhauTamtru($idnhankhau, $idsotamtru);
        $data['idnhankhau'] = $idnhankhau;
        $data['idsotamtru'] = $idsotamtru;
        return view('nhankhau-layouts.tamtru.check_xoatamtrunhankhau', $data);
    }

    public function postXoaTamTruNhanKhau(Request $request, $idnhankhau, $idsotamtru)
    {
        $validator = Validator::make($request->all(), [
            'ngayxoa' => 'required|date_format:d-m-Y',
            'ghichu' => 'required',
        ], TamtruLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $data_tamtru = array(
            'lydoxoa' => $request->ghichu,
            'deleted_at' => date('Y-m-d', strtotime($request->ngayxoa)),
        );

        DB::connection('nhanhokhau')->table('tbl_tamtru')->where(array(
            ['idnhankhau', '=', $idnhankhau],
            ['idsotamtru', '=', $idsotamtru],
        ))->update( $data_tamtru );

        $data_log_nhankhau = array(
            'idthutuccutru' => $this->thutuc_xoatamtru,
            'type' => 'nhankhau',
            'idnhankhau' => $idnhankhau,
            'idsotamtru' => $idsotamtru,
            'date_action' => date('Y-m-d', strtotime($request->ngayxoa)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ghichu' => $request->ghichu,
        );
        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log_nhankhau );

        $num_nhankhau_exists = DB::connection('nhanhokhau')->table('tbl_tamtru')->where(array(
            ['idsotamtru', '=', $idsotamtru],
            ['tbl_tamtru.deleted_at', '=', NULL],
        ))->count();
        if($num_nhankhau_exists  == 0)
        {
            $delete_update = array(
                'deleted_at' => $data_log_nhankhau['date_action']
            );
            DB::connection('nhanhokhau')->table('tbl_sotamtru')->where('id', $idsotamtru)->update( $delete_update );
        }
        return response()->json(['success' => 'Thành công ', 'url' => route('chi-tiet-so-tam-tru',$idsotamtru)]);
    }

    public function getXoaTamTruSo($idsotamtru)
    {
        $data['list_thongtinhokhau'] = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->join('tbl_nhankhau', 'tbl_tamtru.idnhankhau', '=', 'tbl_nhankhau.id')
        ->where( array(['idsotamtru', '=', $idsotamtru], ['tbl_tamtru.deleted_at', '=', NULL]) )
        ->select('hoten', 'sotamtru_so', 'idquanhechuho', 'idtinh_tamtru', 'idhuyen_tamtru', 'idxa_tamtru', 'chitiet_tamtru')
        ->get(); dd($data['list_thongtinhokhau']);
        $data['idsotamtru'] = $idsotamtru;
        // $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        // $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        // $data['nations'] = NhanhokhauLibrary::getListDanToc();
        
        return view('nhankhau-layouts.tamtru.check_xoatamtruSo', $data);
    }

    public function xoaThuongtruHGD(Request $request, $idhoso)
    {
        $validator = Validator::make($request->all(), [
            'idtruonghopxoa' => 'required',
            'ngayxoathuongtru' => 'required',
            'idquocgia_thuongtrumoi' => 'required_if:idtruonghopxoa,'.$this->thutuc_xoa_dangkynoimoi,
            'idtinh_thuongtrumoi' => 'required_if:idquocgia_thuongtrumoi,1',
            'idhuyen_thuongtrumoi' => 'required_if:idquocgia_thuongtrumoi,1',
            'idxa_thuongtrumoi' => 'required_if:idquocgia_thuongtrumoi,1',
        ], NhanhokhauLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $list_nhankhau_info = DB::connection('nhanhokhau')->table('tbl_sohokhau')->where(array(['idhoso', '=', $idhoso], ['deleted_at', '=', NULL]))->orderBy('idquanhechuho', 'ASC')->pluck('idnhankhau', 'id')->toArray();
        if(count($list_nhankhau_info) < 1)
        {
            return response()->json(['error' => array('Hộ xóa không có nhân khẩu!')]);
        }
        $list_nhankhau_id = array_values($list_nhankhau_info);
        $list_id_in_sohokhau = array_keys($list_nhankhau_info);
        $idnguoixoa = $list_id_in_sohokhau[0];
        $arr_nguoixoacung = array_diff($list_id_in_sohokhau, array($idnguoixoa));
        $arr_nguoixoacung = (count($arr_nguoixoacung) > 0 && !empty( $arr_nguoixoacung )) ? $arr_nguoixoacung : NULL;
        $data_hoso = array(
            'deleted_at' => date('Y-m-d', strtotime($request->ngayxoathuongtru)),
        );
        DB::connection('nhanhokhau')->table('tbl_hoso')->where('id',$idhoso)->update($data_hoso);
        DB::connection('nhanhokhau')->table('tbl_sohokhau')->where( array( ['idhoso', '=', $idhoso], ['tbl_sohokhau.deleted_at', '=', NULL] ) )->update($data_hoso);

        $noiden = NULL;
        if($request->idtruonghopxoa == $this->thutuc_xoa_dangkynoimoi)
        {
            $data_update = array(
                'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
                'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
                'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
                'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
                'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
            );
            DB::connection('nhanhokhau')->table('tbl_nhankhau')->whereIn('id', $list_nhankhau_id)->update($data_update);
            $noiden = $request->chitiet_thuongtrumoi.' - '.(($request->idxa_thuongtrumoi) ? DB::table('tbl_xa_phuong_tt')->where('id', $request->idxa_thuongtrumoi)->value('name') : '' ).' - '.(($request->idhuyen_thuongtrumoi) ? DB::table('tbl_huyen_tx')->where('id', $request->idhuyen_thuongtrumoi)->value('name') : '').' - '.(($request->idtinh_thuongtrumoi) ? DB::table('tbl_tinh_tp')->where('id', $request->idtinh_thuongtrumoi)->value('name') : '');
        }
        $created_at = Carbon::now();
        $updated_at = Carbon::now();
        $data_log_hogiadinh = array(
            'idthutuccutru' => $request->idtruonghopxoa, 'type' => 'hogiadinh', 'idhoso' => $idhoso, 'date_action' => date('Y-m-d', strtotime($request->ngayxoathuongtru)),
            'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
            'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
            'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
            'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
            'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
            'ghichu' => $request->lydoxoa,
            'created_at' => $created_at, 'updated_at' => $updated_at,
        );
        NhanhokhauLibrary::logCutru($data_log_hogiadinh);

        $data_log_nhankhau = array();
        foreach ($list_nhankhau_id as $value)
        {
            $data_log = array(
                'idthutuccutru' => $request->idtruonghopxoa,
                'type' => 'nhankhau', 'idnhankhau' => $value, 'idhoso' => $idhoso,
                'date_action' => date('Y-m-d', strtotime($request->ngayxoathuongtru)),
                'created_at' => $created_at, 'updated_at' => $updated_at,
                'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
                'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
                'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
                'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
                'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
                'ghichu' => $request->lydoxoa
            );
            $data_log_nhankhau[] = $data_log;
        }
        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log_nhankhau );
        $arr_ret = ['success' => 'Xóa đăng ký thường trú thành công', 'url' => route('nhan-khau.index')];
        if($request->idtruonghopxoa == $this->thutuc_xoa_dangkynoimoi)
        {
            $data_to_get_hk07 = base64_encode( json_encode( ['lydo' => $request->lydoxoa, 'noichuyenden' => $noiden, 'nguoichuyen' => $idnguoixoa, 'nguoichuyencung' => $arr_nguoixoacung ] ) );
            $arr_ret['url_second'] =  route('get-hk-07', ['data' => $data_to_get_hk07]);
        }
        return response()->json($arr_ret);
    }

    public function getThaydoichuho( $idsotamtru )
    {
        $data['list_nhankhau'] = TamtruLibrary::getChitietSotamtru($idsotamtru);
        $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['idsotamtru'] = $idsotamtru;
        return view('nhankhau-layouts.tamtru.thaydoichuho', $data);
    }

    public function postThaydoichuho(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'idquanhechuho.*' => 'required'
        ], TamtruLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $num = $this->checkexistChuho($request->idquanhechuho);
        if($num == 0)
        {
            return response()->json(['error' => array('Chủ hộ bắt buộc phải chọn')]);
        }
        elseif($num > 1)
        {
            return response()->json(['error' => array('Chủ hộ chỉ được duy nhất 01 người')]);
        }

        for($i = 0; $i < count($request->id_in_sotamtru); $i++)
        {
            DB::connection('nhanhokhau')->table('tbl_tamtru')->where('id',$request->id_in_sotamtru[$i])->update(['idquanhechuho' => $request->idquanhechuho[$i]]);
        }

        return response()->json(['success' => 'Thay đổi quan hệ chủ hộ thành công ', 'url' => route('chi-tiet-so-tam-tru', $id)]);
    }

    public function getGiaHanTamTruNhanKhau($idnhankhau, $idsotamtru)
    {
        $data['nhankhau'] = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['idnhankhau', '=', $idnhankhau],
            ['idsotamtru', '=', $idsotamtru]
        ))
        ->select('tbl_sotamtru.id as idsotamtru', 'ngaysinh', 'gioitinh', 'idquoctich', 'iddantoc', 'tamtru_tungay', 'tamtru_denngay', 'tbl_nhankhau.hoten', 'tbl_sotamtru.sotamtru_so', 'tbl_tamtru.idquanhechuho', 'chitiet_tamtru', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idquocgia_tamtru', 'idnhankhau', 'chitiet_thuongtru', 'idxa_thuongtru', 'idhuyen_thuongtru', 'idtinh_thuongtru', 'idquocgia_thuongtru' , 'chitiet_noilamviec', 'idxa_noilamviec', 'idhuyen_noilamviec', 'idtinh_noilamviec', 'idquocgia_noilamviec', 'chitiet_nguyenquan', 'idxa_nguyenquan', 'idhuyen_nguyenquan', 'idtinh_nguyenquan', 'idquocgia_nguyenquan' )
        ->first();
        $data['idnhankhau'] = $idnhankhau;
        $data['idsotamtru'] = $idsotamtru;
        return view('nhankhau-layouts.tamtru.giahan_tamtrunhankhau', $data);
    }

    public function postGiaHanTamTruNhanKhau(Request $request, $idnhankhau, $idsotamtru)
    {
        $validator = Validator::make($request->all(), [
            'ngaygiahan' => 'required|date_format:d-m-Y',
            'ghichu' => 'required',
            'giahan_denngay' => 'required',
        ], TamtruLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $data_tamtru = array(
            'tamtru_denngay' => date('Y-m-d', strtotime($request->giahan_denngay)),
        );

        DB::connection('nhanhokhau')->table('tbl_tamtru')->where(array(
            ['idnhankhau', '=', $idnhankhau],
            ['idsotamtru', '=', $idsotamtru],
        ))->update( $data_tamtru );

        $data_log_nhankhau = array(
            'idthutuccutru' => $this->thutuc_giahantamtru,
            'type' => 'nhankhau',
            'idnhankhau' => $idnhankhau,
            'idsotamtru' => $idsotamtru,
            'date_action' => date('Y-m-d', strtotime($request->ngaygiahan)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ghichu' => $request->ghichu,
        );
        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert($data_log_nhankhau);

        return response()->json(['success' => 'Thành công ', 'url' => route('tam-tru.index')]);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idsotamtru) {
        $data['sotamtru'] = DB::connection('nhanhokhau')->table('tbl_sotamtru')->where('id',$idsotamtru)->first();
        return view('nhankhau-layouts.tamtru.edithoso', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Chưa làm xong
    public function update(Request $request, $idsotamtru)
    {
        $validator = Validator::make($request->all(), [
            'sotamtru_so' => 'required|min:2|unique:nhanhokhau.tbl_sotamtru,sotamtru_so,'.$idsotamtru,
            'ghichu' => 'required',
            'date_action' => 'required|date_format:d-m-Y',
        ], TamtruLibrary::getMessageRule());

        if ( $validator->fails() ) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $sotamtru_update = array(
            'sotamtru_so' => $request->sotamtru_so,
            'updated_at' => Carbon::now()
        );
        DB::connection('nhanhokhau')->table('tbl_sotamtru')->where('id',$idsotamtru)->update($sotamtru_update);

        //--------------Ghi log cua ho so----------------------
        $data_log = array(
            'idthutuccutru' => $this->thutuc_dieuchinhthaydoi_tamtru,
            'type' => 'hogiadinh',
            'idsotamtru' => $idsotamtru,
            'ghichu' => $request->ghichu,
            'date_action' => date('Y-m-d', strtotime($request->date_action)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log );
        //--------------End ghi log cua ho so----------------------

        return response()->json(['success' => 'Cập nhật hồ sơ thành công ', 'url' => route('tam-tru.index')]);
    }

    public function checkTamtruQuahan()
    {
        $current_day = date('Y-m-d', time());
        $data['list_nhankhau'] = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where('tamtru_denngay', '<=', $current_day)
        ->where('tbl_tamtru.deleted_at', NULL)
        ->select('tbl_tamtru.tamtru_tungay', 'tbl_tamtru.tamtru_denngay', 'tbl_sotamtru.type', 'tbl_nhankhau.hoten', 'sotamtru_so', 'tbl_sotamtru.id as idsotamtru', 'tbl_sotamtru.idquocgia_tamtru', 'tbl_sotamtru.idtinh_tamtru', 'tbl_sotamtru.idhuyen_tamtru', 'tbl_sotamtru.idxa_tamtru', 'tbl_sotamtru.chitiet_tamtru' )
        ->orderBy('idsotamtru', 'DESC')
        ->get();
        return view('nhankhau-layouts.tamtru.quahan', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkexistChuho($arrQuanhe)
    {
        $num = 0;
        foreach ($arrQuanhe as $value)
        {
            if($value == 1)
            {
                $num++;
            }
        }
        return $num;
    }
}
