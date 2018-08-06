<?php

namespace App\UserApp;

use Illuminate\Support\Facades\DB;
use Session;
use Carbon\Carbon;

class TamtruLibrary
{
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
    }

    public static function getTamtruDataIndex($keyword)
    {
        $data = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru');
        if( $keyword )
        {
            $data = $data->where(array(
                ['sotamtru_so', 'like', '%'.$keyword.'%'],
                ['idquanhechuho', '=', 1]
            ))
            ->orWhere(array(
                ['hoten', 'like', '%'.$keyword.'%'],
                ['idquanhechuho', '=', 1]
            ));
        }
        else{
            $data = $data->where('idquanhechuho', 1);
        }
        $data = $data->select('tbl_sotamtru.type', 'tbl_nhankhau.hoten', 'sotamtru_so', 'tbl_sotamtru.id as idsotamtru', 'tbl_sotamtru.idquocgia_tamtru', 'tbl_sotamtru.idtinh_tamtru', 'tbl_sotamtru.idhuyen_tamtru', 'tbl_sotamtru.idxa_tamtru', 'tbl_sotamtru.chitiet_tamtru' )
            ->orderBy('idsotamtru', 'DESC')
            ->paginate(9);
        return $data;
    }

    public static function getChitietSotamtru($idsotamtru, $first = FALSE)
    {
        $data = DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where('idsotamtru', $idsotamtru)
        ->select('tbl_tamtru.deleted_at', 'idsotamtru', 'tamtru_tungay', 'tamtru_denngay', 'tbl_nhankhau.hoten', 'tbl_sotamtru.sotamtru_so', 'tbl_tamtru.idquanhechuho', 'chitiet_tamtru', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idquocgia_tamtru', 'idnhankhau', 'chitiet_thuongtru', 'idxa_thuongtru', 'idhuyen_thuongtru', 'idtinh_thuongtru', 'idquocgia_thuongtru');
        if( $first )
        {
            $data = $data->first();
        }else{
            $data = $data->get();
        }
        return $data;
    }

    public static function getChitietNhankhauTamtru($idnhankhau, $idsotamtru)
    {
        return DB::connection('nhanhokhau')->table('tbl_tamtru')
        ->join('tbl_nhankhau', 'tbl_nhankhau.id', '=', 'tbl_tamtru.idnhankhau')
        ->join('tbl_sotamtru', 'tbl_sotamtru.id', '=', 'tbl_tamtru.idsotamtru')
        ->where(array(
            ['idnhankhau', '=', $idnhankhau],
            ['idsotamtru', '=', $idsotamtru]
        ))
        ->select('tenkhac', 'idnghenghiep', 'ngaydangky', 'tbl_tamtru.id as idtamtru', 'sotamtru_so', 'tbl_tamtru.deleted_at', 'tbl_sotamtru.id as idsotamtru', 'ngaysinh', 'gioitinh', 'idquoctich', 'iddantoc', 'tamtru_tungay', 'tamtru_denngay', 'tbl_nhankhau.hoten', 'tbl_sotamtru.sotamtru_so', 'tbl_tamtru.idquanhechuho', 'chitiet_tamtru', 'idxa_tamtru', 'idhuyen_tamtru', 'idtinh_tamtru', 'idquocgia_tamtru', 'idnhankhau', 'chitiet_thuongtru', 'idxa_thuongtru', 'idhuyen_thuongtru', 'idtinh_thuongtru', 'idquocgia_thuongtru' , 'chitiet_noilamviec', 'idxa_noilamviec', 'idhuyen_noilamviec', 'idtinh_noilamviec', 'idquocgia_noilamviec', 'chitiet_nguyenquan', 'idxa_nguyenquan', 'idhuyen_nguyenquan', 'idtinh_nguyenquan', 'idquocgia_nguyenquan' )
        ->first();
    }

    public static function insertNhankhauTamtruToNhanKhauTable($request, $sotamtru_info, $get_id = TRUE)
    {
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
        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insertGetId($data_nhankhau);
        }
        else{
            return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insert($data_nhankhau);
        }
    }

    public static function insertDataTamtru($request, $idsotamtru, $idnhankhau)
    {
        $data_tamtru = array(
            'idsotamtru' => $idsotamtru,
            'idnhankhau' => $idnhankhau,
            'tamtru_tungay' => date('Y-m-d', strtotime($request->tamtru_tungay)),
            'tamtru_denngay' => date('Y-m-d', strtotime($request->tamtru_denngay)),
            'idquanhechuho' => $request->idquanhechuho,
            'ngaydangky_tamtrunhankhau' => date('Y-m-d', strtotime($request->ngaydangky)),
        );
        return DB::connection('nhanhokhau')->table('tbl_tamtru')->insert( $data_tamtru );
    }

    public static function getPostAddnhankhauRule()
    {
        return [
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

        ];
    }

    public static function getPostSuanhankhauRule($idsotamtru)
    {
        return [
            'sotamtru_so' => 'required|unique:nhanhokhau.tbl_sotamtru,sotamtru_so,'.$idsotamtru,
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
        ];
    }

    public static function updateNhankhauTamtru($request, $idnhankhau)
    {
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
        DB::connection('nhanhokhau')->table('tbl_nhankhau')->where('id',$idnhankhau)->update($data_nhankhau);
    }

    public static function getPostAddSoTamTruCaNhanRule()
    {
        return [
            'idquocgia_thuongtru' => 'required',
            'idtinh_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idhuyen_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idxa_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idquocgia_tamtru' => 'required',
            'idtinh_tamtru' => 'required',
            'idhuyen_tamtru' => 'required',
            'idxa_tamtru' => 'required',
            'chitiet_tamtru' => 'required',
            'sotamtru_so' => 'required|unique:nhanhokhau.tbl_sotamtru',
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

        ];
    }

    public static function insertDataSotamtru($request, $type, $get_id = TRUE)
    {
        $data_sotamtru = array(
            'type' => $type,
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
        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_sotamtru')->insertGetId($data_sotamtru);
        }else
        {
            return DB::connection('nhanhokhau')->table('tbl_sotamtru')->insert($data_sotamtru);
        }
    }

    public static function postAddNhankhauSoTamTruCaNhan($request, $get_id = TRUE)
    {
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

        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insertGetId($data_nhankhau);
        }
        else
        {
            return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insert($data_nhankhau);
        }
    }

    public static function addTamtruCaNhan($request, $id_sotamtru, $id_nhankhau)
    {
        $data_tamtru = array(
            'type' => 'nhankhau',
            'idsotamtru' => $id_sotamtru,
            'idnhankhau' => $id_nhankhau,
            'idquanhechuho' => 1,
            'tamtru_tungay' => date('Y-m-d', strtotime($request->tamtru_tungay)),
            'tamtru_denngay' => date('Y-m-d', strtotime($request->tamtru_denngay)),
            'ngaydangky_tamtrunhankhau' => date('Y-m-d', strtotime($request->ngaydangky)),
        );

        return DB::connection('nhanhokhau')->table('tbl_tamtru')->insertGetId($data_tamtru);
    }

    public static function getStoreRule()
    {
        return [
            'idquocgia_thuongtru' => 'required',
            'idtinh_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idhuyen_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idxa_thuongtru' => 'required_if:idquocgia_thuongtru,1',
            'idquocgia_tamtru' => 'required',
            'idtinh_tamtru' => 'required',
            'idhuyen_tamtru' => 'required',
            'idxa_tamtru' => 'required',
            'chitiet_tamtru' => 'required',
            'sotamtru_so' => 'required|unique:nhanhokhau.tbl_sotamtru',
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

        ];
    }

    public static function insertArrNhankhau($request, $i, $get_id = TRUE)
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
        if( $get_id )
        {
            return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insertGetId($data_nhankhau);
        }
        else
        {
            return DB::connection('nhanhokhau')->table('tbl_nhankhau')->insert($data_nhankhau);
        }
    }

    public static function arrDataTamTru($request, $i, $id_sotamtru, $id_nhankhau)
    {
        $data_tamtru = array(
            'type' => 'hogiadinh',
            'idsotamtru' => $id_sotamtru,
            'idnhankhau' => $id_nhankhau,
            'idquanhechuho' => $request->idquanhechuho[$i],
            'tamtru_tungay' => date('Y-m-d', strtotime($request->tamtru_tungay)),
            'tamtru_denngay' => date('Y-m-d', strtotime($request->tamtru_denngay)),
            'ngaydangky_tamtrunhankhau' => date('Y-m-d', strtotime($request->ngaydangky)),
        );

        return DB::connection('nhanhokhau')->table('tbl_tamtru')->insert($data_tamtru);
    }

}
