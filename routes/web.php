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
Route::get('/', 'HomeController@index');
//--------------------NGƯỜI DÙNG---------------------------
// Route::get('/nguoi-dung/getLogin', 'NguoidungController@getLogin')->name('getLogin');
// Route::post('/nguoi-dung/postLogin', 'NguoidungController@postLogin')->name('postLogin');

// Route::get('/nguoi-dung/getRegister', 'NguoidungController@getRegister');
// Route::get('/register', 'NguoidungController@getRegister');
// Route::post('/nguoi-dung/postRegister', 'NguoidungController@postRegister')->name('postRegister');

// Route::get('/nguoi-dung/getLogout', 'NguoidungController@getLogout')->name('getLogout');
Route::get('/logout', 'NguoidungController@getLogout')->name('getLogout');
//--------------------End NGƯỜI DÙNG---------------------------




Route::get('/tai-khoan', 'TaiKhoanController@index');
Route::resource('/nhan-khau', 'NhanKhauController');
Route::post('/nhan-khau/store', 'NhanKhauController@store')->name('nhankhau.store');
Route::get('/nhan-khau/ajax_index', 'NhanKhauController@index')->name('nhankhau.ajax_index');
Route::post('/nhan-khau/{id}', 'NhanKhauController@update')->name('nhankhau.update');
Route::get('/nhan-khau/provinces/{id}', 'NhanKhauController@getProvinces');
Route::get('/nhan-khau/districts/{id}', 'NhanKhauController@getDistricts');
Route::get('/nhan-khau/wards/{id}', 'NhanKhauController@getWards');

Route::get('/nhan-khau/{id}/dang-ky-thuong-tru', 'NhanKhauController@getDangkythuongtru');
Route::post('/nhan-khau/{id}/dang-ky-thuong-tru', 'NhanKhauController@postDangkythuongtru')->name('dang-ky-thuong-tru');

Route::get('/nhan-khau/{idhoso}/chi-tiet-ho-khau', 'NhanKhauController@getChitiethokhau')->name('chi-tiet-ho-khau');
Route::get('/nhan-khau/{idnhankhau}/chi-tiet-nhan-khau', 'NhanKhauController@getChitietnhankhau');

Route::get('/nhan-khau/{id}/sua-nhan-khau', 'NhanKhauController@getSuanhankhau');
Route::post('/nhan-khau/{id}/sua-nhan-khau', 'NhanKhauController@postSuanhankhau')->name('sua-nhan-khau');

Route::get('/nhan-khau/{id}/check-xoa-thuong-tru', 'NhanKhauController@getCheckxoathuongtru');
Route::post('/nhan-khau/{id}/xoa-thuong-tru', 'NhanKhauController@xoaThuongtru')->name('xoa-thuong-tru');

Route::get('/nhan-khau/{idhoso}/check-xoa-thuong-tru-HDG', 'NhanKhauController@getCheckxoathuongtruHGD');
Route::post('/nhan-khau/{idhoso}/xoa-thuong-tru-HGD', 'NhanKhauController@xoaThuongtruHGD')->name('xoa-thuong-tru-HDG');

Route::get('/nhan-khau/{idhoso}/check-cap-lai-SHK', 'NhanKhauController@getCheckcaplaiSHK')->name('get-check-cap-lai-SHK');
Route::post('/nhan-khau/{idhoso}/cap-lai-SHK', 'NhanKhauController@caplaiSHK')->name('post-cap-lai-SHK');

Route::get('/nhan-khau/{idhoso}/check-cap-doi-SHK', 'NhanKhauController@getCheckcapdoiSHK')->name('get-check-cap-doi-SHK');
Route::post('/nhan-khau/{idhoso}/cap-doi-SHK', 'NhanKhauController@capdoiSHK')->name('post-cap-doi-SHK');

Route::get('/nhan-khau/{idhoso}/thay-doi-chu-ho', 'NhanKhauController@getThaydoichuho');
Route::post('/nhan-khau/{idhoso}/thay-doi-chu-ho', 'NhanKhauController@postThaydoichuho')->name('thay-doi-chu-ho');

Route::get('/nhan-khau/{idhoso}/tach-ho-khau', 'NhanKhauController@getTachhokhau')->name('get-tach-ho-khau');
Route::post('/nhan-khau/{idhoso}/tach-ho-khau', 'NhanKhauController@postTachhokhau')->name('post-tach-ho-khau');

Route::get('/nhan-khau/{idhoso}/get-ho-khau-nhap', 'NhanKhauController@getNhaphokhau')->name('get-nhap-ho-khau');
Route::get('/nhan-khau/{idhosogoc}/{idhosonhap}/nhap-ho-khau', 'NhanKhauController@getHoNhap')->name('get-ho-khau-de-nhap');
Route::get('/search-ho-so', 'NhanKhauController@postTimkiemhoso')->name('post-tim-kiem-ho-so');
Route::post('/nhan-khau/{idhosogoc}/{idhosonhap}/nhap-ho-khau', 'NhanKhauController@postNhaphokhau')->name('post-nhap-ho-khau');

Route::get('/bao-cao-nhan-khau', 'BaocaoThongkeController@getBaocaonhankhau')->name('get-bao-cao-nhan-khau');
// Route::get('/post-bao-cao-nhan-khau', 'NhanKhauController@getBaocaonhankhauToResult')->name('post-bao-cao-nhan-khau');
Route::get('/get-bao-cao-nhan-khau', 'BaocaoThongkeController@getBaocaonhankhauToResult')->name('post-bao-cao-nhan-khau');

// Route::get('/thong-ke/{ngaydau?}/{ngaycuoi?}', 'NhanKhauController@getThongke')->name('thong-ke');
Route::get('/thong-ke', 'BaocaoThongkeController@getThongke')->name('thong-ke');
Route::get('/get-thong-ke-nhan-khau', 'BaocaoThongkeController@getThongkeToResult')->name('get-thong-ke-nhan-khau');

//-------------------TẠM TRÚ--------------------------
Route::resource('/tam-tru', 'TamtruController');
Route::get('/tam-tru/{idsotamtru}/chi-tiet-so-tam-tru', 'TamtruController@getChitietSotamtru')->name('chi-tiet-so-tam-tru');
Route::get('/tam-tru/{idnhankhau}/{idsotamtru}/chi-tiet-nhan-khau', 'TamtruController@getChitietnhankhauTamtru')->name('chi-tiet-nhan-khau-tam-tru');

Route::get('/tam-tru/{idnhankhau}/{idsotamtru}/sua-nhan-khau', 'TamtruController@getSuanhankhau')->name('get-sua-nhan-khau-tam-tru');
Route::post('/tam-tru/{idnhankhau}/{idsotamtru}/sua-nhan-khau', 'TamtruController@postSuanhankhau')->name('post-sua-nhan-khau-tam-tru');

Route::get('/tam-tru/{idsotamtru}/get-add-nhan-khau', 'TamtruController@getAddnhankhau')->name('get-add-nhan-khau-tam-tru');
Route::post('/tam-tru/{idsotamtru}/post-add-nhan-khau', 'TamtruController@postAddnhankhau')->name('post-add-nhan-khau-tam-tru');

Route::get('/get-add-so-tam-tru-ca-nhan', 'TamtruController@getAddSoTamTruCaNhan')->name('get-add-so-tam-tru-ca-nhan');
Route::post('/post-add-so-tam-tru-ca-nhan', 'TamtruController@postAddSoTamTruCaNhan')->name('post-add-so-tam-tru-ca-nhan');

Route::get('/tam-tru/{idnhankhau}/{idsotamtru}/get-xoa-tam-tru-nhan-khau', 'TamtruController@getXoaTamTruNhanKhau')->name('get-xoa-tam-tru-nhan-khau');
Route::post('/tam-tru/{idnhankhau}/{idsotamtru}/post-xoa-tam-tru-nhan-khau', 'TamtruController@postXoaTamTruNhanKhau')->name('post-xoa-tam-tru-nhan-khau');

Route::get('/tam-tru/{idnhankhau}/{idsotamtru}/get-gia-han-tam-tru-nhan-khau', 'TamtruController@getGiaHanTamTruNhanKhau')->name('get-gia-han-tam-tru-nhan-khau');
Route::post('/tam-tru/{idnhankhau}/{idsotamtru}/post-gia-han-tam-tru-nhan-khau', 'TamtruController@postGiaHanTamTruNhanKhau')->name('post-gia-han-tam-tru-nhan-khau');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

//-------------------CÔNG VIỆC-----------------------
Route::get('/cong-viec', 'CongviecController@index')->name('cong-viec.index');
Route::get('/cong-viec/create', 'CongviecController@create')->name('get-create-cong-viec');
Route::post('/cong-viec/create', 'CongviecController@store')->name('post-create-cong-viec');
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
Route::get('/can-bo/add_old_data', 'CanboController@add_old_data');
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
        "Trực Ban, 4, 2, 15",
    ];

    //Họ ten, cap bac, chuc vu, id_iddonvi_iddoi
    foreach ($data as $value)
    {
        $a = explode( ',', $value );
        
        $idconnguoi = DB::connection('coredb')->table('tbl_connguoi')->insertGetId(
            [
                'hoten' => $a[0],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        $idcanbo = DB::connection('coredb')->table('tbl_canbo')->insertGetId(
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
        $check = DB::connection('coredb')->table('users')->where('username', $username)->count();
        $username = ( $check == 0 ) ? $username : $username.'_'.$idcanbo ;

        $iduser = DB::connection('coredb')->table('users')->insertGetId(
            [
                'idcanbo' => $idcanbo,
                'username' => $username,
                'email' => $username.'@hati.bca',
                'password' => Hash::make('123456'),
                'idnhomquyen' => 3,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
    
    // print_r($a);
});




