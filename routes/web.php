<?php

use App\Http\Controllers\TaiKhoanController;
use App\NhanKhau;
use App\Hokhau;
use App\Brief;
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
//-------------------END CÁN BỘ-----------------------

Route::get('test', function () {
    $date1 = '2014-06-08';
    $date2 = '2012-05-09';
    if ($date1 > $date2)
    echo "$date1 gần đây hơn so vơi $date2";
    else
    echo "$date2 gần đây hơn so vơi $date1";
});




