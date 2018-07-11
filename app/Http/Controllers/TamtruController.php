<?php

namespace App\Http\Controllers;

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

class TamtruController extends Controller
{
    public $thutuc_dangkytamtru = 12;
    public $thutuc_dieuchinhthaydoi_tamtru = 13;
    public $thutuc_giahantamtru = 14;
    public $thutuc_xoatamtru = 15;
    public $thutuc_capsotamtu = 16;
    public $messages = [
        'idquanhechuho.*.required' => 'Quan hệ với chủ hộ không được trống',
        'hosohokhau_so.required' => 'Hồ sơ hộ khẩu số bị trống.',
        'so_dktt_so.required' => 'Số đăng ký thường chú bị trống',
        'datetime.date_format' => 'Vui lòng nhập chính xác ngày nộp lưu',
        'hokhau_so.required' => 'Hộ khẩu số bị trống',
        'so_dktt_toso.required' => 'Tờ số bị trống',
        'hoten.*.required' => ':attribute Vui lòng nhập họ tên',
        'gender.*.required' => ':attribute Vui lòng chọn giới tính',
        'gender.required' => ':attribute Vui lòng chọn giới tính',
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
        'ghichu.required' => ':attribute Ghi chú/Lý do không được trống',
        'date_action.required' => ':attribute Ngày thực hiện không được trống',
        'idtruonghopxoa.required' => ':attribute Trường hợp xóa không được trống',
        'date_action.date_format' => 'Vui lòng nhập chính xác định dạng ngày cấp lại',
        'keyword.required' => ':attribute Từ khóa tìm kiếm không được trống',
        'keyword.min' => ':attribute Từ khóa tìm kiếm dài ít nhất 3 ký tự',
        'tungay.required' => ':attribute Từ ngày không được trống',
        'denngay.required' => ':attribute Đến ngày không được trống',
        
    ];

    function __construct(NhanKhau $nhankhau, QuocGia $quocgia, Relation $relation, Religion $religion
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        if($request->keyword)
        {
            $data['briefs'] = DB::table('tbl_tamtru')
            ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_tamtru.idnhankhau')
            ->join('tbl_sotamtru', 'tbl_sotamtru.id' , '=', 'tbl_tamtru.idsotamtru')
            ->where(array(
                ['sotamtru_so', 'like', '%'.$request->keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->orWhere(array(
                ['hoten', 'like', '%'.$request->keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->select('tbl_sotamtru.type', 'tbl_nhankhau.hoten', 'sotamtru_so', 'tbl_sotamtru.id as idsotamtru', 'tbl_sotamtru.idquocgia_tamtru', 'tbl_sotamtru.idtinh_tamtru', 'tbl_sotamtru.idhuyen_tamtru', 'tbl_sotamtru.idxa_tamtru', 'tbl_sotamtru.chitiet_tamtru' )
            ->orderBy('idsotamtru', 'DESC')
            ->paginate(9);
        }
        else
        {
            $data['briefs'] = DB::table( 'tbl_tamtru' )
            ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
            ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
            ->where('idquanhechuho', 1)
            ->select('tbl_sotamtru.type', 'tbl_nhankhau.hoten', 'sotamtru_so', 'tbl_sotamtru.id as idsotamtru', 'tbl_sotamtru.idquocgia_tamtru', 'tbl_sotamtru.idtinh_tamtru', 'tbl_sotamtru.idhuyen_tamtru', 'tbl_sotamtru.idxa_tamtru', 'tbl_sotamtru.chitiet_tamtru' )
            ->orderBy('idsotamtru', 'DESC')
            ->paginate(9);
        }

        if( $request->ajax() )
        {
            return response()->json(['html' => view('nhankhau-layouts.ajax_component.tamtru_nhankhautable', $data)->render()]);
        }
        return view('nhankhau-layouts.tamtru.index', $data);
    }

    public function getChitietSotamtru($idsotamtru)
    {
        $data['list_thongtinsotamtru'] = DB::table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where('idsotamtru', $idsotamtru)
        ->select('tbl_tamtru.deleted_at', 'idsotamtru', 'tamtru_tungay', 'tamtru_denngay', 'tbl_nhankhau.hoten', 'tbl_sotamtru.sotamtru_so', 'tbl_tamtru.idquanhechuho', 'chitiet_tamtru', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idquocgia_tamtru', 'idnhankhau', 'chitiet_thuongtru', 'idxa_thuongtru', 'idhuyen_thuongtru', 'idtinh_thuongtru', 'idquocgia_thuongtru')
        ->get();
        $data['idsotamtru'] = $idsotamtru;
        $data['listqh'] = DB::table('tbl_moiquanhe')->pluck('name','id');
        return view('nhankhau-layouts.tamtru.chitiethosotamtru', $data);

    }

    public function getChitietnhankhauTamtru($idnhankhau, $idsotamtru)
    {
        $data['nhankhau'] = DB::table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['idnhankhau', '=', $idnhankhau],
            ['idsotamtru', '=', $idsotamtru]
        ))
        ->select('tbl_tamtru.deleted_at', 'tbl_sotamtru.id as idsotamtru', 'ngaysinh', 'gioitinh', 'idquoctich', 'iddantoc', 'tamtru_tungay', 'tamtru_denngay', 'tbl_nhankhau.hoten', 'tbl_sotamtru.sotamtru_so', 'tbl_tamtru.idquanhechuho', 'chitiet_tamtru', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idquocgia_tamtru', 'idnhankhau', 'chitiet_thuongtru', 'idxa_thuongtru', 'idhuyen_thuongtru', 'idtinh_thuongtru', 'idquocgia_thuongtru' , 'chitiet_noilamviec', 'idxa_noilamviec', 'idhuyen_noilamviec', 'idtinh_noilamviec', 'idquocgia_noilamviec', 'chitiet_nguyenquan', 'idxa_nguyenquan', 'idhuyen_nguyenquan', 'idtinh_nguyenquan', 'idquocgia_nguyenquan' )
        ->first();
        return view('nhankhau-layouts.tamtru.chitietnhankhautamtru', $data);
    }

    public function getAddnhankhau($idsotamtru)
    {
        $this->data['countries'] = $this->quocgia->get();
        $this->data['relations'] = $this->relation->get();
        $this->data['religions'] = $this->religion->get();
        $this->data['nations'] = $this->nation->get();
        $this->data['careers'] = $this->career->get();
        $this->data['list_quanhechuho'] = DB::table('tbl_moiquanhe')
        ->where(array(
            ['loaiquanhe', '=', 'nhanthan'],
            ['id', '!=', 1]
        ))
        ->get();
        $this->data['sotamtru'] = DB::table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['idsotamtru', '=', $idsotamtru]
        ))
        ->select('hoten', 'sotamtru_so', 'idsotamtru', 'chitiet_tamtru', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idquocgia_tamtru' )
        ->first();
        
        return view('nhankhau-layouts.tamtru.addnhankhau', $this->data);
    }

    public function postAddnhankhau(Request $request, $idsotamtru)
    {
        $validator = Validator::make($request->all(), [
            'hoten' => 'required',
            'birthday' => 'required|date_format:d-m-Y',
            'ngaydangky' => 'required|date_format:d-m-Y',
            'idquoctich' => 'required',
            'gender' => 'required',
            'tamtru_tungay' => 'required',
            'tamtru_denngay' => 'required',
            'idquanhechuho' => 'required',

            'idquocgia_nguyenquan' => 'required',
            'idtinh_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idhuyen_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idxa_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',

        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }


        $sotamtru_info = DB::table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['idsotamtru', '=', $idsotamtru],
            ['idquanhechuho', '=', 1],
        ))
        ->select('hoten', 'sotamtru_so', 'idsotamtru', 'chitiet_tamtru', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idquocgia_tamtru', 'chitiet_thuongtru', 'idxa_thuongtru', 'idhuyen_thuongtru', 'idtinh_thuongtru', 'idquocgia_thuongtru' )
        ->first();

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

            'idquocgia_thuongtru' => $sotamtru_info->idquocgia_thuongtru,
            'idtinh_thuongtru' => $sotamtru_info->idtinh_thuongtru,
            'idhuyen_thuongtru' => $sotamtru_info->idhuyen_thuongtru,
            'idxa_thuongtru' => $sotamtru_info->idxa_thuongtru,
            'chitiet_thuongtru' => $sotamtru_info->chitiet_thuongtru,

            'created_at' => Carbon::now(),
        );

        $idnhankhau = DB::table('tbl_nhankhau')->insertGetId($data_nhankhau);

        $data_tamtru = array(
            'idsotamtru' => $idsotamtru,
            'idnhankhau' => $idnhankhau,
            'tamtru_tungay' => date('Y-m-d', strtotime($request->tamtru_tungay)),
            'tamtru_denngay' => date('Y-m-d', strtotime($request->tamtru_denngay)),
            'idquanhechuho' => $request->idquanhechuho,
            'ngaydangky_tamtrunhankhau' => date('Y-m-d', strtotime($request->ngaydangky)),
        );
        DB::table('tbl_tamtru')->insert( $data_tamtru );

        $data_log = array(
            'idthutuccutru' => $this->thutuc_dangkytamtru,
            'type' => 'nhankhau',
            'idnhankhau' => $idnhankhau,
            'idsotamtru' => $idsotamtru,
            'date_action' => date('Y-m-d', strtotime($request->ngaydangky)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'idquocgia_thuongtru' => $sotamtru_info->idquocgia_thuongtru,
            'idtinh_thuongtru' => $sotamtru_info->idtinh_thuongtru,
            'idhuyen_thuongtru' => $sotamtru_info->idhuyen_thuongtru,
            'idxa_thuongtru' => $sotamtru_info->idxa_thuongtru,
            'chitiet_thuongtru' => $sotamtru_info->chitiet_thuongtru,

            'idquocgia_tamtru' => $sotamtru_info->idquocgia_tamtru,
            'idtinh_tamtru' => $sotamtru_info->idtinh_tamtru,
            'idhuyen_tamtru' => $sotamtru_info->idhuyen_tamtru,
            'idxa_tamtru' => $sotamtru_info->idxa_tamtru,
            'chitiet_tamtru' => $sotamtru_info->chitiet_tamtru,
        );
        DB::table('tbl_history_cutru')->insert( $data_log );

        return response()->json(['success' => 'Đăng ký thường trú thành công ', 'url' => route('chi-tiet-so-tam-tru', $idsotamtru)]);
    }

    public function getSuanhankhau($idnhankhau, $idsotamtru)
    {
        $this->data['countries'] = $this->quocgia->get();
        $this->data['relations'] = $this->relation->get();
        $this->data['religions'] = $this->religion->get();
        $this->data['nations'] = $this->nation->get();
        $this->data['careers'] = $this->career->get();
        $this->data['list_quanhechuho'] = DB::table('tbl_moiquanhe')
        ->where(array(
            ['loaiquanhe', '=', 'nhanthan']
        ))
        ->get();
        $this->data['nhankhau'] = DB::table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['idnhankhau', '=', $idnhankhau],
            ['idsotamtru', '=', $idsotamtru]
        ))
        ->select('sotamtru_so','tbl_tamtru.id as idtamtru', 'ngaydangky', 'tenkhac', 'idnghenghiep', 'tbl_sotamtru.id as idsotamtru', 'ngaysinh', 'gioitinh', 'idquoctich', 'iddantoc', 'tamtru_tungay', 'tamtru_denngay', 'tbl_nhankhau.hoten', 'tbl_sotamtru.sotamtru_so', 'tbl_tamtru.idquanhechuho', 'chitiet_tamtru', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idquocgia_tamtru', 'idnhankhau', 'chitiet_thuongtru', 'idxa_thuongtru', 'idhuyen_thuongtru', 'idtinh_thuongtru', 'idquocgia_thuongtru' , 'chitiet_noilamviec', 'idxa_noilamviec', 'idhuyen_noilamviec', 'idtinh_noilamviec', 'idquocgia_noilamviec', 'chitiet_nguyenquan', 'idxa_nguyenquan', 'idhuyen_nguyenquan', 'idtinh_nguyenquan', 'idquocgia_nguyenquan' )
        ->first();
        
        return view('nhankhau-layouts.tamtru.editnhankhau', $this->data);
    }

    public function postSuanhankhau(Request $request, $idnhankhau, $idsotamtru)
    {
        $validator = Validator::make($request->all(), [
            'sotamtru_so' => 'required|unique:tbl_sotamtru,sotamtru_so,'.$idsotamtru,
            'idquocgia_thuongtru' => 'required',
            'idtinh_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idhuyen_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idxa_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idquocgia_tamtru' => 'required',
            'idtinh_tamtru' => 'required',
            'idhuyen_tamtru' => 'required',
            'idxa_tamtru' => 'required',
            'chitiet_tamtru' => 'required',
            'tamtru_tungay' => 'required',
            'tamtru_denngay' => 'required',
            'idtamtru' => 'required',
            
            'hoten' => 'required',
            'birthday' => 'required|date_format:d-m-Y',
            'ngaydangky' => 'required|date_format:d-m-Y',
            'idquoctich' => 'required',
            'gender' => 'required',
            'ngaysua' => 'required',
            'ghichu' => 'required',

            'idquocgia_nguyenquan' => 'required',
            'idtinh_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idhuyen_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',
            'idxa_nguyenquan' => 'required_if:idquocgia_nguyenquan,1',

        ], $this->messages);

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

        ], $this->messages);

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
        ], $this->messages);

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
        ], $this->messages);

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
        ], $this->messages);

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
