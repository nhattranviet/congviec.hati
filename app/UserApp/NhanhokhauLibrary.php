<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;
use Session;
use Carbon\Carbon;

class NhanhokhauLibrary
{
    public $connection = 'nhanhokhau';

    public static function getMessageRule()
    {
        return [
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
            'ngayxoathuongtru.req;uired' => 'Ngày xóa thường trú không được để trống',
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
    }

    public static function getStoreRule()
    {
        return [
            'hosohokhau_so' => 'required|unique:nhanhokhau.tbl_hoso',
            'so_dktt_so' => 'required|min:2',
            'hokhau_so' => 'required|unique:nhanhokhau.tbl_hoso',
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

        ];
    }

    public static function getDangkythuongtruRule()
    {
        return [
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
        ];
    }

    public static function getSuaNhanKhauRule()
    {
        return [
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
        ];
    }

    public static function updatePostSuaNhankhau( $request, $idnhankhau )
    {
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
        return DB::connection('nhanhokhau')->table('tbl_nhankhau')->where('id',$idnhankhau)->update($data_nhankhau);
    }

    public static function getUpdateRule($idhoso)
    {
        return [
            'hosohokhau_so' => 'required|min:2|unique:nhanhokhau.tbl_hoso,hosohokhau_so,'.$idhoso,
            'so_dktt_so' => 'required|min:2',
            'ghichu' => 'required',
            'hokhau_so' => 'required|unique:nhanhokhau.tbl_hoso,hokhau_so,'.$idhoso,
            'date_action' => 'required|date_format:d-m-Y',
        ];
    }

    public static function updateHoso($request, $idhoso)
    {
        $hoso_update = array(
            'hosohokhau_so' => $request->hosohokhau_so,
            'hokhau_so' => $request->hokhau_so,
            'so_dktt_so' => $request->so_dktt_so,
            'so_dktt_toso' => $request->so_dktt_toso,
            'updated_at' => Carbon::now(),
            'ngaynopluu' => date('Y-m-d', strtotime($request->datetime)),
        );
        DB::connection('nhanhokhau')->table('tbl_hoso')->where('id',$idhoso)->update($hoso_update);
    }


    public static function getListHosoIndex($keyword = NULL)
    {
        $data = DB::connection('nhanhokhau')->table('tbl_sohokhau')
            ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
            ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso');
        if($keyword != NULL)
        {
            $data = $data->where(array(
                ['hosohokhau_so', 'like', '%'.$keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->orWhere(array(
                ['hokhau_so', 'like', '%'.$keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->orWhere(array(
                ['hoten', 'like', '%'.$keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->select('tbl_nhankhau.*', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.id as idhoso', 'tbl_hoso.hokhau_so','tbl_sohokhau.id as idsohokhau')
            ->orderBy('idhoso', 'DESC')
            ->paginate(9);
        }
        else
        {
            $data = $data->where('idquanhechuho', 1)
            ->select('tbl_nhankhau.*', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.id as idhoso', 'tbl_hoso.hokhau_so','tbl_sohokhau.id as idsohokhau')
            ->orderBy('idhoso', 'DESC')
            ->paginate(9);
        }
        return $data;
    }

    public static function getHosoInfo($idhoso)
    {
        return DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where(array(
            ['tbl_hoso.id', '=', $idhoso],
            ['idquanhechuho', '=', 1]
        ))
        ->select('tbl_nhankhau.*', 'tbl_hoso.hokhau_so', 'tbl_hoso.hosohokhau_so')
        ->first();
    }

    public static function insertHoso($request, $get_id = TRUE)
    {
        $data_ho = array(
            'hosohokhau_so' => $request->hosohokhau_so,
            'hokhau_so' => $request->hokhau_so,
            'so_dktt_so' => $request->so_dktt_so,
            'so_dktt_toso' => $request->so_dktt_toso,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_hoso')->insertGetId( $data_ho );
        }
        else{
            return DB::connection('nhanhokhau')->table('tbl_hoso')->insert( $data_ho );
        }
    }

    public static function insertArrNhankhau($request, $i, $get_id = TRUE)
    {
            $nhankhau_data = array(
                'hoten' => $request->hoten[$i],
                'tenkhac' => $request->tenkhac[$i],
                'ngaysinh' => date('Y-m-d', strtotime($request->birthday[$i])),
                'idquoctich' => $request->idquoctich[$i],
                'idquocgia_nguyenquan' => $request->idquocgia_nguyenquan[$i],
                'idtinh_nguyenquan' => $request->idtinh_nguyenquan[$i],
                'idhuyen_nguyenquan' => $request->idhuyen_nguyenquan[$i],
                'idxa_nguyenquan' => $request->idxa_nguyenquan[$i],
                'chitiet_nguyenquan' => $request->chitiet_nguyenquan[$i],

                'idquocgia_thuongtru' => $request->idquocgia_thuongtru,
                'idtinh_thuongtru' => $request->idtinh_thuongtru,
                'idhuyen_thuongtru' => $request->idhuyen_thuongtru,
                'idxa_thuongtru' => $request->idxa_thuongtru,
                'chitiet_thuongtru' => $request->chitiet_thuongtru,

                'idquocgia_noiohiennay' => $request->idquocgia_noiohiennay[$i],
                'idtinh_noiohiennay' => $request->idtinh_noiohiennay[$i],
                'idhuyen_noiohiennay' => $request->idhuyen_noiohiennay[$i],
                'idxa_noiohiennay' => $request->idxa_noiohiennay[$i],
                'chitiet_noiohiennay' => $request->chitiet_noiohiennay[$i],

                'idquocgia_noisinh' => $request->idquocgia_noisinh[$i],
                'idtinh_noisinh' => $request->idtinh_noisinh[$i],
                'idhuyen_noisinh' => $request->idhuyen_noisinh[$i],
                'idxa_noisinh' => $request->idxa_noisinh[$i],
                'chitiet_noisinh' => $request->chitiet_noisinh[$i],

                'idquocgia_noilamviec' => $request->idquocgia_noilamviec[$i],
                'idtinh_noilamviec' => $request->idtinh_noilamviec[$i],
                'idhuyen_noilamviec' => $request->idhuyen_noilamviec[$i],
                'idxa_noilamviec' => $request->idxa_noilamviec[$i],
                'chitiet_noilamviec' => $request->chitiet_noilamviec[$i],

                'idquocgia_thuongtrutruoc' => $request->idquocgia_thuongtrutruoc[$i],
                'idtinh_thuongtrutruoc' => $request->idtinh_thuongtrutruoc[$i],
                'idhuyen_thuongtrutruoc' => $request->idhuyen_thuongtrutruoc[$i],
                'idxa_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],
                'chitiet_thuongtrutruoc' => $request->idxa_thuongtrutruoc[$i],

                'hochieu_so' => $request->hochieu_so[$i],
                'cmnd_so' => $request->cmnd_so[$i],
                'idtongiao' => $request->idtongiao[$i],
                'iddantoc' => $request->iddantoc[$i],
                'idtrinhdohocvan' => $request->idtrinhdohocvan[$i],
                'idnghenghiep' => $request->idnghenghiep[$i],
                'trinhdochuyenmon' => $request->trinhdochuyenmon[$i],
                'trinhdongoaingu' => $request->trinhdongoaingu[$i],
                'biettiengdantoc' => $request->biettiengdantoc[$i],
                'tomtatbanthan' => $request->description[$i],
                'tomtatgiadinh' => $request->descriptionFamily[$i],
                'tienan_tiensu' => $request->criminalRecord[$i],
                'gioitinh' => $request->gender[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );

            if( $get_id )
            {
                return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insertGetId( $nhankhau_data );
            }
            else
            {
                return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insert( $nhankhau_data );
            }
    }

    public static function insertANhanKhauInDangKyThuongTru($request, $data_diachi, $get_id = TRUE)
    {
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
        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insertGetId( $data_nhankhau );
        }
        else
        {
            return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insert( $data_nhankhau );
        }
    }

    public static function getChitiethokhau($idhoso)
    {
        return DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('idhoso', $idhoso)
        ->select('tbl_nhankhau.*', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.hokhau_so', 'tbl_sohokhau.idquanhechuho', 'tbl_sohokhau.ngaydangky')
        ->get();
    }

    public static function getChitietNhankhau($idnhankhau)
    {
        return DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_nhankhau.id', $idnhankhau)
        ->select('tbl_nhankhau.*', 'tbl_hoso.hokhau_so', 'tbl_hoso.id as idhoso', 'tbl_hoso.hosohokhau_so', 'tbl_sohokhau.idquanhechuho')
        ->first();
    }

    public static function insertArrNhankhauToSohokhau($request, $i, $idhoso, $idnhankhau, $get_id = 'TRUE')
    {
        $data_sohokhau_insert = array(
            'idhoso' => $idhoso,
            'idnhankhau' => $idnhankhau,
            'idquanhechuho' => $request->idquanhechuho[$i],
            'ngaydangky' => date('Y-m-d', strtotime($request->ngaydangky[$i])),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );
        
        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_sohokhau')->insertGetId( $data_sohokhau_insert );
        }
        else
        {
            return DB::connection('nhanhokhau')->table('tbl_sohokhau')->insert( $data_sohokhau_insert );
        }
    }

    public static function insertNhankhauToSohokhau($request, $idhoso, $idnhankhau, $get_id = 'TRUE')
    {
        $data_sohokhau = array(
            'idnhankhau' => $idnhankhau,
            'idquanhechuho' => $request->idquanhechuho,
            'ngaydangky' => date('Y-m-d', strtotime($request->ngaydangky)),
            'idhoso' => $idhoso,
            'moisinh' => $request->moisinh,
            'created_at' => Carbon::now(),
        );
        
        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_sohokhau')->insertGetId( $data_sohokhau );
        }
        else
        {
            return DB::connection('nhanhokhau')->table('tbl_sohokhau')->insert( $data_sohokhau );
        }
    }

    public static function getNhankhauInfo($idnhankhau)
    {
        return DB::connection('nhanhokhau')->table('tbl_nhankhau')
        ->join('tbl_sohokhau', 'tbl_nhankhau.id', '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id', '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_nhankhau.id', $idnhankhau)
        ->select('tbl_nhankhau.*', 'tbl_sohokhau.idhoso', 'tbl_sohokhau.moisinh', 'tbl_sohokhau.idquanhechuho', 'tbl_sohokhau.ngaydangky', 'tbl_sohokhau.id as idsohokhau')
        ->first();
    }

    public static function logCutru($data_log)
    {
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        DB::connection('nhanhokhau')->table('tbl_history_cutru')->insert( $data_log );
    }

    public static function deleteNhankhauSohokhau($idnhankhau)
    {
        return DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('idnhankhau',$idnhankhau)->delete();
    }

    public static function getIdhosoOfNhankhau($idnhankhau)
    {
        return DB::connection('nhanhokhau')->table('tbl_sohokhau')->where('idnhankhau',$idnhankhau)->value('idhoso');
    }

    public static function getListNhankhauHoso($idhoso)
    {
        return DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where('tbl_hoso.id', $idhoso)
        ->select('tbl_nhankhau.id as idnhankhau', 'tbl_sohokhau.id', 'hoten', 'tbl_sohokhau.idquanhechuho')
        ->get();
    }

    public static function getDataForTimkiemHoso( $keyword )
    {
        return DB::connection('nhanhokhau')->table('tbl_sohokhau')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id' , '=', 'tbl_sohokhau.idnhankhau')
        ->join('tbl_hoso', 'tbl_hoso.id' , '=', 'tbl_sohokhau.idhoso')
        ->where(array(
            ['hosohokhau_so', 'like', '%'.$keyword.'%'],
            ['idquanhechuho', '=', 1]
        ))
        ->orWhere(array(
            ['hokhau_so', 'like', '%'.$keyword.'%'],
            ['idquanhechuho', '=', 1]
        ))
        ->orWhere(array(
            ['hoten', 'like', '%'.$keyword.'%'],
            ['idquanhechuho', '=', 1]
        ))
        ->select('tbl_nhankhau.*', 'tbl_hoso.hokhau_so', 'tbl_hoso.hosohokhau_so', 'tbl_hoso.id as idhoso')
        ->paginate(10);
    }

    public static function getListQuocgia($array_pluck = FALSE)
    {
        if($array_pluck)
        {
           return DB::table('tbl_quocgia')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_quocgia')->get();
        }
        
    }

    public static function getListTinhTP($idquocgia, $array_pluck = FALSE)
    {
        if ($array_pluck)
        {
            return DB::table('tbl_tinh_tp')->where('idquocgia', $idquocgia)->pluck('name', 'id')->toArray();
        }
        else
        {
            return DB::table('tbl_tinh_tp')->where('idquocgia', $idquocgia)->get();
        }
        
    }

    public static function getListHuyenTX($idtinhtp, $array_pluck = FALSE)
    {
        if($array_pluck)
        {
           return DB::table('tbl_huyen_tx')->where('idtinhtp', $idtinhtp)->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_huyen_tx')->where('idtinhtp', $idtinhtp)->get();
        }
        
    }

    public static function getListXaPhuongTT($idhuyentx, $array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_xa_phuong_tt')->where('idhuyentx', $idhuyentx)->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_xa_phuong_tt')->where('idhuyentx', $idhuyentx)->get();
        }
        
    }

    public static function getListMoiQuanHe($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->get();
        }
        
    }

    public static function getListTonGiao($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_tongiao')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_tongiao')->get();
        }
        
    }

    public static function getListDanToc($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_dantoc')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_dantoc')->get();
        }
        
    }

    public static function getListTrinhDoHocVan($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_trinhdohocvan')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_trinhdohocvan')->get();
        }
        
    }

    public static function getListNgheNghiep($array_pluck = FALSE)
    {
        if( $array_pluck )
        {
           return DB::table('tbl_nghenghiep')->pluck('name', 'id')->toArray();
        }
        else {
            return DB::table('tbl_nghenghiep')->get();
        }
        
    }


}
