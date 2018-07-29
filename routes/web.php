<?php

use App\Http\Controllers\TaiKhoanController;
use App\NhanKhau;
use App\Hokhau;
use App\Brief;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', 'CongviecController@index');
//--------------------NGƯỜI DÙNG---------------------------
// Route::get('/nguoi-dung/getLogin', 'NguoidungController@getLogin')->name('getLogin');
Route::post('/nguoi-dung/postLogin', 'NguoidungController@postLogin')->name('postLogin');
// Route::get('/nguoi-dung/getRegister', 'NguoidungController@getRegister');
// Route::get('/register', 'NguoidungController@getRegister');
// Route::post('/nguoi-dung/postRegister', 'NguoidungController@postRegister')->name('postRegister');

// Route::get('/nguoi-dung/getLogout', 'NguoidungController@getLogout')->name('getLogout');
Route::get('/logout', 'NguoidungController@getLogout')->name('getLogout');
Route::post('/change-password/', 'NguoidungController@changePassword')->name('nguoi-dung-changepassword');
//------------------------------END NGƯỜI DÙNG ---------------------------
Route::get('/tai-khoan', 'TaiKhoanController@index');
Route::resource('/nhan-khau', 'Nhanhokhau\NhanKhauController');
Route::post('/nhan-khau/store', 'Nhanhokhau\NhanKhauController@store')->name('nhankhau.store');
Route::get('/nhan-khau/ajax_index', 'Nhanhokhau\NhanKhauController@index')->name('nhankhau.ajax_index');
Route::post('/nhan-khau/{id}', 'Nhanhokhau\NhanKhauController@update')->name('nhankhau.update');
Route::get('/nhan-khau/provinces/{id}', 'Nhanhokhau\NhanKhauController@getProvinces');
Route::get('/nhan-khau/districts/{id}', 'Nhanhokhau\NhanKhauController@getDistricts');
Route::get('/nhan-khau/wards/{id}', 'Nhanhokhau\NhanKhauController@getWards');

Route::get('/nhan-khau/{id}/dang-ky-thuong-tru', 'Nhanhokhau\NhanKhauController@getDangkythuongtru');
Route::post('/nhan-khau/{id}/dang-ky-thuong-tru', 'Nhanhokhau\NhanKhauController@postDangkythuongtru')->name('dang-ky-thuong-tru');

Route::get('/nhan-khau/{idhoso}/chi-tiet-ho-khau', 'Nhanhokhau\NhanKhauController@getChitiethokhau')->name('chi-tiet-ho-khau');
Route::get('/nhan-khau/{idnhankhau}/chi-tiet-nhan-khau', 'Nhanhokhau\NhanKhauController@getChitietnhankhau');

Route::get('/nhan-khau/{id}/sua-nhan-khau', 'Nhanhokhau\NhanKhauController@getSuanhankhau');
Route::post('/nhan-khau/{id}/sua-nhan-khau', 'Nhanhokhau\NhanKhauController@postSuanhankhau')->name('sua-nhan-khau');

Route::get('/nhan-khau/{id}/check-xoa-thuong-tru', 'Nhanhokhau\NhanKhauController@getCheckxoathuongtru');
Route::post('/nhan-khau/{id}/xoa-thuong-tru', 'Nhanhokhau\NhanKhauController@xoaThuongtru')->name('xoa-thuong-tru');

Route::get('/nhan-khau/{idhoso}/check-xoa-thuong-tru-HDG', 'Nhanhokhau\NhanKhauController@getCheckxoathuongtruHGD');
Route::post('/nhan-khau/{idhoso}/xoa-thuong-tru-HGD', 'Nhanhokhau\NhanKhauController@xoaThuongtruHGD')->name('xoa-thuong-tru-HDG');

Route::get('/nhan-khau/{idhoso}/check-cap-lai-SHK', 'Nhanhokhau\NhanKhauController@getCheckcaplaiSHK')->name('get-check-cap-lai-SHK');
Route::post('/nhan-khau/{idhoso}/cap-lai-SHK', 'Nhanhokhau\NhanKhauController@caplaiSHK')->name('post-cap-lai-SHK');

Route::get('/nhan-khau/{idhoso}/check-cap-doi-SHK', 'Nhanhokhau\NhanKhauController@getCheckcapdoiSHK')->name('get-check-cap-doi-SHK');
Route::post('/nhan-khau/{idhoso}/cap-doi-SHK', 'Nhanhokhau\NhanKhauController@capdoiSHK')->name('post-cap-doi-SHK');

Route::get('/nhan-khau/{idhoso}/thay-doi-chu-ho', 'Nhanhokhau\NhanKhauController@getThaydoichuho');
Route::post('/nhan-khau/{idhoso}/thay-doi-chu-ho', 'Nhanhokhau\NhanKhauController@postThaydoichuho')->name('thay-doi-chu-ho');

Route::get('/nhan-khau/{idhoso}/tach-ho-khau', 'Nhanhokhau\NhanKhauController@getTachhokhau')->name('get-tach-ho-khau');
Route::post('/nhan-khau/{idhoso}/tach-ho-khau', 'Nhanhokhau\NhanKhauController@postTachhokhau')->name('post-tach-ho-khau');

Route::get('/nhan-khau/{idhoso}/get-ho-khau-nhap', 'Nhanhokhau\NhanKhauController@getNhaphokhau')->name('get-nhap-ho-khau');
Route::get('/nhan-khau/{idhosogoc}/{idhosonhap}/nhap-ho-khau', 'Nhanhokhau\NhanKhauController@getHoNhap')->name('get-ho-khau-de-nhap');
Route::get('/search-ho-so', 'Nhanhokhau\NhanKhauController@postTimkiemhoso')->name('post-tim-kiem-ho-so');
Route::post('/nhan-khau/{idhosogoc}/{idhosonhap}/nhap-ho-khau', 'Nhanhokhau\NhanKhauController@postNhaphokhau')->name('post-nhap-ho-khau');

Route::get('/bao-cao-nhan-khau', 'Nhanhokhau\BaocaoThongkeController@getBaocaonhankhau')->name('get-bao-cao-nhan-khau');
// Route::get('/post-bao-cao-nhan-khau', 'Nhanhokhau\NhanKhauController@getBaocaonhankhauToResult')->name('post-bao-cao-nhan-khau');
Route::get('/get-bao-cao-nhan-khau', 'Nhanhokhau\BaocaoThongkeController@getBaocaonhankhauToResult')->name('post-bao-cao-nhan-khau');

// Route::get('/thong-ke/{ngaydau?}/{ngaycuoi?}', 'Nhanhokhau\NhanKhauController@getThongke')->name('thong-ke');
Route::get('/thong-ke', 'Nhanhokhau\BaocaoThongkeController@getThongke')->name('thong-ke');
Route::get('/get-thong-ke-nhan-khau', 'Nhanhokhau\BaocaoThongkeController@getThongkeToResult')->name('get-thong-ke-nhan-khau');

//-------------------TẠM TRÚ--------------------------
Route::resource('/tam-tru', 'Nhanhokhau\TamtruController');
Route::get('/tam-tru/{idsotamtru}/chi-tiet-so-tam-tru', 'Nhanhokhau\TamtruController@getChitietSotamtru')->name('chi-tiet-so-tam-tru');
Route::get('/tam-tru/{idnhankhau}/{idsotamtru}/chi-tiet-nhan-khau', 'Nhanhokhau\TamtruController@getChitietnhankhauTamtru')->name('chi-tiet-nhan-khau-tam-tru');

Route::get('/tam-tru/{idnhankhau}/{idsotamtru}/sua-nhan-khau', 'Nhanhokhau\TamtruController@getSuanhankhau')->name('get-sua-nhan-khau-tam-tru');
Route::post('/tam-tru/{idnhankhau}/{idsotamtru}/sua-nhan-khau', 'Nhanhokhau\TamtruController@postSuanhankhau')->name('post-sua-nhan-khau-tam-tru');

Route::get('/tam-tru/{idsotamtru}/get-add-nhan-khau', 'Nhanhokhau\TamtruController@getAddnhankhau')->name('get-add-nhan-khau-tam-tru');
Route::post('/tam-tru/{idsotamtru}/post-add-nhan-khau', 'Nhanhokhau\TamtruController@postAddnhankhau')->name('post-add-nhan-khau-tam-tru');

Route::get('/get-add-so-tam-tru-ca-nhan', 'Nhanhokhau\TamtruController@getAddSoTamTruCaNhan')->name('get-add-so-tam-tru-ca-nhan');
Route::post('/post-add-so-tam-tru-ca-nhan', 'Nhanhokhau\TamtruController@postAddSoTamTruCaNhan')->name('post-add-so-tam-tru-ca-nhan');

Route::get('/tam-tru/{idnhankhau}/{idsotamtru}/get-xoa-tam-tru-nhan-khau', 'Nhanhokhau\TamtruController@getXoaTamTruNhanKhau')->name('get-xoa-tam-tru-nhan-khau');
Route::post('/tam-tru/{idnhankhau}/{idsotamtru}/post-xoa-tam-tru-nhan-khau', 'Nhanhokhau\TamtruController@postXoaTamTruNhanKhau')->name('post-xoa-tam-tru-nhan-khau');

Route::get('/tam-tru/{idnhankhau}/{idsotamtru}/get-gia-han-tam-tru-nhan-khau', 'Nhanhokhau\TamtruController@getGiaHanTamTruNhanKhau')->name('get-gia-han-tam-tru-nhan-khau');
Route::post('/tam-tru/{idnhankhau}/{idsotamtru}/post-gia-han-tam-tru-nhan-khau', 'Nhanhokhau\TamtruController@postGiaHanTamTruNhanKhau')->name('post-gia-han-tam-tru-nhan-khau');

Route::get('/home', 'HomeController@index')->name('home');

//-------------------CÔNG VIỆC-----------------------
Route::get('/cong-viec', 'CongviecController@index')->name('cong-viec.index');
Route::get('/cong-viec/create', 'CongviecController@create')->name('get-create-cong-viec');
Route::post('/cong-viec/create', 'CongviecController@store')->name('post-create-cong-viec');
Route::get('/cong-viec/{idcongviec}/edit', 'CongviecController@edit')->name('get-edit-cong-viec');
Route::post('/cong-viec/{idcongviec}/edit', 'CongviecController@update')->name('post-edit-cong-viec');
Route::get('/cong-viec/{idcongviec}', 'CongviecController@show')->name('get-show-cong-viec');
Route::get('/cong-viec/{idcongviec}/delete', 'CongviecController@delete')->name('get-delete-cong-viec');
Route::get('/cong-viec/{idcongviec}/delete_confirm', 'CongviecController@destroy')->name('get-delete-cong-viec_confirm');
Route::get('/cong-viec/{idcongviec}/chuyentiep', 'CongviecController@chuyentiep')->name('get-chuyentiep-cong-viec');
Route::post('/cong-viec/{idcongviec}/chuyentiep', 'CongviecController@postChuyentiep')->name('post-chuyentiep-cong-viec');
Route::get('/cong-viec/{idnodecongviec}/deleteNode', 'CongviecController@deleteNodeChuyentiep')->name('get-delte-node-chuyen-tiep');
Route::get('/cong-viec/{idcongviec}/toggle-congviec-status', 'CongviecController@toggle_congviec_status')->name('toggle-congviec-status');
//-------------------END CÔNG VIỆC-----------------------

//-------------------ĐƠN VỊ - ĐỘI-----------------------
Route::get('/don-vi', 'DonviController@index')->name('don-vi.index');
Route::get('/don-vi/{iddonvi}/set-doi', 'DonviController@setdoi')->name('don-vi-get-set-doi');
Route::post('/don-vi/{iddonvi}/set-doi', 'DonviController@store_set_doi')->name('don-vi-post-set-doi');
Route::get('/ajax-get-doi/{iddonvi?}', 'DonviController@getDoi')->name('ajax-get-doi');
//-------------------ĐƠN VỊ - ĐỘI-----------------------

//-------------------CÁN BỘ-----------------------
Route::get('/can-bo', 'CanboController@index')->name('can-bo.index');
Route::get('/can-bo/create', 'CanboController@create')->name('get-create-can-bo');
Route::post('/can-bo/create', 'CanboController@store')->name('can-bo.store');
Route::get('/can-bo/{idcanbo}/edit', 'CanboController@edit')->name('can-bo.edit');
Route::post('/can-bo/{idcanbo}/update', 'CanboController@update')->name('can-bo.update');
Route::get('/can-bo/showinfo/{idcanbo?}', 'CanboController@showinfo')->name('can-bo-showinfo');
Route::get('/can-bo/{idcanbo?}/editInfo', 'CanboController@editInfo')->name('can-bo-editInfo');
Route::get('/can-bo/add_old_data', 'CanboController@add_old_data');
Route::get('/ajax-get-can-bo/{id_iddonvi_iddoi?}', 'CanboController@getCanbo')->name('ajax-get-can-bo');

//-------------------END CÁN BỘ-----------------------

Route::get('test', function () {
    die;
    $data = [
        "Trần Hải Trung, 10, 4, 11",
        "Phạm Viết Hùng, 10, 3, 11",
        "Nguyễn Thị Kim Chung, 9, 3, 11",
        "Nguyễn Hữu Chí, 8, 3, 11",
        "Phan Thị Huyền Trang, 7, 2, 12",
        "Nguyễn Văn Khánh, 7, 13, 13",
        "Ngô Đức Thìn, 6, 13, 12",
        "Nguyễn Thị Hải Yến, 4, 13, 12",
        "Lê Thái Hà, 9, 2, 13",
        "Lê Ngọc Hưng, 6, 1, 14",
        "Thái Văn Trung, 5, 13, 13",
        "Trần Danh Thiết, 7, 13, 14",
        "Phan Mạnh, 7, 13, 13",
        "Trần Văn Huân, 7, 13, 13",
        "Nguyễn Ngọc Mai, 5, 13, 13",
        "Đậu Duy Hưng, 8, 2, 14",
        "Nguyễn Xuân Thanh, 6, 1, 13",
        "Nguyễn Văn Vũ, 5, 13, 14",
        "Nguyễn Bảo Trung, 4, 13, 14",
        "Lê Thanh Bình, 6, 13, 14",
        "Nguyễn Văn Nam, 6, 13, 14",
        "Nguyễn Quốc Tiến, 5, 13, 12",
        "Đặng Văn Kỷ, 5, 13, 14",
        "Bùi Thị Trâm, 4, 13, 14",
        "Lưu Thị Hoài Phương, 6, 13, 14",
        "Hà Huy Phong, 4, 13, 13",
        "Trực Ban PC44, 4, 2, 15",
    ];
    //Họ ten, cap bac, chuc vu, id_iddonvi_iddoi
    foreach ($data as $value)
    {
        $a = explode( ',', $value );
        $idconnguoi = DB::table('tbl_connguoi')->insertGetId(
            [
                'hoten' => $a[0],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        $idcanbo = DB::table('tbl_canbo')->insertGetId(
        [
            'idconnguoi' => $idconnguoi,
            'idcapbac' => $a[1],
            'idchucvu' => $a[2],
            'id_iddonvi_iddoi' => $a[3],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]
        );
        $username = $this->vn_str_filter($a[0]);
        $check = DB::table('users')->where('username', $username)->count();
        $username = ( $check == 0 ) ? $username : $username.'_'.$idcanbo ;
        $iduser = DB::table('users')->insertGetId(
            [
                'idcanbo' => $idcanbo,
                'username' => $username,
                'email' => $username.'@hati.bca',
                'password' => Hash::make('123456'),
                'idnhomquyen' => 1,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
    // print_r($a);
});






