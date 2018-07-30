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
        // $validator = Validator::make($request->all(), [
        //     'iddonvi.*' => 'required|array|numeric',
        // ], $this->messages);

        // // $validator->after(function ($validator) use ($request) {
        // //     // $validator->errors()->add('hanxuly', 'Hạn xử lý xong phải trước hoặc bằng hạn công việc!');
        // //     // if($request->hanxuly &&  strtotime($request->hanxuly) > strtotime($request->hancongviec) )
        // //     // {
        // //     //     $validator->errors()->add('hanxuly', 'Hạn xử lý xong phải trước hoặc bằng hạn công việc!');
        // //     // }
        // // });
        
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()->all()]);
        // }

        // dd( $request->idnhomquyen );
        $list_donvi = $request->iddonvi;

        $list_chucnang = $request->idchucnang;
        $list_chucnang_level = $request->chucnang_level;
        echo '<pre>';
        print_r( $list_chucnang );
        echo '</pre>';
        echo '<br>';
        echo '<pre>';
        print_r( $list_chucnang_level );
        echo '</pre>'; die;
        // if(count( $request->iddonvi ) == 0) return response()->json(['error' => array('Đơn vị phân quyền phải được chọn')]);
        // if(count( $request->idnhomquyen ) == 0) return response()->json(['error' => array('Nhóm quyền phải được chọn')]);
        $num = count( $list_chucnang_level );
        //
        for ($i=0; $i < $num; $i++)
        { 
            if( $list_chucnang[$i] != NULL )
            {
                echo $list_chucnang[$i];  //.'-'.$list_chucnang_level[$i].'<br>';
                // return response()->json(['error' => array('Muc quyen phai duoc chon')]);
            }
        }

        // return response()->json(['success' => 'Thêm nhân khẩu thành công ']);
    }

    public function getChucnang($idmodule = NULL)
    {
        $data['list_level'] = UserLibrary::getListLevel();
        $data['list_chucnang'] = UserLibrary::getListChucnang($idmodule);
        return response()->json(['html' => view('cahtcore.permission.module_chucnang_component', $data)->render()]);
    }
}
