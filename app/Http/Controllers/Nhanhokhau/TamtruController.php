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
    // public $messages = ;

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
        $data['listqh'] = DB::table('tbl_moiquanhe')->pluck('name','id');
        return view('nhankhau-layouts.tamtru.chitiethosotamtru', $data);

    }

    public function getChitietnhankhauTamtru($idnhankhau, $idsotamtru)
    {
        $data['nhankhau'] = TamtruLibrary::getChitietNhankhauTamtru($idnhankhau, $idsotamtru);
        return view('nhankhau-layouts.tamtru.chitietnhankhautamtru', $data);
    }

    public function getAddnhankhau($idsotamtru)
    {
        $this->data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $this->data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $this->data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $this->data['nations'] = NhanhokhauLibrary::getListDanToc();
        $this->data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $this->data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHeNotChuHo();
        $this->data['sotamtru'] = NhanhokhauLibrary::getChitietSotamtru($idsotamtru, TRUE);
        return view('nhankhau-layouts.tamtru.addnhankhau', $this->data);
    }

    public function postAddnhankhau(Request $request, $idsotamtru)
    {
        $validator = Validator::make($request->all(), TamtruLibrary::getPostAddnhankhauRule(), TamtruLibrary::getMessageRule());
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $sotamtru_info = NhanhokhauLibrary::getChitietSotamtru($idsotamtru, TRUE);
        $idnhankhau = NhanhokhauLibrary::insertNhankhauTamtruToNhanKhauTable($request, TRUE);
        NhanhokhauLibrary::insertDataTamtru($request, $idsotamtru, $idnhankhau);
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
        $this->data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();
        $this->data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $this->data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $this->data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $this->data['nations'] = NhanhokhauLibrary::getListDanToc();
        $this->data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $this->data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHeNotChuHo();
        $this->data['nhankhau'] = NhanhokhauLibrary::getChitietNhankhauTamtru($idnhankhau, $idsotamtru);
        return view('nhankhau-layouts.tamtru.editnhankhau', $this->data);
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
        DB::table('tbl_sotamtru')->where( 'id',$idsotamtru )->update( $data_sotamtru );

        $data_nhankhau = array(
            'hoten' => $request->hoten,
            'tenkhac' => $request->tenkhac,
            'ngaysinh' => date('Y-m-d', strtotime($request->birthday)),
            'idquoctich' => $request->idquoctich,
            'iddantoc' => $request->iddantoc,
            'idnghenghiep' => $request->idnghenghiep,
            'gioitinh' => $request->gender,

            'idquocgia_nguyenquan' => $request->idquocgia_nguyenquan,
            'idtinh_nguyenquan' => $request->idtinh_nguyenquan,
            'idhuyen_nguyenquan' => $request->idhuyen_nguyenquan,
            'idxa_nguyenquan' => $request->idxa_nguyenquan,
            'chitiet_nguyenquan' => $request->chitiet_nguyenquan,

            'idquocgia_noilamviec' => $request->idquocgia_noilamviec,
            'idtinh_noilamviec' => $request->idtinh_noilamviec,
            'idhuyen_noilamviec' => $request->idhuyen_noilamviec,
            'idxa_noilamviec' => $request->idxa_noilamviec,
            'chitiet_noilamviec' => $request->chitiet_noilamviec,

            'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
            'idtinh_thuongtru' => $request->idtinh_thuongtru,
            'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
            'idxa_thuongtru' => $request->idxa_thuongtru,
            'chitiet_thuongtru' => $request->chitiet_thuongtru,

            'updated_at' => Carbon::now(),
        );
        DB::table('tbl_nhankhau')->where('id',$idnhankhau)->update($data_nhankhau);

        $data_tamtru = array(
            'tamtru_tungay' => date('Y-m-d', strtotime($request->tamtru_tungay)),
            'tamtru_denngay' => date('Y-m-d', strtotime($request->tamtru_denngay)),
        );

        DB::table('tbl_tamtru')->where('id', $request->idtamtru)->update($data_tamtru);

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

        DB::table('tbl_history_cutru')->insert( $data_log );
        //--------------End ghi log cua ho so----------------------

        return response()->json(['success' => 'Đăng ký thường trú thành công ', 'url' => route('chi-tiet-so-tam-tru', $idsotamtru)]);
    }

    public function getAddSoTamTruCaNhan()
    {
        $this->data['countries'] = $this->quocgia->get();
        $this->data['relations'] = $this->relation->get();
        $this->data['religions'] = $this->religion->get();
        $this->data['nations'] = $this->nation->get();
        $this->data['educations'] = $this->education->get();
        $this->data['careers'] = $this->career->get();
        $this->data['list_quanhechuho'] = DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->get();
        return view('nhankhau-layouts.tamtru.add_sotamtrucanhan', $this->data);
    }

    public function postAddSoTamTruCaNhan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idquocgia_thuongtru' => 'required',
            'idtinh_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idhuyen_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idxa_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idquocgia_tamtru' => 'required',
            'idtinh_tamtru' => 'required',
            'idhuyen_tamtru' => 'required',
            'idxa_tamtru' => 'required',
            'chitiet_tamtru' => 'required',
            'sotamtru_so' => 'required|unique:tbl_sotamtru',
            'tamtru_tungay' => 'required',
            'tamtru_denngay' => 'required',
            
            'hoten' => 'required',
            'birthday' => 'required|date_format:d-m-Y',
            'ngaydangky' => 'required|date_format:d-m-Y',
            'idquoctich' => 'required',
            'gender' => 'required',

            'idquocgia_nguyenquan' => 'required',
            'idtinh_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idhuyen_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idxa_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',

        ], TamtruLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()->all() ]);
        }

        $data_sotamtru = array(
            'type' => 'nhankhau',
            'sotamtru_so' => $request->sotamtru_so,
            'idquocgia_tamtru' => $request->idquocgia_tamtru,
            'idtinh_tamtru' => $request->idtinh_tamtru,
            'idhuyen_tamtru' => $request->idhuyen_tamtru,
            'idxa_tamtru' => $request->idxa_tamtru,
            'chitiet_tamtru' => $request->chitiet_tamtru,
            'ngaydangky' => date('Y-m-d', strtotime($request->ngaydangky)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        $id_sotamtru = DB::table('tbl_sotamtru')->insertGetId($data_sotamtru);

        $data_nhankhau = array(
            'hoten' => $request->hoten,
            'tenkhac' => $request->tenkhac,
            'idnghenghiep' => $request->idnghenghiep,
            'iddantoc' => $request->iddantoc,
            'ngaysinh' => date('Y-m-d', strtotime($request->birthday)),
            'idquoctich' => $request->idquoctich,
            'gioitinh' => $request->gender,

            'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
            'idtinh_thuongtru' => $request->idtinh_thuongtru,
            'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
            'idxa_thuongtru' => $request->idxa_thuongtru,
            'chitiet_thuongtru' => $request->chitiet_thuongtru,

            'idquocgia_nguyenquan' => $request->idquocgia_nguyenquan,
            'idtinh_nguyenquan' => $request->idtinh_nguyenquan,
            'idhuyen_nguyenquan' => $request->idhuyen_nguyenquan,
            'idxa_nguyenquan' => $request->idxa_nguyenquan,
            'chitiet_nguyenquan' => $request->chitiet_nguyenquan,

            'idquocgia_noilamviec' => $request->idquocgia_noilamviec,
            'idtinh_noilamviec' => $request->idtinh_noilamviec,
            'idhuyen_noilamviec' => $request->idhuyen_noilamviec,
            'idxa_noilamviec' => $request->idxa_noilamviec,
            'chitiet_noilamviec' => $request->chitiet_noilamviec,
        );

        $id_nhankhau = DB::table('tbl_nhankhau')->insertGetId($data_nhankhau);

        $data_tamtru = array(
            'type' => 'nhankhau',
            'idsotamtru' => $id_sotamtru,
            'idnhankhau' => $id_nhankhau,
            'idquanhechuho' => 1,
            'tamtru_tungay' => date('Y-m-d', strtotime($request->tamtru_tungay)),
            'tamtru_denngay' => date('Y-m-d', strtotime($request->tamtru_denngay)),
            'ngaydangky_tamtrunhankhau' => date('Y-m-d', strtotime($request->ngaydangky)),
        );

        $id_nhankhau = DB::table('tbl_tamtru')->insertGetId($data_tamtru);

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
        DB::table('tbl_history_cutru')->insert( $data_log_nhankhau );

        $data_log_sotamtru = array(
            'idthutuccutru' => $this->thutuc_capsotamtu,
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
        DB::table('tbl_history_cutru')->insert( $data_log_sotamtru );

        return response()->json(['success' => 'Thêm nhân khẩu thành công ', 'url' => route('tam-tru.index')]);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['countries'] = $this->quocgia->get();
        $this->data['relations'] = $this->relation->get();
        $this->data['religions'] = $this->religion->get();
        $this->data['nations'] = $this->nation->get();
        $this->data['educations'] = $this->education->get();
        $this->data['careers'] = $this->career->get();
        $this->data['list_quanhechuho'] = DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->get();
        return view('nhankhau-layouts.tamtru.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idquocgia_thuongtru' => 'required',
            'idtinh_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idhuyen_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idxa_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idquocgia_tamtru' => 'required',
            'idtinh_tamtru' => 'required',
            'idhuyen_tamtru' => 'required',
            'idxa_tamtru' => 'required',
            'chitiet_tamtru' => 'required',
            'sotamtru_so' => 'required|unique:tbl_sotamtru',
            'tamtru_tungay' => 'required',
            'tamtru_denngay' => 'required',
            
            'hoten.*' => 'required',
            'idquanhechuho.*' => 'required',
            'birthday.*' => 'required|date_format:d-m-Y',
            'ngaydangky.*' => 'required|date_format:d-m-Y',
            'idquoctich.*' => 'required',
            'gender.*' => 'required',

            'idquocgia_nguyenquan.*' => 'required',
            'idtinh_nguyenquan.*' => 'required_if:idquocgia_nguyenquan.*,1',
            'idhuyen_nguyenquan.*' => 'required_if:idquocgia_nguyenquan.*,1',
            'idxa_nguyenquan.*' => 'required_if:idquocgia_nguyenquan.*,1',

        ], TamtruLibrary::getMessageRule());

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

        $data_sotamtru = array(
            'type' => 'hogiadinh',
            'sotamtru_so' => $request->sotamtru_so,
            'idquocgia_tamtru' => $request->idquocgia_tamtru,
            'idtinh_tamtru' => $request->idtinh_tamtru,
            'idhuyen_tamtru' => $request->idhuyen_tamtru,
            'idxa_tamtru' => $request->idxa_tamtru,
            'chitiet_tamtru' => $request->chitiet_tamtru,
            'ngaydangky' => date('Y-m-d', strtotime($request->ngaydangky)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        $id_sotamtru = DB::table('tbl_sotamtru')->insertGetId($data_sotamtru);

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
        DB::table('tbl_history_cutru')->insert( $data_log );
        //--------------------End Log tạm trú hộ gia đình-----------------------

        $num_nhankhau = count($request->hoten);
        for ($i=0; $i < $num_nhankhau; $i++)
        { 
            $data_nhankhau = array(
                'hoten' => $request->hoten[$i],
                'tenkhac' => $request->tenkhac[$i],
                'idnghenghiep' => $request->idnghenghiep[$i],
                'iddantoc' => $request->iddantoc[$i],
                'ngaysinh' => date('Y-m-d', strtotime($request->birthday[$i])),
                'idquoctich' => $request->idquoctich[$i],
                'gioitinh' => $request->gender[$i],

                'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
                'idtinh_thuongtru' => $request->idtinh_thuongtru,
                'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
                'idxa_thuongtru' => $request->idxa_thuongtru,
                'chitiet_thuongtru' => $request->chitiet_thuongtru,

                'idquocgia_nguyenquan' => $request->idquocgia_nguyenquan[$i],
                'idtinh_nguyenquan' => $request->idtinh_nguyenquan[$i],
                'idhuyen_nguyenquan' => $request->idhuyen_nguyenquan[$i],
                'idxa_nguyenquan' => $request->idxa_nguyenquan[$i],
                'chitiet_nguyenquan' => $request->chitiet_nguyenquan[$i],

                'idquocgia_noilamviec' => $request->idquocgia_noilamviec[$i],
                'idtinh_noilamviec' => $request->idtinh_noilamviec[$i],
                'idhuyen_noilamviec' => $request->idhuyen_noilamviec[$i],
                'idxa_noilamviec' => $request->idxa_noilamviec[$i],
                'chitiet_noilamviec' => $request->chitiet_noilamviec[$i],

            );

            $id_nhankhau = DB::table('tbl_nhankhau')->insertGetId($data_nhankhau);

            $data_tamtru = array(
                'type' => 'hogiadinh',
                'idsotamtru' => $id_sotamtru,
                'idnhankhau' => $id_nhankhau,
                'idquanhechuho' => $request->idquanhechuho[$i],
                'tamtru_tungay' => date('Y-m-d', strtotime($request->tamtru_tungay)),
                'tamtru_denngay' => date('Y-m-d', strtotime($request->tamtru_denngay)),
                'ngaydangky_tamtrunhankhau' => date('Y-m-d', strtotime($request->ngaydangky)),
            );

            $id_nhankhau = DB::table('tbl_tamtru')->insertGetId($data_tamtru);

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
            DB::table('tbl_history_cutru')->insert( $data_log_nhankhau );
            //------------------End log nhan khau
        }

        return response()->json(['success' => 'Thêm nhân khẩu thành công ', 'url' => route('tam-tru.index')]);

        
    }

    public function getXoaTamTruNhanKhau($idnhankhau, $idsotamtru)
    {
        $data['nhankhau'] = DB::table('tbl_tamtru')
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

        DB::table('tbl_tamtru')->where(array(
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
        DB::table('tbl_history_cutru')->insert( $data_log_nhankhau );

        $num_nhankhau_exists = DB::table('tbl_tamtru')->where(array(
            ['idsotamtru', '=', $idsotamtru],
            ['tbl_tamtru.deleted_at', '=', NULL],
        ))->count();
        if($num_nhankhau_exists  == 0)
        {
            $delete_update = array(
                'deleted_at' => $data_log_nhankhau['date_action']
            );
            DB::table('tbl_sotamtru')->where('id', $idsotamtru)->update( $delete_update );
        }
        return response()->json(['success' => 'Thành công ', 'url' => route('chi-tiet-so-tam-tru',$idsotamtru)]);
    }

    public function getGiaHanTamTruNhanKhau($idnhankhau, $idsotamtru)
    {
        $data['nhankhau'] = DB::table('tbl_tamtru')
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

        DB::table('tbl_tamtru')->where(array(
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
        DB::table('tbl_history_cutru')->insert($data_log_nhankhau);

        return response()->json(['success' => 'Thành công ', 'url' => route('tam-tru.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idsotamtru) {
        $data['sotamtru'] = DB::table('tbl_sotamtru')->where('id',$idsotamtru)->first();
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
            'sotamtru_so' => 'required|min:2|unique:tbl_sotamtru,sotamtru_so,'.$idsotamtru,
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
        DB::table('tbl_sotamtru')->where('id',$idsotamtru)->update($sotamtru_update);

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
        DB::table('tbl_history_cutru')->insert( $data_log );
        //--------------End ghi log cua ho so----------------------

        return response()->json(['success' => 'Cập nhật hồ sơ thành công ', 'url' => route('tam-tru.index')]);
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
