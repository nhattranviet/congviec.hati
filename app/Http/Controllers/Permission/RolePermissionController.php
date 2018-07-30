<?php

namespace App\Http\Controllers\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Session;
use App\User;
use App\UserApp\UserLibrary;

class RolePermissionController extends Controller
{
    public $messages = [
        'iddonvi.*.required|array|numeric' => 'Đơn vị không được để trốngs',
    ];
    public function index()
    {
        $data['list_nhomquyen'] = UserLibrary::getListRole();
        $data['list_donvi'] = UserLibrary::getListDonvi();
        $data['list_module'] = UserLibrary::getListModule();
        $data['list_level'] = UserLibrary::getListLevel();
        return view('cahtcore.permission.index', $data);
    }

    public function setRole(Request $request)
    {   
        $list_donvi = $request->iddonvi;
        $list_nhomquyen = $request->idnhomquyen;
        $list_chucnang = $request->chucnang;
        $list_chucnang_level = $request->chucnang_level;
        if(count( $list_donvi ) == 0) return response()->json(['error' => array('Đơn vị phân quyền phải được chọn')]);
        if(count( $list_nhomquyen ) == 0 && $request->quick_set_role == NULL ) return response()->json(['error' => array('Nhóm quyền phải được chọn')]);
        $num = count( $list_chucnang_level );
        for ($i=0; $i < $num; $i++)
        { 
            if( $list_chucnang[$i] != NULL &&  $list_chucnang_level == NULL )
            {
                return response()->json(['error' => array('Mức quyền của mỗi chức năng phải được chọn')]);
            }
        }

        dd(UserLibrary::getUserByDonVi($list_donvi));




        // return response()->json(['success' => 'Thêm nhân khẩu thành công ']);
    }

    public function getChucnang($idmodule = NULL)
    {
        $data['list_level'] = UserLibrary::getListLevel();
        $data['list_chucnang'] = UserLibrary::getListChucnang($idmodule);
        return response()->json(['html' => view('cahtcore.permission.module_chucnang_component', $data)->render()]);
    }
}
