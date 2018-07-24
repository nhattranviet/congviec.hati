<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Hash;
use Validator;
use Carbon\Carbon;

class CanboController extends Controller
{
    public $messages = [
        'hoten.required' => 'Họ tên không được để trống',
        'id_iddonvi_iddoi.required' => 'Đội công tác không được để trống',
        'idchucvu.required' => 'Chức vụ không được để trống',
        'idnhomquyen.required' => 'Nhóm quyền không được để trống',
        'email.required' => 'Email không được để trống',
        'email.unique' => 'Email này đã tồn tại trong hệ thống',
        'username.required' => 'Username không được để trống',
        'username.unique' => 'Username này đã tồn tại trong hệ thống',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $arrWhere = array();
        if ($request->hoten) {
            $arrWhere[] = array('hoten', 'LIKE', '%'.$request->hoten.'%');
        }

        if ($request->email) {
            $arrWhere[] = array('email', 'LIKE', '%'.$request->email.'%');
        }

        if ($request->iddonvi && $request->iddonvi != 'all') {
            $arrWhere[] = array('tbl_donvi.id', '=', $request->iddonvi);
        }

        if ($request->iddoicongtac && $request->iddoicongtac != 'all') {
            $arrWhere[] = array('tbl_donvi_doi.id', '=', $request->iddoicongtac);
        }
        // print_r( $arrWhere ); die;
        $data['list_canbo'] = DB::table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->join('tbl_nhomquyen', 'tbl_nhomquyen.id', '=', 'users.idnhomquyen')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->join('tbl_doicongtac', 'tbl_donvi_doi.iddoi', '=', 'tbl_doicongtac.id')
        ->join('tbl_donvi', 'tbl_donvi_doi.iddonvi', '=', 'tbl_donvi.id')
        ->where( $arrWhere )
        ->select('tbl_canbo.id', 'hoten', 'tbl_chucvu.name as tenchucvu', 'email', 'tbl_donvi.name as tendonvi', 'tbl_doicongtac.name as tendoi', 'tbl_nhomquyen.name as tennhomquyen', 'users.active')
        ->orderBy('tbl_canbo.id', 'desc')
        ->paginate(10);

        if( $request->ajax() )
        {
            return response()->json(['html' => view('cahtcore.canbo.canbo_table', $data)->render()]);
        }

        $data['list_donvi'] = DB::table('tbl_donvi')->orderBy('id', 'ASC')->get();
        return view('cahtcore.canbo.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Thêm cán bộ và tài khoản';
        $data['list_donvi'] = DB::table('tbl_donvi')->get();
        $data['list_capbac'] = DB::table('tbl_capbac')->get();
        $data['list_chucvu'] = DB::table('tbl_chucvu')->get();
        $data['list_nhomquyen'] = DB::table('tbl_nhomquyen')->get();
        return view('cahtcore.canbo.create', $data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hoten' => 'required',
            'id_iddonvi_iddoi' => 'required',
            'idchucvu' => 'required',
            'idnhomquyen' => 'required',
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $idconnguoi = DB::table('tbl_connguoi')->insertGetId(
            [
                'hoten' => $request->hoten,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        $idcanbo = DB::table('tbl_canbo')->insertGetId(
            [
                'idconnguoi' => $idconnguoi,
                'idcapbac' => $request->idcapbac,
                'idchucvu' => $request->idchucvu,
                'id_iddonvi_iddoi' => $request->id_iddonvi_iddoi,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        if($request->quanlydoi != NULL)
        {
            $data_lanhdao_doi = array();
            foreach ($request->quanlydoi as $doi)
            {
                $data_lanhdao_doi[] = array(
                    'idcanbo' => $idcanbo,
                    'id_iddonvi_iddoi' => $doi,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );
            }
            DB::table('tbl_lanhdaodonvi_quanlydoi')->insert( $data_lanhdao_doi );
        }

        $username = $this->vn_str_filter($request->hoten);
        $check = DB::table('users')->where('username', $username)->count();
        $username = ( $check == 0 ) ? $username : $username.'_'.$idcanbo ;

        $iduser = DB::table('users')->insertGetId(
            [
                'idcanbo' => $idcanbo,
                'username' => $username,
                'email' => $username.'@hati.bca',
                'password' => Hash::make('123456'),
                'idnhomquyen' => $request->idnhomquyen,
                'active' => ($request->active) ? 1 : 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        return response()->json(['success' => 'Thêm cán bộ thành công ', 'url' => route('can-bo.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idcanbo)
    {
        $data['page_title'] = "Sửa thông tin cán bộ";
        $data['canbo_info'] = DB::table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->select('username', 'tbl_canbo.id as idcanbo', 'hoten', 'idcapbac', 'idchucvu', 'email', 'id_iddonvi_iddoi', 'idnhomquyen', 'iddonvi', 'iddoi', 'tbl_donvi_doi.id as id_iddonvi_iddoi', 'active', 'users.id as userid', 'tbl_connguoi.id as idconnguoi') 
        ->where('tbl_canbo.id', $idcanbo)->first();

        $data['list_donvi'] = DB::table('tbl_donvi')->get();
        $data['list_capbac'] = DB::table('tbl_capbac')->get();
        $data['list_chucvu'] = DB::table('tbl_chucvu')->get();
        $data['list_nhomquyen'] = DB::table('tbl_nhomquyen')->get();

        $data['list_doicongtac'] = DB::table('tbl_doicongtac')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.iddoi', '=', 'tbl_doicongtac.id')
        ->select('name', 'tbl_donvi_doi.id')
        ->where('iddonvi', $data['canbo_info']->iddonvi)
        ->select('tbl_donvi_doi.id', 'tbl_doicongtac.name')
        ->get();

        $data['list_doiquanly'] = DB::table('tbl_lanhdaodonvi_quanlydoi')->where('idcanbo', $idcanbo)->pluck('id_iddonvi_iddoi')->toArray();
        // print_r( $data['list_doiquanly'] ); die;
        return view( 'cahtcore.canbo.edit', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hoten' => 'required',
            'id_iddonvi_iddoi' => 'required',
            'idchucvu' => 'required',
            'idnhomquyen' => 'required',
            'email' => 'required|unique:coredb.users,email,' . $request->userid,
            'username' => 'required|unique:coredb.users,username,'.$request->userid,
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        
        $idconnguoi = DB::table('tbl_connguoi')->where('id', $request->idconnguoi)->update(
            [
                'hoten' => $request->hoten,
                'updated_at' => Carbon::now()
            ]
        );

        $idcanbo = DB::table('tbl_canbo')->where('id', $id)->update(
            [
                'idcapbac' => $request->idcapbac,
                'idchucvu' => $request->idchucvu,
                'id_iddonvi_iddoi' => $request->id_iddonvi_iddoi,
                'updated_at' => Carbon::now()
            ]
        );

        $iduser = DB::table('users')->where('id', $request->userid)->update(
            [
                'email' => $request->email,
                'username' => $request->username,
                'idnhomquyen' => $request->idnhomquyen,
                'active' => ($request->active) ? 1 : 0,
                'updated_at' => Carbon::now()
            ]
        );

        $listdoi_post = ($request->quanlydoi) ? $request->quanlydoi : array();
        $listdoi_db = DB::table('tbl_lanhdaodonvi_quanlydoi')->where('idcanbo', $id)->pluck('id_iddonvi_iddoi')->toArray();
        
        $list_doi_add = array_diff($listdoi_post, $listdoi_db);
        $list_doi_xoa = array_diff($listdoi_db, $listdoi_post);

        
        if( ! empty($list_doi_add ) )
        {
            $data_lanhdao_doi = array();
            foreach ($list_doi_add as $doi)
            {
                $data_lanhdao_doi[] = array(
                    'idcanbo' => $id,
                    'id_iddonvi_iddoi' => $doi,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );
            }
            DB::table('tbl_lanhdaodonvi_quanlydoi')->insert( $data_lanhdao_doi );

        }

        if( ! empty( $list_doi_xoa ) )
        {
            foreach ($list_doi_xoa as $doi)
            {
                DB::table('tbl_lanhdaodonvi_quanlydoi')
                ->where(array(
                    ['idcanbo', '=', $id],
                    ['id_iddonvi_iddoi', '=', $doi]
                ))
                ->delete();
            }
        }

        return response()->json(['success' => 'Cập nhật cán bộ thành công ', 'url' => route('can-bo.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCanbo($id_iddonvi_iddoi = NULL)
    {
        $data['list_canbo'] = DB::table('tbl_canbo')
                ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
                ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
                ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
                ->where('id_iddonvi_iddoi', $id_iddonvi_iddoi)
                ->select('tbl_canbo.id', 'hoten', 'tbl_chucvu.name as tenchucvu')
                ->get()->toArray();
        return response()->json(['html' => view('cahtcore.canbo.option_select_canbo', $data)->render()]);

    }

    public function add_old_data()
    {
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
                    'idnhomquyen' => 3,
                    'active' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );
        }
    }

    public function vn_str_filter ($str = 'Đây là dòng để test'){
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '' => ' '
        );
        
       foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
       }
        return strtolower($str);
    }

}
