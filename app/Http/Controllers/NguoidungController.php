<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;
use Auth;
use Session;
use Cookie;
class NguoidungController extends Controller
{
	public $messages = array(
		'email.required' => 'Email không được để trống',
        'email.unique' => 'Email này đã tồn tại trong hệ thống',
        'username.unique' => 'Tên đăng nhập này đã tồn tại trong hệ thống',
        'username.required' => 'Tên đăng nhập không được để trống',
        'password.required' => 'Mật khẩu không được để trống',
        're_password.required' => 'Xác nhận mật khẩu không được để trống',
        'password.min' => 'Password phải nhiều hơn 6 ký tự',
        'password.max' => 'Password phải ít hơn 20 ký tự',
	);

    public function getLogin()
    {
        if(Auth::check())
        {
            return redirect()->route('nhan-khau.index');
        }
    	return view('users.login');
    }

    public function postLogin(Request $request)
    {
    	Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], $this->messages)->validate();

        $data_user = array(
            'username' => $request->username,
            'password' => $request->password,
            'active' => 1
        );

        if(Auth::attempt( $data_user ))
        {
            $data_user_session = DB::table('tbl_canbo')
            ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
            ->join('tbl_connguoi', 'tbl_canbo.idconnguoi', '=', 'tbl_connguoi.id')
            ->join('tbl_donvi_doi', 'tbl_canbo.id_iddonvi_iddoi', 'tbl_donvi_doi.id')
            ->join('tbl_nhomquyen', 'users.idnhomquyen', 'tbl_nhomquyen.id')
            ->select('users.id as iduser', 'idcanbo', 'idnhomquyen', 'email', 'username', 'idconnguoi', 'idcapbac', 'idchucvu', 'id_iddonvi_iddoi', 'iddonvi', 'tbl_nhomquyen.name as tennhomquyen', 'hoten')
            ->where('username', $data_user['username'])
            ->first();
            Session::put('userinfo', $data_user_session);
            return redirect('/');
        }
        return redirect()->route('login');
        
    }

    public function getRegister()
    {
    	return view('users.register');
    }

    public function postRegister(Request $request)
    {
    	Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
			'password' => 'required|min:6|max:20',
			're_password' => 'required|same:password',

        ], $this->messages)->validate();

        $data_user = array(
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'active' => 1,
            'idnhomquyen' => 2
        );

        DB::table('users')->insert( $data_user );

        return redirect()->route('login');

    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function changePassword( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
			'password' => 'required',
			're_password' => 'required|same:password',

        ], $this->messages);

        $validator->after(function ($validator) use ($request) {
            $data_user = array(
                'id' => Session::get('userinfo')->iduser,
                'password' => $request->old_password,
                'active' => 1
            );
            if( !Auth::attempt( $data_user ) )
            {
                $validator->errors()->add('old_password', 'Mật khẩu cũ không đúng!');
            }
        });

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        DB::table('users')->where('id',Session::get('userinfo')->iduser)->update(array('password' =>  Hash::make($request->password)));
        return response()->json(['success' => 'Thay đổi mật khẩu thành công ']);


    }
}
