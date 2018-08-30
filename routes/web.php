<?php
// use App\Http\Controllers\TaiKhoanController;
// use Carbon\Carbon;
use App\UserApp\UserLibrary;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

Route::get('/test', function(){
    echo date('w', 1535302800);
    die;
    $a = DB::connection('test')->table('tbl_congviec')->get();
    // $a = DB::connection('catp')->table('tbl_congviec')->join('tbl_congviec_chuyentiep', 'tbl_congviec_chuyentiep.idcongviec', '=', 'tbl_congviec.idcongviec')->get();
    $canbo_list_id = [
        '279' => '1',
        '280' => '1',
        '281' => '2',
        '282' => '3',
        '283' => '4',
        '284' => '11',
        '285' => '5',
        '286' => '6',
        '287' => '8',
        '288' => '16',
        '289' => '12',
        '290' => '24',
        '291' => '10',
        '292' => '13',
        '293' => '4',
        '294' => '15',
        '295' => '9',
        '296' => '18',
        '297' => '23',
        '298' => '19',
        '299' => '17',
        '300' => '7',
        '301' => '20',
        '302' => '22',
        '303' => '21',
        '304' => '14',
        '305' => '1'
    ];

    $list_doi = [
        '1' => '11',
        '2' => '12',
        '23' => '12',
        '24' => '13',
        '25' => '14',
        '26' => '12',
    ];
    $data_chuanhoa = array();
    
    foreach ($a as $congviec)
    {
        $data_cv = array(
            'idcanbo_creater' => 1,
            'id_iddonvi_iddoi_creater' => 12,
            'sotailieu' => $congviec->sotailieu,
            'trichyeu' => $congviec->trichyeu,
            'hancongviec' => ($congviec->hancongviec) ? date('Y-m-d', $congviec->hancongviec) : NULL,
            'noisoanthao' => $congviec->noisoanthao,
            'chitiet' => ($congviec->urlfile) ? '<p><a href="/'.$congviec->urlfile.'">Tài liệu đính kèm</a></p>' : NULL,
            'idstatus' => $congviec->idstatus,
            'thoigianhoanthanh' => ($congviec->thoigianhoanthanh) ? date('Y-m-d', $congviec->thoigianhoanthanh) : NULL,
            'thoigiangiao' => ($congviec->thoigiangiao) ? date('Y-m-d', $congviec->thoigiangiao) : NULL,
            'created_at' => ($congviec->created) ? date('Y-m-d H:i:s', $congviec->created) : NULL,
        );
        $idcongviec = DB::table('tbl_congviec')->insertGetId( $data_cv );
        $data_cv_chuyentiep = DB::connection('test')->table('tbl_congviec_chuyentiep')->where('idcongviec', $congviec->idcongviec)->get()->toArray();
        $data_cv_chuyentiep_chuanhoa = [];
        foreach ($data_cv_chuyentiep as $congviec)
        {
            $congviec_chuyentiep = [
                'idcongviec' => $idcongviec,
                'idcanbonhan' => ($congviec->idnguoinhan) ? $canbo_list_id[$congviec->idnguoinhan] : NULL,
                'ghichu' => $congviec->ghichu,
                'timechuyentiep' => ($congviec->timechuyentiep) ? date('Y-m-d H:i:s', $congviec->timechuyentiep) : NULL,
                'order' => ($congviec->order) ? $congviec->order : NULL,
                'id_iddonvi_iddoi_nhan' => ($congviec->iddoinhan) ? $list_doi[$congviec->iddoinhan] : NULL,
                'created_at' => ($congviec->timechuyentiep) ? date('Y-m-d H:i:s', $congviec->timechuyentiep) : NULL,
            ];
            $data_cv_chuyentiep_chuanhoa[] = $congviec_chuyentiep ;
        }
        DB::table('tbl_congviec_chuyentiep')->insert( $data_cv_chuyentiep_chuanhoa );
    }
    // print_r($data_cv_chuyentiep_chuanhoa);

});
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

// $ControllerFunction
Auth::routes();

Route::get('/', function(){
    if( Session::has('userinfo') )
    {
        $iddonvi = UserLibrary::getIdDonViOfCanBo ( Session::get('userinfo')->idcanbo );
        $default_route = config('user_config.default_route.'.$iddonvi);
        if( $default_route )
        {
            return redirect()->route($default_route);
        }
        else
        {
            echo 'stop'; die;
        }
    }
    else {
        return redirect()->route('login');
    }
    
});
// Route::get('/', 'CongviecController@index');

//----------------------------BASECONTROLLER---------------------------

Route::any('/ckfinder-get-connector', 'BaseController@ckfinder_getConnector')->name('ckfinder-get-connector');
Route::any('/ckfinder-get-view', 'BaseController@getCkfinderView')->name('ckfinder-get-view');

//----------------------------End BASECONTROLLER---------------------------
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
// Route::get('/tai-khoan', 'TaiKhoanController@index');
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
Route::get('/get-bao-cao-nhan-khau-ToResult', 'Nhanhokhau\BaocaoThongkeController@getBaocaonhankhauToResult')->name('post-bao-cao-nhan-khau-ToResult');

// Route::get('/thong-ke/{ngaydau?}/{ngaycuoi?}', 'Nhanhokhau\NhanKhauController@getThongke')->name('thong-ke');
Route::get('/thong-ke', 'Nhanhokhau\BaocaoThongkeController@getThongke')->name('thong-ke');
Route::get('/get-thong-ke-nhan-khau', 'Nhanhokhau\BaocaoThongkeController@getThongkeToResult')->name('get-thong-ke-nhan-khau');
Route::get('/nhan-khau/{id}/get-hk-01', 'Nhanhokhau\BaocaoThongkeController@getHK01')->name('get-hk-01');

Route::get('/test-thong-ke', 'Nhanhokhau\BaocaoThongkeController@testThongke')->name('test-thong-ke');

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

Route::get('/tam-tru/{idsotamtru}/thay-doi-chu-ho-tam-tru', 'Nhanhokhau\TamtruController@getThaydoichuho')->name('get-thay-doi-chu-ho-tam-tru');
Route::post('/tam-tru/{idsotamtru}/thay-doi-chu-ho-tam-tru', 'Nhanhokhau\TamtruController@postThaydoichuho')->name('post-thay-doi-chu-ho-tam-tru');

Route::get('/tam-tru-check-qua-han', 'Nhanhokhau\TamtruController@checkTamtruQuahan')->name('check-qua-han');

Route::get('/nhan-ho-khau-home', 'Nhanhokhau\HomeNhanhokhauController@index')->name('nhan-ho-khau-home');

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
Route::get('/cong-viec-forgetSessionCheckModal', 'CongviecController@forgetSessionCheckModal')->name('forgetSessionCheckModal');
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
Route::get('/can-bo/{idcanbo?}/editHoso', 'CanboController@editHoso')->name('can-bo-editHoso');
Route::post('/can-bo/{idcanbo?}/selfUpdate', 'CanboController@selfUpdate')->name('can-bo-selfUpdate');
Route::get('/can-bo/{iddonvi}/exportListCanBo', 'CanboController@exportListCanBo')->name('exportListCanBo');

Route::get('/can-bo/add_old_data', 'CanboController@add_old_data');
Route::get('/ajax-get-can-bo/{id_iddonvi_iddoi?}', 'CanboController@getCanbo')->name('ajax-get-can-bo');

//-------------------END CÁN BỘ-----------------------

//-------------------NHẬT KÝ CÔNG TÁC-----------------
Route::get('/nhat-ky-cong-tac-cb', 'NhatkycongtacController@nhatkycanbo_index')->name('nhat-ky-cong-tac-cb.index');
Route::get('/nhat-ky-cong-tac-cb/create/{ngay?}', 'NhatkycongtacController@nhatkycanbo_create')->name('nhat-ky-cong-tac-cb.create');
Route::post('/nhat-ky-cong-tac-cb/store', 'NhatkycongtacController@nhatkycanbo_store')->name('nhat-ky-cong-tac-cb.store');
Route::get('/nhat-ky-cong-tac-cb/{idnhatky}/edit', 'NhatkycongtacController@nhatkycanbo_edit')->name('nhat-ky-cong-tac-cb.edit');
Route::post('/nhat-ky-cong-tac-cb/{idnhatky}/update', 'NhatkycongtacController@nhatkycanbo_update')->name('nhat-ky-cong-tac-cb.update');
Route::get('/nhat-ky-cong-tac-cb/{idnhatky}/delete', 'NhatkycongtacController@nhatkycanbo_delete')->name('nhat-ky-cong-tac-cb.delete');

Route::get('/nhat-ky-cong-tac-doi', 'NhatkycongtacController@nhatkydoi_index')->name('nhat-ky-cong-tac-doi.index');
Route::get('/nhat-ky-cong-tac-doi/create/{ngay?}', 'NhatkycongtacController@nhatkydoi_create')->name('nhat-ky-cong-tac-doi.create');
Route::post('/nhat-ky-cong-tac-doi/store', 'NhatkycongtacController@nhatkydoi_store')->name('nhat-ky-cong-tac-doi.store');
Route::get('/nhat-ky-cong-tac-doi/{idnhatky}/edit', 'NhatkycongtacController@nhatkydoi_edit')->name('nhat-ky-cong-tac-doi.edit');
Route::post('/nhat-ky-cong-tac-doi/{idnhatky}/update', 'NhatkycongtacController@nhatkydoi_update')->name('nhat-ky-cong-tac-doi.update');
Route::get('/nhat-ky-cong-tac-doi/{idnhatky}/delete', 'NhatkycongtacController@nhatkydoi_delete')->name('nhat-ky-cong-tac-doi.delete');

Route::post('/nhat-ky-cong-tac/multi-Duyet-Nhat-ky', 'NhatkycongtacController@multiDuyetNhatky')->name('nhat-ky-cong-tac.multi-Duyet-Nhat-ky');
Route::get('/nhat-ky-cong-tac/theo-doi-nhat-ky', 'NhatkycongtacController@theodoinhatky')->name('nhat-ky-cong-tac-doi.theodoinhatky');
//-------------------END NHẬT KÝ CÔNG TÁC-------------

//-------------------PERMISSION-----------------------
Route::get('/permission', 'Permission\RolePermissionController@index');
Route::post('/permission/set-role', 'Permission\RolePermissionController@setRole')->name('permission-set-role');
Route::get('/permission/{iduser}/set-private-role', 'Permission\RolePermissionController@privateSetPermisson')->name('set-private-role');
Route::post('/permission/{iduser}/set-private-role', 'Permission\RolePermissionController@postPrivateSetPermisson')->name('post-set-private-role');
Route::get('/ajax-get-chuc-nang/{iduser}/{idmodule}', 'Permission\RolePermissionController@getChucnang')->name('ajax-get-chuc-nang');
//-------------------END PERMISSION-----------------------









