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
    public function index()
    {
        $data['list_nhomquyen'] = UserLibrary::getListRole();
        $data['list_donvi'] = UserLibrary::getListDonvi();
        $data['list_module'] = UserLibrary::getListModule();
        $data['list_level'] = UserLibrary::getListLevel();
        return view('cahtcore.permission.index', $data);
    }

    public function getChucnang($idmodule = NULL)
    {
        $data['list_chucnang'] = UserLibrary::getListChucnang($idmodule);
        return response()->json(['html' => view('cahtcore.permission.module_chucnang_component', $data)->render()]);
    }
}
