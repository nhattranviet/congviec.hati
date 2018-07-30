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
        $list_module = $request->idmodule;

        if(count( $list_donvi ) == 0) return response()->json(['error' => array('Đơn vị phân quyền phải được chọn')]);
        if(count( $list_nhomquyen ) == 0 && $request->quick_set_role == NULL ) return response()->json(['error' => array('Nhóm quyền phải được chọn')]);
        if(count( $list_module ) == 0 ) return response()->json(['error' => array('Module phân quyền phải được chọn')]);

        $num = count( $list_chucnang );
        for ($i=0; $i < $num; $i++)
        { 
            if( $list_chucnang[$i] != NULL &&  $list_chucnang_level == NULL )
            {
                return response()->json(['error' => array('Mức quyền của mỗi chức năng phải được chọn')]);
            }
        }

        $list_user = UserLibrary::getUserByDonVi($list_donvi);
        $list_chucnang_module = UserLibrary::getChucnangByModule( $list_module );
        $arrDefaultRole = config('user_config.idnhomquyen_level_default');
        $arrUser = array();
        foreach ($list_user as $user)
        {
            $arrUser[$user->idnhomquyen][] = $user->iduser;
        }

        foreach ($arrUser as $idnhomquyen => $users)
        {
            
            foreach ($users as $user)
            {
                UserLibrary::destroyCurrentNomalRole($user, $list_module);
                $data_chucnang_user_add = array();
                foreach ($list_chucnang_module as $chucnang)
                {
                    $data_chucnang_user_add[] = array(
                        'iduser' => $user,
                        'idchucnang' => $chucnang->idchucnang,
                        'idlevel' => $arrDefaultRole[$idnhomquyen],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    );
                }
                DB::table('tbl_user_chucnang')->insert( $data_chucnang_user_add );

            }
        }


        return response()->json(['success' => 'Phân quyền thành công ']);
    }

    public function privateSetPermisson($userid)
    {
        $data['list_module'] = UserLibrary::getListModule();
        $data['list_level'] = UserLibrary::getListLevel();
        return view('cahtcore.permission.privateSet', $data);
    }

    public function postPrivateSetPermisson(Request $request)
    {
        
    }

    public function getChucnang($idmodule = NULL)
    {
        $data['list_level'] = UserLibrary::getListLevel();
        $data['list_chucnang'] = UserLibrary::getListChucnang($idmodule);
        return response()->json(['html' => view('cahtcore.permission.module_chucnang_component', $data)->render()]);
    }
}
