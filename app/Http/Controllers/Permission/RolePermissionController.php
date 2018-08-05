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
                UserLibrary::destroyCurrentRole($user, $list_module);
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
        $data['iduser'] = $userid;
        return view('cahtcore.permission.privateSet', $data);
    }

    public function postPrivateSetPermisson(Request $request, $iduser)
    {
        $list_chucnang_post = $request->chucnang;
        $list_level_post = $request->chucnang_level;
        $idmodule = $request->idmodule;
        $list_current_user_module_role = UserLibrary::getUserRoleModule($iduser, $idmodule);
        $num = count( $list_chucnang_post );

        $chucnang_level_post = array();
        for ($i=0; $i < $num; $i++)
        { 
            if( $list_chucnang_post[$i] != NULL &&  $list_level_post[$i] == NULL )
            {
                return response()->json(['error' => array('Mức quyền của mỗi chức năng phải được chọn')]);
            }
            $chucnang_level_post[$list_chucnang_post[$i]] = $list_level_post[$i];
        }
        // print_r( $chucnang_level_post ); die;

        $arr_chucnang_post = array();
        foreach ($list_chucnang_post as $chucnang) {
            if( $chucnang  != NULL )
            {
                $arr_chucnang_post[] = $chucnang;
            }
        }
        $arr_chucnang_post_db = array_keys($list_current_user_module_role);

        $arr_chucnang_add = array_diff($arr_chucnang_post, $arr_chucnang_post_db);
        $arr_chucnang_del = array_diff($arr_chucnang_post_db, $arr_chucnang_post);
        $arr_chucnang_maybe_update = array_diff($arr_chucnang_post, $arr_chucnang_add);

        //Update role
        if( count($arr_chucnang_maybe_update) > 0 )
        {
            foreach ($arr_chucnang_maybe_update as $chucnang)
            {
                if( $chucnang_level_post[$chucnang] != $list_current_user_module_role[$chucnang] )
                {
                    DB::table('tbl_user_chucnang')->where(array( ['iduser', '=', $iduser], ['idchucnang', '=', $chucnang] ) )->update( ['idlevel' => $chucnang_level_post[$chucnang], 'private' => 1 ] );
                }
            }
        }

        //Add role
        if( count($arr_chucnang_add) > 0 )
        {
            $data_add = array();
            foreach ($arr_chucnang_add as $value)
            {
                $data_add[] = array(
                    'iduser' => $iduser,
                    'idchucnang' => $value,
                    'idlevel' => $chucnang_level_post[$value],
                    'private' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );
            }
            DB::table('tbl_user_chucnang')->insert( $data_add );
        }

        if( count( $arr_chucnang_del ) > 0 )
        {
            DB::table('tbl_user_chucnang')->where('iduser', $iduser)->whereIn('idchucnang', $arr_chucnang_del)->delete();
        }
        
        return response()->json(['success' => 'Phân quyền thành công ']);
    }

    public function getChucnang($iduser, $idmodule)
    {
        $data['list_level'] = UserLibrary::getListLevel();
        $data['list_chucnang'] = UserLibrary::getListChucnang($idmodule);
        $data['list_chucnang_db'] = UserLibrary::getUserRoleModule($iduser, $idmodule);
        $data['arr_list_chucnang'] = array();
        $data['arr_list_level'] = array();
        foreach ($data['list_chucnang_db'] as $idchucnang => $idlevel)
        {
            $data['arr_list_chucnang'][] = $idchucnang;
            $data['arr_list_level'][] = $idlevel;
        }
        return response()->json(['html' => view('cahtcore.permission.module_chucnang_component', $data)->render()]);
    }
}
