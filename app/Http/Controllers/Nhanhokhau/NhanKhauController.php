<?php

namespace App\Http\Controllers\Nhanhokhau;
use App\Http\Controllers\Controller;
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
use Auth;
use App\UserApp\NhanhokhauLibrary;

class NhanKhauController extends Controller
{
    public $req;
    public $idhogoc;
    public $idhosonhap;

    //Khai báo các thủ tục và địa giới
    public $thutuc_capmoi = 1;
    public $thutuc_caplai = 2;
    public $thutuc_capdoi = 3;
    public $thutuc_tach = 4;
    public $thutuc_dangkynhankhau = 5;
    public $thutuc_dieuchinhthaydoi = 6;
    public $thutuc_dangkynoimoi = 11;
    //End khai báo các thủ tục và địa giới
    

    // public $messages = ;

    public function __construct(NhanKhau $nhankhau, QuocGia $quocgia, Relation $relation, Religion $religion
        , Nation $nation, Education $education, Career $career, Province $province, District $district
        , Ward $ward, Brief $brief, Hokhau $hokhau) {

        // $this->middleware('auth');
        $this->quocgia = $quocgia;
        $this->nation = $nation;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
    }

//HO SO HO KHAU - SO HO KHAU

    public function index(Request $request) {
        $data['briefs'] = NhanhokhauLibrary::getListHosoIndex($request->keyword);

        if( $request->ajax() )
        {
            return response()->json(['html' => view('nhankhau-layouts.ajax_component.nhankhautable', $data)->render()]);
        }
        return view('nhankhau-layouts.thuongtru.index', $data);
    }

    public function create() {
        $this->data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $this->data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $this->data['nations'] = NhanhokhauLibrary::getListDanToc();
        $this->data['educations'] = NhanhokhauLibrary::getListTrinhDoHocVan();
        $this->data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $this->data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();

        $this->data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $this->data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $this->data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $this->data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));

        return view('nhankhau-layouts.thuongtru/create', $this->data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), NhanhokhauLibrary::getStoreRule(), NhanhokhauLibrary::getMessageRule());

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

        $fullname = $request->hoten;
        $idBrief = NhanhokhauLibrary::insertHoso($request);

        //Ghi log cua ho so
        for ($i=0; $i < count($fullname); $i++)
        {
            if($request->idquanhechuho[$i] == 1)
            {
                $data_log = array(
                    'idthutuccutru' => $this->thutuc_capmoi, 'type' => 'hogiadinh', 'idhoso' => $idBrief, 'date_action' => date('Y-m-d', strtotime($request->ngaydangky[$i])),
                    'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc[$i], 'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc[$i], 'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc[$i], 'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i], 'chitiet_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],
                    'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                );
                NhanhokhauLibrary::logCutru($data_log);
            }
            break;
        }
        
        //End dhi log cua ho so
        for ($i=0; $i < count($fullname); $i++)
        {
            $nhankhau_id_inserted = NhanhokhauLibrary::insertArrNhankhau($request, $i);
            $data_log_nhankhau = array(
                'idthutuccutru' => $this->thutuc_dangkynhankhau,
                'type' => 'nhankhau', 'idnhankhau' => $nhankhau_id_inserted, 'idhoso' => $idBrief, 'date_action' => date('Y-m-d', strtotime($request->ngaydangky[$i])),
                'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc[$i], 'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc[$i], 'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc[$i], 'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i], 'chitiet_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            );
            NhanhokhauLibrary::logCutru($data_log_nhankhau);
            NhanhokhauLibrary::insertArrNhankhauToSohokhau($request, $i, $idBrief, $nhankhau_id_inserted, 'FALSE');
        }
        return response()->json(['success' => 'Thêm nhân khẩu thành công ', 'url' => route('chi-tiet-ho-khau', $idBrief)]);
    }

    public function edit($id) {
        $data['hoso'] = DB::connection('nhanhokhau')->table('tbl_hoso')->where('id',$id)->first();
        return view('nhankhau-layouts.thuongtru.edithoso', $data);
    }

    public function update($idhoso, Request $request) {

        $validator = Validator::make($request->all(), NhanhokhauLibrary::getUpdateRule($idhoso) , NhanhokhauLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        NhanhokhauLibrary::updateHoso($request, $idhoso);
        $data_log = array(
            'idthutuccutru' => $this->thutuc_dieuchinhthaydoi, 'type' => 'hogiadinh', 'idhoso' => $idhoso, 'ghichu' => $request->ghichu, 'date_action' => date('Y-m-d', strtotime($request->date_action)), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        );
        NhanhokhauLibrary::logCutru($data_log);
        return response()->json(['success' => 'Cập nhật hồ sơ thành công ', 'url' => route('chi-tiet-ho-khau', $idhoso)]);
    }

    // CAC THU TUC HO KHAU

    public function getDangkythuongtru($idhoso)
    {
        $data['idhoso'] = $idhoso;
        $data['thongtinhoso'] = NhanhokhauLibrary::getHosoInfo($idhoso);
        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['educations'] = NhanhokhauLibrary::getListTrinhDoHocVan();
        $data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        // $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['list_quanhechuho'] = DB::table('tbl_moiquanhe')->where(array(['loaiquanhe', '=', 'nhanthan'], ['id', '!=', 1]))->get();

        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));
        return view('nhankhau-layouts.thuongtru.dangkythuongtru', $data);
    }

    public function postDangkythuongtru(Request $request, $idhoso)
    {
        $validator = Validator::make($request->all(), NhanhokhauLibrary::getDangkythuongtruRule(), NhanhokhauLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $data_diachi = DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->where('idquanhechuho', 1)
        ->first();
        if(empty($data_diachi))
        {
            return response()->json(['error' => array('Không tồn tại địa chỉ đăng ký thường trú')]);
        }

        $idnhankhau = NhanhokhauLibrary::insertANhanKhauInDangKyThuongTru($request, $data_diachi, TRUE);
        NhanhokhauLibrary::insertNhankhauToSohokhau($request, $idhoso, $idnhankhau);
        //------------------Log nhan khau-------------
        $data_log_nhankhau = array(
            'idthutuccutru' => $this->thutuc_dangkynhankhau, 'type' => 'nhankhau', 'idnhankhau' => $idnhankhau, 'idhoso' => $idhoso, 'moisinh' => $request->moisinh, 'date_action' => date('Y-m-d', strtotime($request->ngaydangky)),
            'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc,
            'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc,
            'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc,
            'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc,
            'chitiet_thuongtrutruoc' => $request->chitiet_thuongtrutruoc,
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        );
        NhanhokhauLibrary::logCutru($data_log_nhankhau);
        return response()->json(['success' => 'Đăng ký thường trú thành công ', 'url' => route('chi-tiet-ho-khau', $idhoso)]);
    }

    public function getChitiethokhau($idhoso)
    {
        $data['list_thongtinhokhau'] = NhanhokhauLibrary::getChitiethokhau($idhoso);
        $data['idhoso'] = $idhoso;
        return view('nhankhau-layouts.thuongtru.chitiethoso', $data);
    }

    public function getSuanhankhau($id_in_sohokhau)
    {
        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['educations'] = NhanhokhauLibrary::getListTrinhDoHocVan();
        $data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['nhankhau'] = NhanhokhauLibrary::getChitietNhankhauFromIdInSohokhau($id_in_sohokhau);

        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));
        return view('nhankhau-layouts.thuongtru.editnhankhau', $data);
    }

    public function postSuanhankhau(Request $request, $id_in_sohokhau)
    {
        $validator = Validator::make($request->all(), NhanhokhauLibrary::getSuaNhanKhauRule() , NhanhokhauLibrary::getMessageRule());
        if($request->idquanhechuho == 1)
        {
            $validator->errors()->add('idquanhechuho', 'Quan hệ là Chủ hộ đã tồn tại, bạn không được chọn!');
        }
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        NhanhokhauLibrary::updatePostSuaNhankhau($request, $request->idnhankhau);

        $data_sohokhau = array(
            'ngaydangky' => date('Y-m-d', strtotime( $request->ngaydangky ) ),
            'idquanhechuho' => $request->idquanhechuho,
            'moisinh' => $request->moisinh,
        );

        DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('id',$id_in_sohokhau)->update($data_sohokhau);

        //--------------Ghi log cua ho so----------------------
        $data_log = array(
            'idthutuccutru' => $this->thutuc_dieuchinhthaydoi,
            'type' => 'nhankhau',
            'idhoso' => DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('id',$id_in_sohokhau)->value('idhoso'),
            'idnhankhau' => $request->idnhankhau,
            'date_action' => date('Y-m-d', strtotime( $request->date_action ) ),
            'moisinh' => $request->moisinh,
            'ghichu' => $request->ghichu,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log );
        //--------------End ghi log cua ho so----------------------

        return response()->json(['success' => 'Đăng ký thường trú thành công ', 'url' => route('chi-tiet-ho-khau', $request->idhoso)]);
    }

    public function getChitietnhankhau($id_in_sohokhau)
    {
        $data['nhankhau'] = NhanhokhauLibrary::getChitietNhankhauFromIdInSohokhau($id_in_sohokhau);
        return view('nhankhau-layouts.thuongtru.chitietnhankhau', $data);
    }

    public function getCheckxoathuongtru($id_in_sohokhau)
    {
        $data['nhankhau'] = NhanhokhauLibrary::getChitietNhankhauFromIdInSohokhau($id_in_sohokhau);
        $data['list_thongtinhokhau'] = NhanhokhauLibrary::getChitiethokhau($data['nhankhau']->idhoso, array(['tbl_sohokhau.id', '!=', $id_in_sohokhau], ['idquanhechuho', '!=', 1], ['tbl_sohokhau.deleted_at', '=', NULL]));
        if($data['nhankhau']->idquanhechuho == 1)
        {
            $message = array('type' => 'warning', 'content' => 'Người này là chủ hộ, bạn phải thay chủ hộ trước khi xóa thường trú');
            return redirect()->route('thay-doi-chu-ho', $data['nhankhau']->idhoso)->with('alert_message', $message);
        }
        $data['list_truonghopxoa'] = DB::connection('nhanhokhau')->table('tbl_thutuccutru')->where('type', 'xoathuongtru')->get();
        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['educations'] = NhanhokhauLibrary::getListTrinhDoHocVan();
        $data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();

        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));
        
        return view('nhankhau-layouts.thuongtru.xoathuongtru', $data);
    }

    public function xoaThuongtru(Request $request, $id_in_sohokhau)
    {
        $validator = Validator::make($request->all(), [
            'idtruonghopxoa' => 'required',
            'ngayxoathuongtru' => 'required',
            'idquocgia_thuongtrumoi' => 'required_if:idtruonghopxoa,'.$this->thutuc_dangkynoimoi,
            'idnhankhau' => 'required|integer',
            'idtinh_thuongtrumoi' => 'required_if:idquocgia_thuongtrumoi,1',
            'idhuyen_thuongtrumoi' => 'required_if:idquocgia_thuongtrumoi,1',
            'idxa_thuongtrumoi' => 'required_if:idquocgia_thuongtrumoi,1',
        ], NhanhokhauLibrary::getMessageRule());
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $arrXoa = ($request->idnguoixoacung != NULL) ? $request->idnguoixoacung : array();
        $arrXoa[] = $id_in_sohokhau;
        $list_nhankhau = DB::connection('nhanhokhau')->table('tbl_sohokhau')->whereIn('id', $arrXoa)->pluck('idnhankhau')->toArray();
        NhanhokhauLibrary::deleteNhankhauSohokhau( $arrXoa );
        $noiden = NULL;
        if($request->idtruonghopxoa == $this->thutuc_dangkynoimoi)
        {
            $data_update = array(
                'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
                'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
                'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
                'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
                'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
            );
            DB::connection('nhanhokhau')->table('tbl_nhankhau')->whereIn('id', $list_nhankhau)->update($data_update);
            $noiden = $request->chitiet_thuongtrumoi.' - '.(($request->idxa_thuongtrumoi) ? DB::table('tbl_xa_phuong_tt')->where('id', $request->idxa_thuongtrumoi)->value('name') : '' ).' - '.(($request->idhuyen_thuongtrumoi) ? DB::table('tbl_huyen_tx')->where('id', $request->idhuyen_thuongtrumoi)->value('name') : '').' - '.(($request->idtinh_thuongtrumoi) ? DB::table('tbl_tinh_tp')->where('id', $request->idtinh_thuongtrumoi)->value('name') : '');
        }

        $data_log = array();
        $ngayxoa = date('Y-m-d', strtotime($request->ngayxoathuongtru));
        
        foreach ($list_nhankhau as $idnhankhau)
        {
            $data_log[] = array(
                'idthutuccutru' => $request->idtruonghopxoa, 'type' => 'nhankhau', 'idhoso' => $request->idhoso, 'idnhankhau' => $idnhankhau, 'ghichu' => $request->lydoxoa, 'date_action' => $ngayxoa,
                'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
                'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
                'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
                'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
                'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            );
        }
        NhanhokhauLibrary::logArrCutru($data_log);
        $arr_ret = ['success' => 'Xóa đăng ký thường trú thành công', 'url' => route('chi-tiet-ho-khau', $request->idhoso)];
        $data_to_get_hk07 = base64_encode( json_encode( ['lydo' => $request->lydoxoa, 'noichuyenden' => $noiden, 'nguoichuyen' => $id_in_sohokhau, 'nguoichuyencung' => $request->idnguoixoacung ] ) );
        if($request->idtruonghopxoa == $this->thutuc_dangkynoimoi)
        {
            $arr_ret['url_second'] =  route('get-hk-07', ['data' => $data_to_get_hk07]);
        }
        return response()->json($arr_ret);
    }

    public function getCheckxoathuongtruHGD($idhoso)
    {
        $data['list_thongtinhokhau'] = NhanhokhauLibrary::getChitiethokhau($idhoso, array(['tbl_sohokhau.deleted_at', '=', NULL]));
        $data['idhoso'] = $idhoso;

        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));

        $data['list_truonghopxoa'] = DB::connection('nhanhokhau')->table('tbl_thutuccutru')->where('type', 'xoathuongtru')->get();
        return view('nhankhau-layouts.thuongtru.chitiethosoHGD', $data);
    }

    public function xoaThuongtruHGD(Request $request, $idhoso)
    {
        $validator = Validator::make($request->all(), [
            'idtruonghopxoa' => 'required',
            'ngayxoathuongtru' => 'required',
            'idquocgia_thuongtrumoi' => 'required_if:idtruonghopxoa,'.$this->thutuc_dangkynoimoi,
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
        if($request->idtruonghopxoa == $this->thutuc_dangkynoimoi)
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

        $data_log_hogiadinh = array(
            'idthutuccutru' => $request->idtruonghopxoa, 'type' => 'hogiadinh', 'idhoso' => $idhoso, 'date_action' => date('Y-m-d', strtotime($request->ngayxoathuongtru)),
            'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
            'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
            'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
            'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
            'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
            'ghichu' => $request->lydoxoa,
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        );
        NhanhokhauLibrary::logCutru($data_log_hogiadinh);

        $data_log_nhankhau = array();
        foreach ($list_nhankhau_id as $value)
        {
            $data_log = array(
                'idthutuccutru' => $request->idtruonghopxoa,
                'type' => 'nhankhau', 'idnhankhau' => $value, 'idhoso' => $idhoso,
                'date_action' => date('Y-m-d', strtotime($request->ngayxoathuongtru)),
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
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
        if($request->idtruonghopxoa == $this->thutuc_dangkynoimoi)
        {
            $data_to_get_hk07 = base64_encode( json_encode( ['lydo' => $request->lydoxoa, 'noichuyenden' => $noiden, 'nguoichuyen' => $idnguoixoa, 'nguoichuyencung' => $arr_nguoixoacung ] ) );
            $arr_ret['url_second'] =  route('get-hk-07', ['data' => $data_to_get_hk07]);
        }
        return response()->json($arr_ret);
    }

    public function getCheckcaplaiSHK($idhoso)
    {
        $data['list_thongtinhokhau'] = NhanhokhauLibrary::getChitiethokhau($idhoso);
        $data['idhoso'] = $idhoso;
        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();

        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));
        return view('nhankhau-layouts.thuongtru.chitiethosoHGD_caplai', $data);
    }

    public function caplaiSHK(Request $request, $idhoso)
    {
        $validator = Validator::make($request->all(), [
            'ngaycaplai' => 'required|date_format:d-m-Y',
            'ghichu' => 'required',
        ], NhanhokhauLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $list_nhankhau = DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('idhoso',$idhoso)->pluck('idnhankhau');

        $data_log_hogiadinh = array(
            'idthutuccutru' => $this->thutuc_caplai,
            'type' => 'hogiadinh',
            'idhoso' => $idhoso,
            'ghichu' => $request->ghichu,
            'date_action' => date('Y-m-d', strtotime($request->ngaycaplai)),
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        );
        NhanhokhauLibrary::logCutru( $data_log_hogiadinh );

        $data_log_nhankhau = array();
        foreach ($list_nhankhau as $value)
        {
            $data_log = array(
                'idthutuccutru' => $this->thutuc_caplai,
                'type' => 'nhankhau', 'idnhankhau' => $value, 'idhoso' => $idhoso, 'ghichu' => $request->ghichu,
                'date_action' => date('Y-m-d', strtotime($request->ngaycaplai)),
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            );
            $data_log_nhankhau[] = $data_log;
        }
        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log_nhankhau );
        return response()->json([ 'success' => 'Xóa đăng ký thường trú thành công ', 'url' => route('chi-tiet-ho-khau', $idhoso) ]);
    }

    public function getCheckcapdoiSHK($idhoso)
    {
        $data['list_thongtinhokhau'] = NhanhokhauLibrary::getChitiethokhau($idhoso);
        $data['idhoso'] = $idhoso;

        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();

        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));
        return view('nhankhau-layouts.thuongtru.chitiethosoHGD_capdoi', $data);
    }

    public function capdoiSHK(Request $request, $idhoso)
    {
        $validator = Validator::make($request->all(), [
            'ngaycapdoi' => 'required',
            'ghichu' => 'required',
        ], NhanhokhauLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $list_nhankhau = DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('idhoso',$idhoso)->pluck('idnhankhau');

        $data_log_hogiadinh = array(
            'idthutuccutru' => $this->thutuc_capdoi,
            'type' => 'hogiadinh',
            'idhoso' => $idhoso,
            'ghichu' => $request->ghichu,
            'date_action' => date('Y-m-d', strtotime($request->ngaycapdoi)),
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        );
        NhanhokhauLibrary::logCutru($data_log_hogiadinh);

        $data_log_nhankhau = array();
        foreach ($list_nhankhau as $value)
        {
            $data_log = array(
                'idthutuccutru' => $this->thutuc_capdoi,
                'type' => 'nhankhau',
                'idhoso' => $idhoso,
                'idnhankhau' => $value,
                'ghichu' => $request->ghichu,
                'date_action' => date('Y-m-d', strtotime($request->ngaycapdoi)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );
            $data_log_nhankhau[] = $data_log;
        }
        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log_nhankhau );
        return response()->json([ 'success' => 'Xóa đăng ký thường trú thành công ', 'url' => route('chi-tiet-ho-khau', $idhoso) ]);
    }

    public function getThaydoichuho($idhoso)
    {
        $data['list_nhankhau'] = NhanhokhauLibrary::getListNhankhauHoso($idhoso);
        $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['idhoso'] = $idhoso;
        return view('nhankhau-layouts.thuongtru.thaydoichuho', $data);
    }

    public function postThaydoichuho(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'idquanhechuho.*' => 'required'
        ], NhanhokhauLibrary::getMessageRule());
        $this->req = $request;
        $validator->after(function ($validator)
        {
            $num = $this->checkexistChuho($this->req->idquanhechuho);
            if($num == 0)
            {
                $validator->errors()->add('idquanhechuho', 'Quan hệ là Chủ hộ bắt buộc phải chọn!');
            }
            elseif($num > 1)
            {
                $validator->errors()->add('idquanhechuho', 'Chủ hộ chỉ được duy nhất 01 người');
            }   
        });

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        for($i = 0; $i < count($request->id_in_sohokhau); $i++)
        {
            DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('id',$request->id_in_sohokhau[$i])->update(['idquanhechuho' => $request->idquanhechuho[$i]]);
        }

        return response()->json(['success' => 'Thay đổi quan hệ chủ hộ thành công ', 'url' => route('chi-tiet-ho-khau', $id)]);
    }

    public function getTachhokhau($idhoso)
    {
        $data['list_nhankhau'] = NhanhokhauLibrary::getListNhankhauHoso($idhoso);
        if(count($data['list_nhankhau']) <= 1)
        {
            $message = array('type' => 'warning', 'content' => 'Hộ tách phải có 2 người trở lên');
            return redirect()->route('chi-tiet-ho-khau', $idhoso)->with('alert_message', $message);
        }
        $list_quanhechuho = NhanhokhauLibrary::getListMoiQuanHe();
        $str = '';
        foreach ($list_quanhechuho as $value)
        {
            $str .= '<option value="'.$value->id.'">'.$value->name.'</option>';
        }
        $data['str_ret'] = $str;
        $data['idhoso'] = $idhoso;

        $data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $data['nations'] = NhanhokhauLibrary::getListDanToc();
        $data['educations'] = NhanhokhauLibrary::getListTrinhDoHocVan();
        $data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();

        $data['countries'] = NhanhokhauLibrary::getListQuocgia();
        $data['provinces'] = NhanhokhauLibrary::getListTinhTP(config('user_config.default_hanhchinh.country'));
        $data['districts'] = NhanhokhauLibrary::getListHuyenTX(config('user_config.default_hanhchinh.province'));
        $data['wards'] = NhanhokhauLibrary::getListXaPhuongTT(config('user_config.default_hanhchinh.district'));

        return view('nhankhau-layouts.thuongtru.tachhokhau', $data);
    }


    public function postTachhokhau(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hosohokhau_so' => 'required|unique:nhanhokhau.tbl_hoso',
            'so_dktt_so' => 'required',
            'hokhau_so' => 'required|unique:nhanhokhau.tbl_hoso',
            'idquanhe.*' => 'required',
            'id_in_sohokhau.*' => 'required',
            'nhankhautach' => 'required',
            'date_action' => 'required|date_format:d-m-Y',

            'idquocgia_thuongtru' => 'required',
            'idtinh_thuongtru' => 'required',
            'idhuyen_thuongtru' => 'required',
            'idxa_thuongtru' => 'required',
        ], NhanhokhauLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if( $request->hoten[0] != NULL )
        {
            $validator = Validator::make($request->all(), NhanhokhauLibrary::getTachHoKhauAddNhankhauRule(), NhanhokhauLibrary::getMessageRule());
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }
        }

        $num_quanhechuho = $this->checkexistChuho($request->idquanhechuho);
        $num_quanhe = $this->checkexistChuho($request->idquanhe);
        $total_quanhechuho = $num_quanhechuho + $num_quanhe;
        if( $total_quanhechuho == 0)
        {
            return response()->json( ['error' => array('Chủ hộ bắt buộc phải chọn')] );
        }
        elseif( $total_quanhechuho > 1 )
        {
            return response()->json(['error' => array('Chủ hộ chỉ được duy nhất 01 người')]);
        }

        // return response()->json(['error' => array('OK')]);
        $data_hoso = array(
            'hosohokhau_so' => $request->hosohokhau_so,
            'hokhau_so' => $request->hokhau_so,
            'so_dktt_so' => $request->so_dktt_so,
            'so_dktt_toso' => $request->so_dktt_toso,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        $idhoso_inserted = DB::connection('nhanhokhau')->table('tbl_hoso')->insertGetId($data_hoso);

        $data_log = array(
            'idthutuccutru' => $this->thutuc_tach,
            'type' => 'hogiadinh',
            'idhoso' => $idhoso_inserted,
            'date_action' => date('Y-m-d', strtotime($request->date_action)),
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        );
        NhanhokhauLibrary::logCutru( $data_log );

        for ($i=0; $i < count($request->id_in_sohokhau); $i++)
        {
            $arrNhankhauSohokhauUpdate = array(
                'idhoso' => $idhoso_inserted,
                'idquanhechuho' => $request->idquanhe[$i],
                'ngaydangky' => date('Y-m-d', strtotime($request->date_action)),
            );
            DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('id',$request->id_in_sohokhau[$i])->update($arrNhankhauSohokhauUpdate);
            // $idnhankhau = DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('id',$request->id_in_sohokhau[$i])->value('idnhankhau');
            $arrNhankhauUpdate = array(
                'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
                'idtinh_thuongtru' => $request->idtinh_thuongtru,
                'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
                'idxa_thuongtru' => $request->idxa_thuongtru,
                'chitiet_thuongtru' => $request->chitiet_thuongtru,
            );
            DB::connection('nhanhokhau')->table('tbl_nhankhau')->where('id',$request->idnhankhau[$i])->update($arrNhankhauUpdate);
            $data_log = array(
                'idthutuccutru' => $this->thutuc_tach, 'type' => 'nhankhau', 'idhoso' => $idhoso_inserted,
                'idnhankhau' => $request->idnhankhau[$i],
                'date_action' => date('Y-m-d', strtotime($request->date_action)),
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            );
            NhanhokhauLibrary::logCutru( $data_log );
        }

        //Insert new nhankhau
        $num_nhankhau_add = count($request->hoten);
        if( $num_nhankhau_add > 0 )
        {
            for ($j=0; $j < $num_nhankhau_add; $j++)
            { 
                $nhankhau_id_inserted = NhanhokhauLibrary::insertArrNhankhau($request, $j);
                $data_log_nhankhau = array(
                    'idthutuccutru' => $this->thutuc_dangkynhankhau,
                    'type' => 'nhankhau', 'idnhankhau' => $nhankhau_id_inserted, 'idhoso' => $idhoso_inserted, 'date_action' => date('Y-m-d', strtotime($request->ngaydangky[$j])),
                    'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc[$j], 'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc[$j], 'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc[$j], 'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$j], 'chitiet_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$j],
                    'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                );
                NhanhokhauLibrary::logCutru($data_log_nhankhau);
                NhanhokhauLibrary::insertArrNhankhauToSohokhau($request, $j, $idhoso_inserted, $nhankhau_id_inserted, 'FALSE');
            }
        }
        return response()->json(['success' => 'Tách hộ khẩu thành công ', 'url' => route('nhan-khau.index')]);
    }

    public function getNhaphokhau($idhoso)
    {
        $data['idhoso'] = $idhoso;
        $data['thongtinhoso'] = DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where(array(
            ['tbl_hoso.id', '=', $idhoso],
            ['idquanhechuho', '=', 1]
        ))
        ->select('tbl_nhankhau.*', 'tbl_hoso.hokhau_so', 'tbl_hoso.hosohokhau_so')
        ->first();
        return view('nhankhau-layouts.thuongtru.gettonhaphokhau', $data);
    }

    public function postTimkiemhoso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|min:3',
        ], NhanhokhauLibrary::getMessageRule());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $data['briefs'] = NhanhokhauLibrary::getDataForTimkiemHoso($request->keyword);
        $data['idhogoc'] = $request->idhogoc;
        return response()->json(['html' => view('nhankhau-layouts.ajax_component.search_viewhoso', $data)->render()]);
    }

    public function getHoNhap(Request $request, $idhosogoc, $idhosonhap)
    {
        $this->idhosonhap = $idhosonhap;
        $this->idhosogoc = $idhosogoc;
        $data['list_nhankhau'] = DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where( function($query){
            $query->whereIn('tbl_hoso.id', [$this->idhosogoc, $this->idhosonhap]);
        } )
        ->select('tbl_sohokhau.id', 'hoten', 'tbl_sohokhau.idquanhechuho', 'tbl_hoso.id as idhoso', 'tbl_hoso.hokhau_so', 'tbl_hoso.hosohokhau_so', 'so_dktt_so', 'so_dktt_toso', 'ngaynopluu')
        ->get();
        $data['list_quanhechuho'] = DB::connection('nhanhokhau')->table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->get();
        $data['idhosogoc'] = $idhosogoc;
        $data['idhosonhap'] = $idhosonhap;
        return view('nhankhau-layouts.thuongtru.nhaphokhau', $data);
    }

    public function postNhaphokhau(Request $request, $idhosogoc, $idhosonhap)
    {
        $validator = Validator::make($request->all(), [
            'idquanhechuho.*' => 'required|integer',
            'id_in_sohokhau.*' => 'required|integer',
        ], NhanhokhauLibrary::getMessageRule());

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

        for ($i=0; $i < count($request->id_in_sohokhau); $i++)
        { 
            DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('id',$request->id_in_sohokhau[$i])->update([ 'idhoso' => $idhosogoc, 'idquanhechuho' => $request->idquanhechuho[$i]]);
        }

        DB::connection('nhanhokhau')->table('tbl_hoso')->where('id',$idhosonhap)->delete();

        return response()->json(['success' => 'Thêm nhân khẩu thành công ']);
    }

    public function getProvinces($id = NULL) {
        $provinces = $this->province->where('idquocgia', $id)->get();
        return response()->json($provinces);
    }

    public function getDistricts($id) {
        $districts = $this->district->where('idtinhtp', $id)->get();
        return response()->json($districts);
    }

    public function getWards($id) {
        // $wards = $this->ward->where('idhuyentx', $id)->get();
        $wards = DB::table('tbl_xa_phuong_tt')->where('idhuyentx',$id)->get();
        // print_r($wards->toArray()); die;
        return response()->json($wards);
    }

    public function show($id)
    {
        $data = $this->nhankhau->find($id);
        return response()->json($data);
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
