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
    public $connection = 'nhanhokhau';
    //End khai báo các thủ tục và địa giới
    

    public $messages = [
        'idquanhechuho.*.required' => 'Quan hệ với chủ hộ không được trống',
        'hosohokhau_so.required' => 'Hồ sơ hộ khẩu số bị trống.',
        'so_dktt_so.required' => 'Số đăng ký thường chú bị trống',
        'datetime.date_format' => 'Vui lòng nhập chính xác ngày nộp lưu',
        'hokhau_so.required' => 'Hộ khẩu số bị trống',
        'so_dktt_toso.required' => 'Tờ số bị trống',
        'hoten.*.required' => ':attribute Vui lòng nhập họ tên',
        'gender.*.required' => ':attribute Vui lòng chọn giới tính',
        'tenkhac.*.required' => ':attribute Vui lòng nhập biệt danh',
        'idtongiao.*.required' => ':attribute Vui lòng chọn tôn giáo',
        'idquoctich.*.required' => ':attribute Vui lòng chọn quốc tịch',
        'cmnd_so.*.required'   => ':attribute Vui lòng nhập số CMND',
        'idtrinhdohocvan.*.required' => ':attribute Vui lòng chọn trình độ học vấn',
        'iddantoc.*.required' => ':attribute Vui lòng chọn dân tộc',
        'idnghenghiep.*.required' => ':attribute Vui lòng chọn nghề nghiệp',
        'trinhdochuyenmon.*.required' => ':attribute Vui lòng nhập trình độ chuyên môn',
        'biettiengdantoc.*.required' => ':attribute Vui lòng nhập tiếng dân tộc',
        'trinhdongoaingu.*.required' => ':attribute Vui lòng nhập trình độ ngoại ngữ',
        'birthday.*.date_format' => ':attribute Vui lòng nhập chính xác ngày sinh',
        'idquocgia_noisinh.*.required' => ':attribute Vui lòng chọn quốc gia nơi sinh',
        'idtinh_noisinh.*.required' => ':attribute Vui lòng chọn tỉnh nơi sinh',
        'idhuyen_noisinh.*.required' => ':attribute Vui lòng chọn huyện nơi sinh',
        'idxa_noisinh.*.required' => ':attribute Vui lòng chọn xã nơi sinh',

        'idtinh_noisinh.*.required_if' => ':attribute Vui lòng chọn tỉnh nơi sinh',
        'idhuyen_noisinh.*.required_if' => ':attribute Vui lòng chọn huyện nơi sinh',
        'idxa_noisinh.*.required_if' => ':attribute Vui lòng chọn xã nơi sinh',

        'idquocgia_nguyenquan.*.required' => ':attribute Vui lòng chọn quốc gia nguyên quán',
        'idtinh_nguyenquan.*.required' => ':attribute Vui lòng chọn tỉnh nguyên quán',
        'idhuyen_nguyenquan.*.required' => ':attribute Vui lòng chọn huyện nguyên quán',
        'idxa_nguyenquan.*.required' => ':attribute Vui lòng chọn xã nguyên quán',

        'idtinh_nguyenquan.*.required_if' => ':attribute Vui lòng chọn tỉnh nguyên quán',
        'idhuyen_nguyenquan.*.required_if' => ':attribute Vui lòng chọn huyện nguyên quán',
        'idxa_nguyenquan.*.required_if' => ':attribute Vui lòng chọn xã nguyên quán',

        'idquocgia_thuongtru.*.required' => ':attribute Vui lòng chọn quốc gia thường trú',
        'idtinh_thuongtru.*.required' => ':attribute Vui lòng chọn tỉnh thường trú',
        'idhuyen_thuongtru.*.required' => ':attribute Vui lòng chọn huyện thường trú',
        'idxa_thuongtru.*.required' => ':attribute Vui lòng chọn xã thường trú',
        'idquocgia_thuongtru.required' => 'Vui lòng chọn quốc gia thường trú',
        'idtinh_thuongtru.required' => 'Vui lòng chọn tỉnh thường trú',
        'idhuyen_thuongtru.required' => 'Vui lòng chọn huyện thường trú',
        'idxa_thuongtru.required' => 'Vui lòng chọn xã thường trú',
        'idquocgia_noiohiennay.*.required' => ':attribute Vui lòng chọn quốc gia nơi ở hiện nay',
        'idtinh_noiohiennay.*.required' => ':attribute Vui lòng chọn tỉnh nơi ở hiện nay',
        'idhuyen_noiohiennay.*.required' => ':attribute Vui lòng chọn huyện nơi ở hiện nay',
        'idxa_noiohiennay.*.required' => ':attribute Vui lòng chọn xã nơi ở hiện nay',

        'idtinh_noiohiennay.*.required_if' => ':attribute Vui lòng chọn tỉnh nơi ở hiện nay',
        'idhuyen_noiohiennay.*.required_if' => ':attribute Vui lòng chọn huyện nơi ở hiện nay',
        'idxa_noiohiennay.*.required_if' => ':attribute Vui lòng chọn xã nơi ở hiện nay',

        'idquocgia_noilamviec.*.required' => ':attribute Vui lòng chọn quốc gia nơi làm việc',
        'idtinh_noilamviec.*.required' => ':attribute Vui lòng chọn tỉnh nơi làm việc',
        'idhuyen_noilamviec.*.required' => ':attribute Vui lòng chọn huyện nơi làm việc',
        'idxa_noilamviec.*.required' => ':attribute Vui lòng chọn xã nơi làm việc',
        'hosohokhau_so.unique' => 'Mã Hồ sơ hộ khẩu số này đã tồn tại',
        'hokhau_so.unique' => 'Hộ khẩu số không được trùng với mã hộ khẩu đã nhập',
        'birthday.*.required' => 'Ngày sinh không được để trống',
        'ngaydangky.*.required' => 'Ngày đăng ký thường trú không được để trống',
        'birthday.*.date_format' => 'Ngày sinh phải đúng định dạng ngày-tháng-năm',
        'ngaydangky.*.date_format' => 'Ngày đăng ký thường trú phải đúng định dạng ngày-tháng-năm',
        'lydoxoa.required' => 'Lý do xóa thường trú không được để trống.',
        'ngayxoathuongtru.required' => 'Ngày xóa thường trú không được để trống',
        'idtinh_thuongtru.*.required_if' => ':attribute Tỉnh nơi đăng ký thường trú không được trống',
        'idquocgia_thuongtrutruoc.*.required_if' => ':attribute Quốc gia nơi thường trú trước khi chuyển đến không được trống',
        'idtinh_thuongtrutruoc.*.required_if' => ':attribute Tỉnh nơi thường trú trước khi chuyển đến không được trống',
        'idhuyen_thuongtrutruoc.*.required_if' => ':attribute Huyện nơi thường trú trước khi chuyển đến không được trống',
        'idxa_thuongtrutruoc.*.required_if' => ':attribute Xã nơi thường trú trước khi chuyển đến không được trống',
        'ghichu.required' => ':attribute Ghi chú/Lý do không được trống',
        'date_action.required' => ':attribute Ngày thực hiện không được trống',
        'idtruonghopxoa.required' => ':attribute Trường hợp xóa không được trống',
        'ngaycaplai.required' => ':attribute Ngày cấp lại không được trống',
        'ngaycaplai.date_format' => 'Vui lòng nhập chính xác định dạng ngày cấp lại',
        'date_action.date_format' => 'Vui lòng nhập chính xác định dạng ngày cấp lại',
        'ngaycapdoi.required' => ':attribute Ngày cấp lại không được trống',
        'ngaycapdoi.date_format' => 'Vui lòng nhập chính xác định dạng ngày cấp lại',
        'nhankhautach.required' => ':attribute Nhân khẩu tách phải được chọn',
        'keyword.required' => ':attribute Từ khóa tìm kiếm không được trống',
        'keyword.min' => ':attribute Từ khóa tìm kiếm dài ít nhất 3 ký tự',
        'tungay.required' => ':attribute Từ ngày không được trống',
        'denngay.required' => ':attribute Đến ngày không được trống',
    ];

    public function __construct(NhanKhau $nhankhau, QuocGia $quocgia, Relation $relation, Religion $religion
        , Nation $nation, Education $education, Career $career, Province $province, District $district
        , Ward $ward, Brief $brief, Hokhau $hokhau) {

        // $this->middleware('auth');
        // $this->nhankhau = $nhankhau;
        $this->quocgia = $quocgia;
        // $this->relation = $relation;
        $this->religion = $religion;
        $this->nation = $nation;
        // $this->education = $education;
        // $this->career = $career;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
        // $this->brief = $brief;
        // $this->hokhau = $hokhau;
    }

//HO SO HO KHAU - SO HO KHAU

    public function index(Request $request) {
        $data['briefs'] = NhanhokhauLibrary::getListHosoIndex($request->keyword);

        if( $request->ajax() )
        {
            return response()->json(['html' => view('nhankhau-layouts.ajax_component.nhankhautable', $data)->render()]);
        }
        return view('nhankhau-layouts.thuongtru/index', $data);
    }

    public function create() {
        $this->data['countries'] = NhanhokhauLibrary::getListQuocgia(); //dd($this->data['countries']);
        $this->data['relations'] = NhanhokhauLibrary::getListMoiQuanHe();
        $this->data['religions'] = NhanhokhauLibrary::getListTonGiao();
        $this->data['nations'] = NhanhokhauLibrary::getListDanToc();
        $this->data['educations'] = NhanhokhauLibrary::getListTrinhDoHocVan();
        $this->data['careers'] = NhanhokhauLibrary::getListNgheNghiep();
        $this->data['list_quanhechuho'] = NhanhokhauLibrary::getListMoiQuanHe();
        return view('nhankhau-layouts.thuongtru/create', $this->data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'hosohokhau_so' => 'required|unique:nhanhokhau.tbl_hoso',
            'so_dktt_so' => 'required|min:2',
            'hokhau_so' => 'required|unique:.nhanhokhau.tbl_hoso',
            'hoten.*' => 'required',
            'idquanhechuho.*' => 'required',
            'birthday.*' => 'required|date_format:d-m-Y',
            'ngaydangky.*' => 'required|date_format:d-m-Y',
            'idtongiao.*' => 'required',
            'idquoctich.*' => 'required',
            'gender.*' => 'required',

            'idquocgia_thuongtru' => 'required',
            'idtinh_thuongtru' => 'required',
            'idhuyen_thuongtru' => 'required',
            'idxa_thuongtru' => 'required',

            'idquocgia_noisinh.*' => 'required',
            'idtinh_noisinh.*' => 'required_if:idquocgia_noisinh.*,1',
            'idhuyen_noisinh.*' => 'required_if:idquocgia_noisinh.*,1',
            'idxa_noisinh.*' => 'required_if:idquocgia_noisinh.*,1',

            'idquocgia_nguyenquan.*' => 'required',
            'idtinh_nguyenquan.*' => 'required_if:idquocgia_nguyenquan.*,1',
            'idhuyen_nguyenquan.*' => 'required_if:idquocgia_nguyenquan.*,1',
            'idxa_nguyenquan.*' => 'required_if:idquocgia_nguyenquan.*,1',

            'idquocgia_noiohiennay.*' => 'required',
            'idtinh_noiohiennay.*' => 'required_if:idquocgia_noiohiennay.*,1',
            'idhuyen_noiohiennay.*' => 'required_if:idquocgia_noiohiennay.*,1',
            'idxa_noiohiennay.*' => 'required_if:idquocgia_noiohiennay.*,1',

            'idquocgia_thuongtrutruoc.*' => 'required_if:ngoaihuyenden,1',
            'idtinh_thuongtrutruoc.*' => 'required_if:idquocgia_thuongtrutruoc.*,1',
            'idhuyen_thuongtrutruoc.*' => 'required_if:idquocgia_thuongtrutruoc.*,1',
            'idxa_thuongtrutruoc.*' => 'required_if:idquocgia_thuongtrutruoc.*,1',

        ], $this->messages);

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
                    'idthutuccutru' => $this->thutuc_capmoi,
                    'type' => 'hogiadinh',
                    'idhoso' => $idBrief,
                    'date_action' => date('Y-m-d', strtotime($request->ngaydangky[$i])),
                    'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                    'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc[$i], 'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc[$i], 'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc[$i], 'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i], 'chitiet_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],
                );
                DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log );
            }
            break;
        }
        
        //End dhi log cua ho so
        for ($i=0; $i < count($fullname); $i++)
        {
            
            $nhankhau_id_inserted = NhanhokhauLibrary::insertArrNhankhau($request, $i);

            //------------------Log nhan khau
            $data_log_nhankhau = array(
                'idthutuccutru' => $this->thutuc_dangkynhankhau,
                'type' => 'nhankhau',
                'idnhankhau' => $nhankhau_id_inserted,
                'idhoso' => $idBrief,
                'date_action' => date('Y-m-d', strtotime($request->ngaydangky[$i])),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc[$i], 'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc[$i], 'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc[$i], 'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i], 'chitiet_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],
            );
            DB::table('tbl_history_cutru')->insert( $data_log_nhankhau );
            //------------------End log nhan khau
            
            
            NhanhokhauLibrary::insertNhankhauToSohokhau($request, $i, $idBrief, $nhankhau_id_inserted, 'FALSE');
            
        }

        return response()->json(['success' => 'Thêm nhân khẩu thành công ', 'url' => route('chi-tiet-ho-khau', $idBrief)]);
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

    public function edit($id) {
        $data['hoso'] = DB::table('tbl_hoso')->where('id',$id)->first();
        return view('nhankhau-layouts.thuongtru.edithoso', $data);
    }

    public function update($idhoso, Request $request) {

        $validator = Validator::make($request->all(), [
            'hosohokhau_so' => 'required|min:2|unique:tbl_hoso,hosohokhau_so,'.$idhoso,
            'so_dktt_so' => 'required|min:2',
            'ghichu' => 'required',
            'hokhau_so' => 'required|unique:tbl_hoso,hokhau_so,'.$idhoso,
            'date_action' => 'required|date_format:d-m-Y',
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $hoso_update = array(
            'hosohokhau_so' => $request->hosohokhau_so,
            'hokhau_so' => $request->hokhau_so,
            'so_dktt_so' => $request->so_dktt_so,
            'so_dktt_toso' => $request->so_dktt_toso,
            'updated_at' => Carbon::now(),
            'ngaynopluu' => date('Y-m-d', strtotime($request->datetime)),
        );
        DB::table('tbl_hoso')->where('id',$idhoso)->update($hoso_update);

        //--------------Ghi log cua ho so----------------------
        $data_log = array(
            'idthutuccutru' => $this->thutuc_dieuchinhthaydoi,
            'type' => 'hogiadinh',
            'idhoso' => $idhoso,
            'ghichu' => $request->ghichu,
            'date_action' => date('Y-m-d', strtotime($request->date_action)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        DB::table('tbl_history_cutru')->insert( $data_log );
        //--------------End ghi log cua ho so----------------------

        return response()->json(['success' => 'Cập nhật hồ sơ thành công ']);
    }

    // CAC THU TUC HO KHAU

    public function getDangkythuongtru($id)
    {
        $data['idhoso'] = $id;
        $data['thongtinhoso'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where(array(
            ['tbl_hoso.id', '=', $id],
            ['idquanhechuho', '=', 1]
        ))
        ->select('tbl_nhankhau.*', 'tbl_hoso.hokhau_so', 'tbl_hoso.hosohokhau_so')
        ->first();
        $data['countries'] = $this->quocgia->get();
        $data['relations'] = $this->relation->get();
        $data['religions'] = $this->religion->get();
        $data['nations'] = $this->nation->get();
        $data['list_tongiao'] = DB::table('tbl_tongiao')->get();
        $data['list_quoctich'] = DB::table('tbl_quocgia')->get();
        $data['educations'] = DB::table('tbl_trinhdohocvan')->get();
        $data['list_dantoc'] = DB::table('tbl_dantoc')->get();
        $data['careers'] = DB::table('tbl_nghenghiep')->get();
        $data['list_quanhechuho'] = DB::table('tbl_moiquanhe')->where(array(['loaiquanhe', '=', 'nhanthan'], ['id', '!=', 1]))->get();
        return view('nhankhau-layouts.thuongtru.dangkythuongtru', $data);
    }

    public function postDangkythuongtru(Request $request, $idhoso)
    {
        $validator = Validator::make($request->all(), [
            'idquanhechuho' => 'required',
            'hoten' => 'required',
            'birthday' => 'required|date_format:d-m-Y',
            'ngaydangky' => 'required|date_format:d-m-Y',
            'idquoctich' => 'required',
            'gender' => 'required',
            'idquocgia_noisinh' => 'required',
            'idtinh_noisinh' => 'required_if:idquocgia_noisinh,1',
            'idhuyen_noisinh' => 'required_if:idquocgia_noisinh,1',
            'idxa_noisinh' => 'required_if:idquocgia_noisinh,1',

            'idquocgia_nguyenquan' => 'required',
            'idtinh_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idhuyen_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idxa_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',

            'idquocgia_noiohiennay' => 'required',
            'idtinh_noiohiennay' => 'required_if:idquocgia_noiohiennay,1',
            'idhuyen_noiohiennay' => 'required_if:idquocgia_noiohiennay,1',
            'idxa_noiohiennay' => 'required_if:idquocgia_noiohiennay,1',

            'idquocgia_thuongtrutruoc' => 'required_if:ngoaihuyenden,1',
            'idtinh_thuongtrutruoc' => 'required_if:idquocgia_thuongtrutruoc,1',
            'idhuyen_thuongtrutruoc' => 'required_if:idquocgia_thuongtrutruoc,1',
            'idxa_thuongtrutruoc' => 'required_if:idquocgia_thuongtrutruoc,1',
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $data_diachi = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->where('idquanhechuho', 1)
        ->first();
        if(empty($data_diachi))
        {
            return response()->json(['error' => array('Không tồn tại địa chỉ đăng ký thường trú')]);
        }

        $data_nhankhau = array(
            'hoten' => $request->hoten,
            'tenkhac' => $request->tenkhac,
            'ngaysinh' => date('Y-m-d', strtotime($request->birthday)),
            'idquoctich' => $request->idquoctich,
            'hochieu_so' => $request->hochieu_so,
            'cmnd_so' => $request->cmnd_so,
            'idtongiao' => $request->idtongiao,
            'iddantoc' => $request->iddantoc,
            'idtrinhdohocvan' => $request->idtrinhdohocvan,
            'idnghenghiep' => $request->idnghenghiep,
            'trinhdochuyenmon' => $request->trinhdochuyenmon,
            'trinhdongoaingu' => $request->trinhdongoaingu,
            'biettiengdantoc' => $request->biettiengdantoc,
            'tomtatbanthan' => $request->description,
            'tomtatgiadinh' => $request->descriptionFamily,
            'tienan_tiensu' => $request->criminalRecord,
            'gioitinh' => $request->gender,

            'idquocgia_nguyenquan' => $request->idquocgia_nguyenquan,
            'idtinh_nguyenquan' => $request->idtinh_nguyenquan,
            'idhuyen_nguyenquan' => $request->idhuyen_nguyenquan,
            'idxa_nguyenquan' => $request->idxa_nguyenquan,
            'chitiet_nguyenquan' => $request->chitiet_nguyenquan,

            'idquocgia_thuongtru' => $data_diachi->idquocgia_thuongtru,
            'idtinh_thuongtru' => $data_diachi->idtinh_thuongtru,
            'idhuyen_thuongtru' => $data_diachi->idhuyen_thuongtru,
            'idxa_thuongtru' => $data_diachi->idxa_thuongtru,
            'chitiet_thuongtru' => $data_diachi->chitiet_thuongtru,

            'idquocgia_noiohiennay' => $request->idquocgia_noiohiennay,
            'idtinh_noiohiennay' => $request->idtinh_noiohiennay,
            'idhuyen_noiohiennay' => $request->idhuyen_noiohiennay,
            'idxa_noiohiennay' => $request->idxa_noiohiennay,
            'chitiet_noiohiennay' => $request->chitiet_noiohiennay,

            'idquocgia_noisinh' => $request->idquocgia_noisinh,
            'idtinh_noisinh' => $request->idtinh_noisinh,
            'idhuyen_noisinh' => $request->idhuyen_noisinh,
            'idxa_noisinh' => $request->idxa_noisinh,
            'chitiet_noisinh' => $request->chitiet_noisinh,

            'idquocgia_noilamviec' => $request->idquocgia_noilamviec,
            'idtinh_noilamviec' => $request->idtinh_noilamviec,
            'idhuyen_noilamviec' => $request->idhuyen_noilamviec,
            'idxa_noilamviec' => $request->idxa_noilamviec,
            'chitiet_noilamviec' => $request->chitiet_noilamviec,

            'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc,
            'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc,
            'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc,
            'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc,
            'chitiet_thuongtrutruoc' => $request->chitiet_thuongtrutruoc,

            'created_at' => Carbon::now(),
        );
        $idnhankhau = DB::table('tbl_nhankhau')->insertGetId($data_nhankhau);
        $data_sohokhau = array(
            'idnhankhau' => $idnhankhau,
            'idquanhechuho' => $request->idquanhechuho,
            'ngaydangky' => date('Y-m-d', strtotime($request->ngaydangky)),
            'idhoso' => $idhoso,
            'moisinh' => $request->moisinh,
            'created_at' => Carbon::now(),
        );
        DB::table('tbl_sohokhau')->insert($data_sohokhau);

        //------------------Log nhan khau-------------
        $data_log_nhankhau = array(
            'idthutuccutru' => $this->thutuc_dangkynhankhau,
            'type' => 'nhankhau',
            'idnhankhau' => $idnhankhau,
            'idhoso' => $idhoso,
            'moisinh' => $request->moisinh,
            'date_action' => date('Y-m-d', strtotime($request->ngaydangky)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc,
            'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc,
            'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc,
            'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc,
            'chitiet_thuongtrutruoc' => $request->chitiet_thuongtrutruoc,
        );
        DB::table('tbl_history_cutru')->insert( $data_log_nhankhau );
        //------------------End log nhan khau-------------

        return response()->json(['success' => 'Đăng ký thường trú thành công ', 'url' => route('chi-tiet-ho-khau', $idhoso)]);
    }

    public function getChitiethokhau($idhoso)
    {
        $data['list_thongtinhokhau'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('idhoso', $idhoso)
        ->select('tbl_nhankhau.*', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.hokhau_so', 'tbl_sohokhau.idquanhechuho', 'tbl_sohokhau.ngaydangky')
        ->get();
        $data['idhoso'] = $idhoso;
// print_r( $data['list_thongtinhokhau'] ); die;
        return view('nhankhau-layouts.thuongtru.chitiethoso', $data);

    }

    public function getSuanhankhau($id)
    {
        $this->data['countries'] = $this->quocgia->get();
        $this->data['relations'] = $this->relation->get();
        $this->data['religions'] = $this->religion->get();
        $this->data['nations'] = $this->nation->get();
        $this->data['educations'] = $this->education->get();
        $this->data['careers'] = $this->career->get();
        $this->data['list_quanhechuho'] = DB::table('tbl_moiquanhe')
        ->where(array(
            ['loaiquanhe', '=', 'nhanthan']
        ))
        ->get();
        $this->data['nhankhau'] = DB::table('tbl_nhankhau')
        ->join('tbl_sohokhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_nhankhau.id', $id)
        ->select('tbl_nhankhau.*', 'tbl_sohokhau.idhoso', 'tbl_sohokhau.moisinh', 'tbl_sohokhau.idquanhechuho', 'tbl_sohokhau.ngaydangky', 'tbl_sohokhau.id as idsohokhau')
        ->first();
// print_r($this->data['nhankhau']); die;
        return view('nhankhau-layouts.thuongtru.editnhankhau', $this->data);
    }

    public function postSuanhankhau(Request $request, $idnhankhau)
    {

        $validator = Validator::make($request->all(), [
            'hoten' => 'required',
            'birthday' => 'required|date_format:d-m-Y',
            'ngaydangky' => 'required|date_format:d-m-Y',
            'idquoctich' => 'required',
            'idtongiao' => 'required',
            'idquanhechuho' => 'required',
            'gender' => 'required',
            'idsohokhau' => 'required|integer',
            'ghichu' => 'required',
            'date_action' => 'required|date_format:d-m-Y',

            'idquocgia_noisinh' => 'required',
            'idtinh_noisinh' => 'required_if:idquocgia_noisinh,1',
            'idhuyen_noisinh' => 'required_if:idquocgia_noisinh,1',
            'idxa_noisinh' => 'required_if:idquocgia_noisinh,1',

            'idquocgia_nguyenquan' => 'required',
            'idtinh_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idhuyen_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idxa_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',

            'idquocgia_noiohiennay' => 'required',
            'idtinh_noiohiennay' => 'required_if:idquocgia_noiohiennay,1',
            'idhuyen_noiohiennay' => 'required_if:idquocgia_noiohiennay,1',
            'idxa_noiohiennay' => 'required_if:idquocgia_noiohiennay,1',

            'idquocgia_thuongtrutruoc' => 'required_if:ngoaihuyenden,1',
            'idtinh_thuongtrutruoc' => 'required_if:idquocgia_thuongtrutruoc,1',
            'idhuyen_thuongtrutruoc' => 'required_if:idquocgia_thuongtrutruoc,1',
            'idxa_thuongtrutruoc' => 'required_if:idquocgia_thuongtrutruoc,1',


        ], $this->messages);

        if($request->idquanhechuho == 1)
        {
            $validator->errors()->add('idquanhechuho', 'Quan hệ là Chủ hộ đã tồn tại, bạn không được chọn!');
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $data_nhankhau = array(
            'hoten' => $request->hoten,
            'tenkhac' => $request->tenkhac,
            'ngaysinh' => date('Y-m-d', strtotime($request->birthday)),
            'idquoctich' => $request->idquoctich,
            'hochieu_so' => $request->hochieu_so,
            'cmnd_so' => $request->cmnd_so,
            'idtongiao' => $request->idtongiao,
            'iddantoc' => $request->iddantoc,
            'idtrinhdohocvan' => $request->idtrinhdohocvan,
            'idnghenghiep' => $request->idnghenghiep,
            'trinhdochuyenmon' => $request->trinhdochuyenmon,
            'trinhdongoaingu' => $request->trinhdongoaingu,
            'biettiengdantoc' => $request->biettiengdantoc,
            'tomtatbanthan' => $request->description,
            'tomtatgiadinh' => $request->descriptionFamily,
            'tienan_tiensu' => $request->criminalRecord,
            'gioitinh' => $request->gender,

            'idquocgia_nguyenquan' => $request->idquocgia_nguyenquan,
            'idtinh_nguyenquan' => $request->idtinh_nguyenquan,
            'idhuyen_nguyenquan' => $request->idhuyen_nguyenquan,
            'idxa_nguyenquan' => $request->idxa_nguyenquan,
            'chitiet_nguyenquan' => $request->chitiet_nguyenquan,

            'idquocgia_noiohiennay' => $request->idquocgia_noiohiennay,
            'idtinh_noiohiennay' => $request->idtinh_noiohiennay,
            'idhuyen_noiohiennay' => $request->idhuyen_noiohiennay,
            'idxa_noiohiennay' => $request->idxa_noiohiennay,
            'chitiet_noiohiennay' => $request->chitiet_noiohiennay,

            'idquocgia_noisinh' => $request->idquocgia_noisinh,
            'idtinh_noisinh' => $request->idtinh_noisinh,
            'idhuyen_noisinh' => $request->idhuyen_noisinh,
            'idxa_noisinh' => $request->idxa_noisinh,
            'chitiet_noisinh' => $request->chitiet_noisinh,

            'idquocgia_noilamviec' => $request->idquocgia_noilamviec,
            'idtinh_noilamviec' => $request->idtinh_noilamviec,
            'idhuyen_noilamviec' => $request->idhuyen_noilamviec,
            'idxa_noilamviec' => $request->idxa_noilamviec,
            'chitiet_noilamviec' => $request->chitiet_noilamviec,

            'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc,
            'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc,
            'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc,
            'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc,
            'chitiet_thuongtrutruoc' => $request->chitiet_thuongtrutruoc,

            'updated_at' => Carbon::now(),
        );
        DB::table('tbl_nhankhau')->where('id',$idnhankhau)->update($data_nhankhau);

        $data_sohokhau = array(
            'ngaydangky' => date('Y-m-d', strtotime( $request->ngaydangky ) ),
            'idquanhechuho' => $request->idquanhechuho,
            'moisinh' => $request->moisinh,
        );

        DB::table('tbl_sohokhau')->where('id',$request->idsohokhau)->update($data_sohokhau);

        //--------------Ghi log cua ho so----------------------
        $data_log = array(
            'idthutuccutru' => $this->thutuc_dieuchinhthaydoi,
            'type' => 'nhankhau',
            'idhoso' => DB::table('tbl_sohokhau')->where('id',$request->idsohokhau)->value('idhoso'),
            'idnhankhau' => $idnhankhau,
            'date_action' => date('Y-m-d', strtotime( $request->date_action ) ),
            'moisinh' => $request->moisinh,
            'ghichu' => $request->ghichu,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        DB::table('tbl_history_cutru')->insert( $data_log );
        //--------------End ghi log cua ho so----------------------

        return response()->json(['success' => 'Đăng ký thường trú thành công ', 'url' => route('chi-tiet-ho-khau', $request->idhoso)]);
    }

    public function getChitietnhankhau($id)
    {
        $data['nhankhau'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_nhankhau.id', $id)
        ->select('tbl_nhankhau.*', 'tbl_hoso.hokhau_so', 'tbl_hoso.id as idhoso', 'tbl_hoso.hosohokhau_so')
        ->first();
// print_r($data['nhankhau']); die;
        return view('nhankhau-layouts.thuongtru.chitietnhankhau', $data);
    }

    public function getCheckxoathuongtru($id)
    {
        $data['nhankhau'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_nhankhau.id', $id)
        ->select('tbl_nhankhau.*', 'tbl_hoso.hokhau_so', 'tbl_hoso.hosohokhau_so', 'tbl_sohokhau.idquanhechuho', 'tbl_sohokhau.ngaydangky', 'tbl_sohokhau.idhoso')
        ->first();
        $data['list_truonghopxoa'] = DB::table('tbl_thutuccutru')->where('type', 'xoathuongtru')->get();
        $data['countries'] = $this->quocgia->get();
        $data['relations'] = $this->relation->get();
        $data['religions'] = $this->religion->get();
        $data['nations'] = $this->nation->get();
        // print_r($data['list_truonghopxoa']); die;
        if($data['nhankhau']->idquanhechuho == 1)
        {
            $message = array('type' => 'warning', 'content' => 'Người này là chủ hộ, bạn phải thay chủ hộ trước khi xóa thường trú');
            return redirect()->route('thay-doi-chu-ho', $data['nhankhau']->idhoso)->with('alert_message', $message);
        }
        return view('nhankhau-layouts.thuongtru.xoathuongtru', $data);
    }

    public function xoaThuongtru(Request $request, $idnhankhau)
    {
        $validator = Validator::make($request->all(), [
            'idtruonghopxoa' => 'required',
            'ngayxoathuongtru' => 'required',
            'idquocgia_thuongtrumoi' => 'required_if:idtruonghopxoa,'.$this->thutuc_dangkynoimoi,
            'idtinh_thuongtrumoi' => 'required_if:idquocgia_thuongtrumoi,1',
            'idhuyen_thuongtrumoi' => 'required_if:idquocgia_thuongtrumoi,1',
            'idxa_thuongtrumoi' => 'required_if:idquocgia_thuongtrumoi,1',
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $idhoso = DB::table('tbl_sohokhau')->where('idnhankhau',$idnhankhau)->value('idhoso');

        DB::table('tbl_sohokhau')->where('idnhankhau',$idnhankhau)->delete();

        if($request->idtruonghopxoa == $this->thutuc_dangkynoimoi)
        {
            $data_update = array(
                'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
                'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
                'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
                'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
                'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
                );
            DB::table('tbl_nhankhau')->where('id',$idnhankhau)->update($data_update);
        }

        $data_log = array(
            'idthutuccutru' => $request->idtruonghopxoa,
            'type' => 'nhankhau',
            'idhoso' => $idhoso,
            'idnhankhau' => $idnhankhau,
            'ghichu' => $request->lydoxoa,
            'date_action' => date('Y-m-d', strtotime($request->ngayxoathuongtru)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
            'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
            'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
            'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
            'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
        );

        DB::table('tbl_history_cutru')->insert( $data_log );

        return response()->json(['success' => 'Xóa đăng ký thường trú thành công ', 'url' => route('chi-tiet-ho-khau', $request->idhoso)]);
    }

    public function getCheckxoathuongtruHGD($idhoso)
    {
        $data['list_thongtinhokhau'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('idhoso', $idhoso)
        ->select('tbl_nhankhau.*', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.hokhau_so', 'tbl_sohokhau.idquanhechuho', 'tbl_sohokhau.ngaydangky')
        ->get();
        $data['idhoso'] = $idhoso;
        $data['countries'] = $this->quocgia->get();
        $data['relations'] = $this->relation->get();
        $data['religions'] = $this->religion->get();
        $data['nations'] = $this->nation->get();
        $data['list_truonghopxoa'] = DB::table('tbl_thutuccutru')->where('type', 'xoathuongtru')->get();
        // print_r( $data['list_thongtinhokhau'] ); die;
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
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $list_nhankhau = DB::table('tbl_sohokhau')->where('idhoso',$idhoso)->pluck('idnhankhau');
        
        $data_hoso = array(
            'deleted_at' => date('Y-m-d', strtotime($request->ngayxoathuongtru)),
        );

        DB::table('tbl_hoso')->where('id',$idhoso)->update($data_hoso);

        DB::table('tbl_sohokhau')->where('idhoso',$idhoso)->delete();

        $data_log_hogiadinh = array(
            'idthutuccutru' => $request->idtruonghopxoa,
            'type' => 'hogiadinh',
            'idhoso' => $idhoso,
            'date_action' => date('Y-m-d', strtotime($request->ngayxoathuongtru)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
            'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
            'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
            'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
            'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
        );

        DB::table('tbl_history_cutru')->insert( $data_log_hogiadinh );

        $data_log_nhankhau = array();

        foreach ($list_nhankhau as $value)
        {
            $data_log = array(
                'idthutuccutru' => $request->idtruonghopxoa,
                'type' => 'nhankhau',
                'idnhankhau' => $value,
                'idhoso' => $idhoso,
                'date_action' => date('Y-m-d', strtotime($request->ngayxoathuongtru)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'idquocgia_thuongtrumoi' => $request->idquocgia_thuongtrumoi,
                'idtinh_thuongtrumoi' => $request->idtinh_thuongtrumoi,
                'idhuyen_thuongtrumoi' => $request->idhuyen_thuongtrumoi,
                'idxa_thuongtrumoi' => $request->idxa_thuongtrumoi,
                'chitiet_thuongtrumoi' => $request->chitiet_thuongtrumoi,
            );
            $data_log_nhankhau[] = $data_log;
        }

        DB::table('tbl_history_cutru')->insert( $data_log_nhankhau );

        return response()->json(['success' => 'Xóa đăng ký thường trú thành công ', 'url' => route('nhan-khau.index')]);
    }

    public function getCheckcaplaiSHK($idhoso)
    {
        $data['list_thongtinhokhau'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('idhoso', $idhoso)
        ->select('tbl_nhankhau.*', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.hokhau_so', 'tbl_sohokhau.idquanhechuho', 'tbl_sohokhau.ngaydangky')
        ->get();
        $data['idhoso'] = $idhoso;
        $data['countries'] = $this->quocgia->get();
        $data['relations'] = $this->relation->get();
        $data['religions'] = $this->religion->get();
        $data['nations'] = $this->nation->get();
        // print_r( $data['list_thongtinhokhau'] ); die;
        return view('nhankhau-layouts.thuongtru.chitiethosoHGD_caplai', $data);
    }

    public function caplaiSHK(Request $request, $idhoso)
    {
        $validator = Validator::make($request->all(), [
            'ngaycaplai' => 'required|date_format:d-m-Y',
            'ghichu' => 'required',
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $list_nhankhau = DB::table('tbl_sohokhau')->where('idhoso',$idhoso)->pluck('idnhankhau');

        $data_log_hogiadinh = array(
            'idthutuccutru' => $this->thutuc_caplai,
            'type' => 'hogiadinh',
            'idhoso' => $idhoso,
            'ghichu' => $request->ghichu,
            'date_action' => date('Y-m-d', strtotime($request->ngaycaplai)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        DB::table('tbl_history_cutru')->insert( $data_log_hogiadinh );

        $data_log_nhankhau = array();

        foreach ($list_nhankhau as $value)
        {
            $data_log = array(
                'idthutuccutru' => $this->thutuc_caplai,
                'type' => 'nhankhau',
                'idnhankhau' => $value,
                'idhoso' => $idhoso,
                'ghichu' => $request->ghichu,
                'date_action' => date('Y-m-d', strtotime($request->ngaycaplai)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );
            $data_log_nhankhau[] = $data_log;
        }
        DB::table('tbl_history_cutru')->insert( $data_log_nhankhau );
        return response()->json([ 'success' => 'Xóa đăng ký thường trú thành công ', 'url' => route('chi-tiet-ho-khau', $idhoso) ]);
    }

    public function getCheckcapdoiSHK($idhoso)
    {
        $data['list_thongtinhokhau'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('idhoso', $idhoso)
        ->select('tbl_nhankhau.*', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.hokhau_so', 'tbl_sohokhau.idquanhechuho', 'tbl_sohokhau.ngaydangky')
        ->get();
        $data['idhoso'] = $idhoso;
        $data['countries'] = $this->quocgia->get();
        $data['relations'] = $this->relation->get();
        $data['religions'] = $this->religion->get();
        $data['nations'] = $this->nation->get();
        // print_r( $data['list_thongtinhokhau'] ); die;
        return view('nhankhau-layouts.thuongtru.chitiethosoHGD_capdoi', $data);
    }

    public function capdoiSHK(Request $request, $idhoso)
    {
        $validator = Validator::make($request->all(), [
            'ngaycapdoi' => 'required',
            'ghichu' => 'required',
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $list_nhankhau = DB::table('tbl_sohokhau')->where('idhoso',$idhoso)->pluck('idnhankhau');

        $data_log_hogiadinh = array(
            'idthutuccutru' => $this->thutuc_capdoi,
            'type' => 'hogiadinh',
            'idhoso' => $idhoso,
            'ghichu' => $request->ghichu,
            'date_action' => date('Y-m-d', strtotime($request->ngaycapdoi)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        DB::table('tbl_history_cutru')->insert( $data_log_hogiadinh );

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
        DB::table('tbl_history_cutru')->insert( $data_log_nhankhau );
        return response()->json([ 'success' => 'Xóa đăng ký thường trú thành công ', 'url' => route('chi-tiet-ho-khau', $idhoso) ]);
    }

    public function getThaydoichuho($id)
    {
        $data['list_nhankhau'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_hoso.id', $id)
        ->select('tbl_sohokhau.id', 'hoten', 'tbl_sohokhau.idquanhechuho')
        ->get();
        $data['list_quanhechuho'] = DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->get();
        $data['idhoso'] = $id;
        return view('nhankhau-layouts.thuongtru.thaydoichuho', $data);
    }

    public function postThaydoichuho(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'idquanhechuho.*' => 'required'
        ], $this->messages);
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
            DB::table('tbl_sohokhau')->where('id',$request->id_in_sohokhau[$i])->update(['idquanhechuho' => $request->idquanhechuho[$i]]);
        }

        return response()->json(['success' => 'Thay đổi quan hệ chủ hộ thành công ', 'url' => route('chi-tiet-ho-khau', $id)]);
    }

    public function getTachhokhau($id)
    {
        $data['list_nhankhau'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where(
            array(
                ['tbl_hoso.id', '=', $id]
            )
        )
        ->select('tbl_sohokhau.id', 'tbl_nhankhau.id as idnhankhau','hoten', 'tbl_sohokhau.idquanhechuho')
        ->get();
        $list_quanhechuho = DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->get();
        $str = '';
        foreach ($list_quanhechuho as $value)
        {
            $str .= '<option value="'.$value->id.'">'.$value->name.'</option>';
        }
        $data['str_ret'] = $str;
        $data['idhoso'] = $id;
        return view('nhankhau-layouts.thuongtru.tachhokhau', $data);
    }

    public function postTachhokhau(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hosohokhau_so' => 'required|unique:tbl_hoso',
            'so_dktt_so' => 'required|min:2',
            'hokhau_so' => 'required|unique:tbl_hoso',
            'idquanhechuho.*' => 'required',
            'id_in_sohokhau.*' => 'required',
            'nhankhautach' => 'required',
            'date_action' => 'required|date_format:d-m-Y',
        ], $this->messages);

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

//Code tách hộ khẩu
        $data_hoso = array(
            'hosohokhau_so' => $request->hosohokhau_so,
            'hokhau_so' => $request->hokhau_so,
            'so_dktt_so' => $request->so_dktt_so,
            'so_dktt_toso' => $request->so_dktt_toso,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        $idhoso_inserted = DB::table('tbl_hoso')->insertGetId($data_hoso);

        $data_log = array(
            'idthutuccutru' => $this->thutuc_tach,
            'type' => 'hogiadinh',
            'idhoso' => $idhoso_inserted,
            'date_action' => date('Y-m-d', strtotime($request->date_action)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        DB::table('tbl_history_cutru')->insert( $data_log );

        for ($i=0; $i < count($request->id_in_sohokhau); $i++)
        {
            $arrNhankhauUpdate = array(
                'idhoso' => $idhoso_inserted,
                'idquanhechuho' => $request->idquanhechuho[$i],
                'ngaydangky' => date('Y-m-d', strtotime($request->date_action)),
            );
            DB::table('tbl_sohokhau')->where('id',$request->id_in_sohokhau[$i])->update($arrNhankhauUpdate);
            $data_log = array(
                'idthutuccutru' => $this->thutuc_tach,
                'type' => 'nhankhau',
                'idhoso' => $idhoso_inserted,
                'idnhankhau' => $request->idnhankhau[$i],
                'date_action' => date('Y-m-d', strtotime($request->date_action)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );
            DB::table('tbl_history_cutru')->insert( $data_log );
        }

        return response()->json(['success' => 'Tách hộ khẩu thành công ']);
    }

    public function getNhaphokhau($idhoso)
    {
        $data['idhoso'] = $idhoso;
        $data['thongtinhoso'] = DB::table('tbl_sohokhau')
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
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $data['briefs'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where(array(
            ['hosohokhau_so', 'like', '%'.$request->keyword.'%'],
            ['idquanhechuho', '=', 1]
        ))
        ->orWhere(array(
            ['hokhau_so', 'like', '%'.$request->keyword.'%'],
            ['idquanhechuho', '=', 1]
        ))
        ->orWhere(array(
            ['hoten', 'like', '%'.$request->keyword.'%'],
            ['idquanhechuho', '=', 1]
        ))
        ->select('tbl_nhankhau.*', 'tbl_hoso.hokhau_so', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.id as idhoso')
        ->paginate(10);
        $data['idhogoc'] = $request->idhogoc;
        return response()->json(['html' => view('nhankhau-layouts.ajax_component.search_viewhoso', $data)->render()]);
    }

    public function getHoNhap(Request $request, $idhosogoc, $idhosonhap)
    {
        $this->idhosonhap = $idhosonhap;
        $this->idhosogoc = $idhosogoc;
        $data['list_nhankhau'] = DB::table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where( function($query){
            $query->whereIn('tbl_hoso.id', [$this->idhosogoc, $this->idhosonhap]);
        } )
        ->select('tbl_sohokhau.id', 'hoten', 'tbl_sohokhau.idquanhechuho', 'tbl_hoso.id as idhoso', 'tbl_hoso.hokhau_so', 'tbl_hoso.hosohokhau_so', 'so_dktt_so', 'so_dktt_toso', 'ngaynopluu')
        ->get();
        $data['list_quanhechuho'] = DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->get();
        $data['idhosogoc'] = $idhosogoc;
        $data['idhosonhap'] = $idhosonhap;
        return view('nhankhau-layouts.thuongtru.nhaphokhau', $data);
    }

    public function postNhaphokhau(Request $request, $idhosogoc, $idhosonhap)
    {
        $validator = Validator::make($request->all(), [
            'idquanhechuho.*' => 'required|integer',
            'id_in_sohokhau.*' => 'required|integer',
        ], $this->messages);

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
            DB::table('tbl_sohokhau')->where('id',$request->id_in_sohokhau[$i])->update([ 'idhoso' => $idhosogoc, 'idquanhechuho' => $request->idquanhechuho[$i]]);
        }

        DB::table('tbl_hoso')->where('id',$idhosonhap)->delete();

        return response()->json(['success' => 'Thêm nhân khẩu thành công ']);
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
