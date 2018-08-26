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
use App\QuocGia;
use App\Relation;
use App\Religion;
use App\Nation;
use App\Education;
use App\Province;
use App\District;
use App\Ward;
use App\Career;
use Auth;
use Session;
use App\UserApp\UserLibrary;
use App\UserApp\CanboLibrary;
use App\UserApp\DonviLibrary;

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
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $arrWhere = CanboLibrary::processArrWhere($request);
        $arrWhere[] = array('iddonvi', '=', Session::get('userinfo')->iddonvi);
        $data['list_canbo'] = CanboLibrary::getListCanbo($arrWhere);
        if( $request->ajax() )
        {
            return response()->json(['html' => view('cahtcore.canbo.canbo_table', $data)->render()]);
        }
        $data['list_donvi'] = CanboLibrary::getListDonvi(array(['id', '=', Session::get('userinfo')->iddonvi]));
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
        $data['list_donvi'] = CanboLibrary::getListDonvi();
        $data['list_capbac'] = CanboLibrary::getListCapbac();
        $data['list_chucvu'] = CanboLibrary::getListChucvu();
        $data['list_nhomquyen'] = CanboLibrary::getListNhomquyen();
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

        $username = UserLibrary::vn_str_filter($request->hoten);
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
        $data['canbo_info'] = CanboLibrary::getCanboInfo($idcanbo);
        $data['list_donvi'] = CanboLibrary::getListDonvi();
        $data['list_capbac'] = CanboLibrary::getListCapbac();
        $data['list_chucvu'] = CanboLibrary::getListChucvu();
        $data['list_nhomquyen'] = CanboLibrary::getListNhomquyen();
        $data['list_doicongtac'] = UserLibrary::getListDoidonVi($data['canbo_info']->iddonvi);
        $data['list_doiquanly'] = UserLibrary::getListDoiLanhdaoQuanly($idcanbo);
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
            'email' => 'required|unique:users,email,' . $request->userid,
            'username' => 'required|unique:users,username,'.$request->userid,
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
    public function destroy($idcanbo)
    {
        //
    }

    public function showinfo($idcanbo = NULL)
    {
        $idcanbo = ($idcanbo == NULL) ? Session::get('userinfo')->idcanbo : $idcanbo;
        $data['userinfo'] = CanboLibrary::getCanboFullInfo($idcanbo);
        $data['list_capbac'] = CanboLibrary::getListCapbac(); //dd($data['list_capbac']);
        $data['list_chucvu'] = CanboLibrary::getListChucvu();
        $data['list_hocvan'] = CanboLibrary::getListHocvan();
        $data['page_title'] = "Thông tin cán bộ";
        return view( 'cahtcore.canbo.showInfo', $data );
    }

    public function selfUpdate(Request $request, $idcanbo)
    {
        $validator = Validator::make($request->all(), [
            'hoten' => 'required',
            'idcapbac' => 'required',
        ], $this->messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all(), 'message_type' => 'alert']);
        }

        $idconnguoi = CanboLibrary::getIdConnguoi( $idcanbo );

        DB::table('tbl_connguoi')->where('id', $idconnguoi)->update(['hoten' => $request->hoten]);
        DB::table('tbl_canbo')->where('id', $idcanbo)->update(['idcapbac' => $request->idcapbac, 'idchucvu' => $request->idchucvu]);
        return response()->json(['success' => 'Cập nhật cán bộ thành công ', 'message_type' => 'alert']);
    }

    public function editHoso($idcanbo = NULL)
    {
        $idcanbo = ($idcanbo == NULL) ? Session::get('userinfo')->idcanbo : $idcanbo;
        $data['userinfo'] = CanboLibrary::getCanboFullInfo($idcanbo);
        $data['page_title'] = "Thông tin cán bộ";

        $data['countries'] = CanboLibrary::getListQuocgia();
        $data['relations'] = CanboLibrary::getListQuanhe();
        $data['religions'] = CanboLibrary::getListTongiao();
        $data['nations'] = CanboLibrary::getListDantoc();
        $data['educations'] = CanboLibrary::getListHocvan();
        $data['careers'] = CanboLibrary::getListNghenghiep();
        $data['list_quanhechuho'] = DB::table('tbl_moiquanhe')->where('loaiquanhe', 'nhanthan')->get();
        return view( 'cahtcore.canbo.editHoso', $data );
        // print_r($userinfo);
    }

    public function getCanbo($id_iddonvi_iddoi = NULL)
    {
        $data['list_canbo'] = CanboLibrary::getListCanboOfDoi( $id_iddonvi_iddoi );
        return response()->json(['html' => view('cahtcore.canbo.option_select_canbo', $data)->render()]);

    }

    public function exportListCanBo($iddonvi)
    {
        $arrWhere = array();
        $arrWhere[] = array('iddonvi', '=', $iddonvi);
        $list_canbo = CanboLibrary::getAllListCanbo($arrWhere);
        $str_canbo = "<table width='100%' style='border-collapse: collapse;' border='1' cellspacing='0' cellpadding='0'  >
        <tr align='center'>
            <td>STT</td>
            <td>Họ tên</td>
            <td>Đội</td>
            <td>Username</td>
            <td>Mật khẩu</td>
        </tr>";
        $i = 1;
        foreach ($list_canbo as $canbo)
        {
            $str_canbo .= "<tr>
            <td align='center'>".$i."</td>
            <td>".$canbo->hoten."</td>
            <td>".$canbo->tendoi."</td>
            <td>".$canbo->username."</td>
            <td>123456</td>
        </tr>";
        $i++;
        }
        $str_canbo .= "</table>";

        $str = "
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
        <head><title>Microsoft Office HTML Example</title>
        <style> <!-- 
            @page
            {
                size: 21cm 29.7cm;  /* A4 */
                margin: 1.5cm 1.1cm 1.5cm 2.5cm; /* Margins: 2 cm on each side */
                mso-page-orientation: portrait;
            }
        @page Section1 { }
        div.Section1 { page:Section1; }
        --></style>
        </head>
        <body>
        <div class=Section1>
        ".$str_canbo."
        </div>
        </body>
        </html>";
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=mau-hk-01.doc");
        echo $str;
    }

    public function add_old_data()
    {
        $data = [
            //PC44--------------------
            "Trần Hải Trung,10,4,11",
            "Nguyễn Thị Kim Chung,9,3,11",
            "Nguyễn Hữu Chí,8,3,11",
            "Phan Thị Huyền Trang,7,2,12",
            "Ngô Đức Thìn,6,13,12",
            "Nguyễn Thị Hải Yến,4,13,12",
            "Nguyễn Quốc Tiến,5,13,12",
            "Lê Thái Hà,9,2,13",
            "Nguyễn Xuân Thanh,6,1,13",
            "Phan Mạnh,6,1,13",
            "Nguyễn Văn Khánh,7,13,13",
            "Thái Văn Trung,5,13,13",
            "Trần Văn Huân,7,13,13",
            "Hà Huy Phong,4,13,13",
            "Đậu Duy Hưng,8,2,14",
            "Lê Ngọc Hưng,6,1,14",
            "Nguyễn Văn Nam,6,13,14",
            "Nguyễn Văn Vũ,5,13,14",
            "Lê Thanh Bình,6,13,14",
            "Đặng Văn Kỷ,5,13,14",
            "Lưu Thị Hoài Phương,6,13,14",
            "Bùi Thị Trâm,4,13,14",
            "Nguyễn Bảo Trung,4,13,14",
            "Trần Danh Thiết,7,13,14",
            //TP---------------------
            "Nguyễn Quốc Hùng,7,4,15",
            "Nguyễn Công Dũng,10,3,15",
            "Lê Khánh Hòa,9,3,15",
            "Bùi Thanh Tùng,8,3,15",
            "Nguyễn Đông Hưng,7,3,15",
            "Đoàn Thế Cường,7,2,16",
            "Hoàng Bích Thủy,8,1,16",
            "Phạm Thị Ý Nhi,5,13,16",
            "Đào Hữu Quyết,5,13,16",
            "Nguyễn Tuấn Đức,5,13,16",
            "Trần Thị Huyền,5,13,16",
            "Lê Thị Hoài Lan,4,13,16",
            "Lê Thị Dung,4,13,16",
            "Nguyễn Văn Cường,4,13,16",
            "Trương Thị Diệu Thủy,5,13,16",
            "Trần Ngọc Lam,3,13,16",
            "Hồ Phạm Tú,4,13,16",
            "Trần Hữu Hoàng,3,13,16",
            "Trần Văn Đại,4,13,16",
            "Đặng Thị Thanh Hoa,16,13,16",
            "Nguyễn Thị Chân,16,13,16",
            "Hồ Thị Vân,16,13,16",
            "Lê Hải Thắng,9,2,17",
            "Võ Thị Hồng Nhung,5,13,17",
            "Nguyễn Việt Đức,5,13,17",
            "Trần Thị Khánh Hòa,5,13,17",
            "Trần Huyền Ly,3,13,17",
            "Nguyễn Phi Hoàng,6,13,17",
            "Phan Ngọc Triều,4,13,17",
            "Nguyễn Thị Cẩm Trang,5,13,17",
            "Trần Bảo Trung,4,13,17",
            "Nguyễn Thị Phương Trinh,4,13,17",
            "Phan Kiều Trinh,4,13,17",
            "Võ Thị Như Quỳnh,4,13,17",
            "Phạm Thành Luân,4,13,17",
            "Trịnh Lê Danh,3,13,17",
            "Lê Phú Hưng,4,13,17",
            "Nguyễn Quang Vũ,4,13,17",
            "Hồ Văn Phương,9,13,18",
            "Lê Thị Lan Hương,9,13,18",
            "Nguyễn Đức Anh,5,13,18",
            "Lê Thị Xoan,5,13,18",
            "Nguyễn Thị Như Quỳnh,4,13,18",
            "Nguyễn Thị Long Bình,8,13,18",
            "Trần Thị Huyền,7,13,18",
            "Nguyễn Thị Vân,7,13,18",
            "Trần Thùy Dung,6,13,18",
            "Võ Thị Huyền Diệu,6,13,18",
            "Nguyễn Tiến Sơn,7,13,18",
            "Thái Cao Cường,5,13,18",
            "Lê Thị Huyền,5,13,18",
            "Phạm Duy Tuấn,4,13,18",
            "Nguyễn Thị Mỹ Phượng,5,13,18",
            "Lê Thùy Trang,4,13,18",
            "Diệp Xuân Nam,7,2,19",
            "Nguyễn Quốc Hưng,6,1,19",
            "Nguyễn Văn Lệ,6,1,19",
            "Đậu Thị Thúy Hà,5,13,19",
            "Nguyễn Thị Hảo,5,13,19",
            "Trần Văn Thắng,7,13,19",
            "Võ Văn Công,5,13,19",
            "Lê Duy Tùng,5,13,19",
            "Trần Đình Hoan,5,13,19",
            "Trần Hữu Khánh,5,13,19",
            "Trần Ngọc Hoàng,6,13,19",
            "Hoàng Bảo Trung,5,13,19",
            "Lê Thị Mỹ Hạnh,5,13,19",
            "Dương Thị Hoài,4,13,19",
            "Lê Đăng Đỉnh,9,2,20",
            "Bùi Quang Dũng,8,1,20",
            "Nguyễn Công Hiếu,6,1,20",
            "Nguyễn Văn Khánh,6,13,20",
            "Hoàng Quốc Anh,4,13,20",
            "Dương Quốc Khánh,5,13,20",
            "Ngô Đức Long,5,13,20",
            "Lê Văn Dũng,8,13,20",
            "Lê Đình Tiến,5,13,20",
            "Đinh Sỹ Đạt,5,13,20",
            "Dương Đức Quang Huy,5,13,20",
            "Hoàng Tuấn Anh,5,13,20",
            "Nghiêm Mạnh Hùng,5,13,20",
            "Trương Quang Tuấn Vũ,5,13,20",
            "Võ Thế Định,4,13,20",
            "Nguyễn Thị Diễm Ly,3,13,20",
            "Phan Anh Tuấn,6,13,20",
            "Phan Tuấn Anh,5,13,20",
            "Hoàng Hùng Cường,5,13,20",
            "Võ Văn Thành,5,13,20",
            "Lương Hữu Nam,5,13,20",
            "Nguyễn Hữu Thọ,5,13,20",
            "Đặng Quỳnh Nga,4,13,20",
            "Trần Viết Phúc,4,13,20",
            "Lê Xuân Sang,9,2,21",
            "Nguyễn Anh Sơn,8,1,21",
            "Nguyễn Thái Hùng,9,1,21",
            "Trần Thanh Trung,5,13,21",
            "Nguyễn Anh Phan,5,13,21",
            "Phạm Văn Thắng,5,13,21",
            "Phan Thị Phương Thúy,5,13,21",
            "Dương Thị Bích Thảo,6,13,21",
            "Hồ Thị Lệ Thư,5,13,21",
            "Lê Bá Ký,8,13,21",
            "Nguyễn Xuân Phương,5,13,21",
            "Nguyễn Thùy Dương,5,13,21",
            "Trần Phan Nhật,4,13,21",
            "Lê Thị Hải,3,13,21",
            "Nguyễn Thị Huyền Trang,7,1,22",
            "Phan Thị Huyền,5,13,22",
            "Trần Đình Hùng,7,13,22",
            "Lưu Trung Sơn,7,13,22",
            "Trương Hải Quân,5,13,22",
            "Trịnh Thanh Hải,5,13,22",
            "Nguyễn Thành Trung,4,13,22",
            "Nguyễn Thị Lệ Huyền,4,13,22",
            "Nguyễn Trung An,4,13,22",
            "Chu Anh Đức,4,13,22",
            "Nguyễn Văn Danh,7,2,23",
            "Trần Ngọc Thiết,6,13,23",
            "Đậu Thị Thu,5,13,23",
            "Dương Cao Phong,6,13,23",
            "Nguyễn Văn Mỹ,7,13,23",
            "Đinh Quang Tuyến,5,13,23",
            "Phùng Duy Khánh,6,13,23",
            "Nguyễn Quốc Vũ,4,13,23",
            "Trương Tiến Lực,3,13,23",
            "Nguyễn Mai Quyết,4,13,23",
            "Nguyễn Thị Thanh,4,13,23",
            "Thân Viết Sinh,6,1,24",
            "Phạm Duy Thành,8,1,24",
            "Nguyễn Minh Tâm,6,13,24",
            "Nguyễn Gia Thịnh,5,13,24",
            "Võ Thị Huyền Trang,5,13,24",
            "Trần Xuân Hà,6,13,24",
            "Phan Viết Hùng,7,13,24",
            "Bùi Xuân Hoàng,6,13,24",
            "Võ Tá Đức,6,13,24",
            "Trần Tô Hoài,7,13,24",
            "Nguyễn Quốc Việt,7,13,24",
            "Nguyễn Xuân Sơn,7,13,24",
            "Đoàn Anh Dũng,7,13,24",
            "Nguyễn Văn Thành,7,13,24",
            "Nguyễn Tuấn Anh,7,13,24",
            "Đặng Trọng Hiếu,6,13,24",
            "Hồ Việt Nam,7,13,24",
            "Hà Huy Minh,9,13,24",
            "Đường Thị Minh Hường,8,13,24",
            "Chu Đức Minh,7,13,24",
            "Nguyễn Xuân Hùng,6,13,24",
            "Nguyễn Văn Tài,5,13,24",
            "Trần Nguyên Tiến Mạnh,5,13,24",
            "Phan Tuấn Thành,6,13,24",
            "Hoàng Văn Minh,7,13,24",
            "Nguyễn Văn Thuần,7,13,24",
            "Nguyễn Xuân Nhật,5,13,24",
            "Dương Đình Kiên,5,13,24",
            "Trần Hữu Đông,7,13,24",
            "Đặng Duy Nhật Khánh,6,13,24",
            "Phan Hồng Trang,3,13,24",
            "Cao Đăng Chiến,5,13,24",
            "Nguyễn Y Phụng,5,13,24",
            "Phạm Đăng Thành,4,13,24",
            "Lê Ngọc Báu,9,2,25",
            "Võ Tá Tạo,8,1,25",
            "Trần Giang Nam,6,1,25",
            "Trương Quang Thuận,6,13,25",
            "Phạm Công Nguyên,7,13,25",
            "Trần Thị Phương Thanh,5,13,25",
            "Phan Hoài Nam,5,13,25",
            "Đậu Thanh Tân,7,13,25",
            "Thái Minh Tuấn,5,13,25",
            "Nguyễn Minh Quyền,5,13,25",
            "Lê Hồng Phong,5,13,25",
            "Lưu Quỳnh Trang,3,13,25",
            "Biện Thanh Sơn,3,13,25",
            "Trần Sỹ Huân,7,13,25",
            "Tống Nguyên Phương,7,13,25",
            "Trần Đức Hoài,6,13,25",
            "Nguyễn Quốc Hưng,6,13,25",
            "Mai Văn Nam,4,13,25",
            "Nguyễn Nam Hùng,9,2,26",
            "Lê Đăng Tiến,7,1,26",
            "Nguyễn Thị Cẩm Tú,5,13,26",
            "Trần Tiến Dũng,6,13,26",
            "Trần Công Huy,6,13,26",
            "Nguyễn Tuấn Tú,5,13,26",
            "Nguyễn Xuân Sử,6,13,26",
            //PV11------------------
            "Phan Ngọc Tố,9,3,1",
            "Phan Quốc Khánh,9,3,1",
            "Trần Viết Hải,8,3,1",
            "Phạm Thanh Hải,8,2,2",
            "Trần Thanh Liêm,7,1,2",
            "Nguyễn Đăng Dần,6,13,2",
            "Đoàn Thanh Huyền,5,13,2",
            "Nguyễn Thị Thu Trang,4,13,2",
            "Dương Phúc Thi,7,2,5",
            "Trần Trọng Minh Nhụy,7,1,5",
            "Võ Thế Cường,6,13,5",
            "Nguyễn Văn Hoan,6,13,5",
            "Hà Thị Thúy,6,13,5",
            "Hoàng Thị Kim Liên,5,13,5",
            "Nguyễn Anh Sơn,9,2,6",
            "Trần Văn Thành,6,1,6",
            "Lê Thanh Hoàng,6,13,6",
            "Mai Thị Hồng Nhung,6,13,6",
            "Phan Bá Nam,5,13,6",
            "Đồng Xuân Quốc,5,13,6",
            "Nguyễn Thị Kim Ngân,4,13,6",
            "Võ Thị Thanh Trà,8,2,3",
            "Đinh Thị Quyên,8,1,3",
            "Nguyễn Thanh Hải,7,13,3",
            "Nguyễn Thị Hương,8,13,3",
            "Trần Thị Lan,6,13,3",
            "Trần Thị Thùy Linh,4,13,3",
            "Nguyễn Kim Hưng,8,2,10",
            "Nguyễn Xuân Nghĩa,6,1,10",
            "Nguyễn Minh Mạnh,4,13,10",
            "Đinh Thanh Tuấn,5,13,10",
            "Phan Quốc Tuấn,5,13,10",
            "Nguyễn Thành Nam,9,2,9",
            "Nguyễn Thị Hương Lam,7,13,9",
            "Trịnh Thị Mỹ Trang,7,13,9",
            "Đoàn Văn Đề,6,13,9",
            "Trần Vũ Hà,5,13,9",
            "Phan Thanh Văn,5,13,9",
            "Lê Thị Ny La,4,13,9",
            "Phạm Thị Hoa,7,13,9",
            "Nguyễn Văn Tính,8,2,7",
            "Hoàng Thị Ngọc Hà,6,1,7",
            "Lê Thị Hồng Loan,8,13,7",
            "Mai Huyền Trang,5,13,7",
            "Phan Quốc Trung,5,13,7",
            "Hoàng Đức Dũng,8,2,8",
            "Hồ Thị Ánh Nguyệt,7,13,8",
            "Trần Hà Thanh,8,2,4",
            "Trần Viết Nhật,5,1,4",
            "Dương Quyết Thắng,6,13,4",
            "Trần Quang Đức,6,13,4",
            "Phan Duy Cường,4,13,4",
            "Nguyễn Huy Trung,5,13,4",
            "Nguyễn Hữu Mạnh,5,13,4",
        ];

        $arr_chucvu_nhomquyen = ['1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 4,'6' => 5, '7' => 4, '8' => 5, '9' => 4, '10' => 5, '11' => 4, '12' => 5, '13' => 1, '14' => 6];
        //Họ ten, cap bac, chuc vu, id_iddonvi_iddoi
        $date = date('Y-m-d', time());
        foreach ($data as $value)
        {
            $a = explode( ',', $value );
            $in_arr_idchucvu = $a[2];
            $idconnguoi = DB::table('tbl_connguoi')->insertGetId(
                [
                    'hoten' => $a[0],
                    'created_at' => $date,
                    'updated_at' => $date
                ]
            );

            $idcanbo = DB::table('tbl_canbo')->insertGetId(
                [
                    'idconnguoi' => $idconnguoi,
                    'idcapbac' => $a[1],
                    'idchucvu' => $in_arr_idchucvu,
                    'id_iddonvi_iddoi' => $a[3],
                    'created_at' => $date,
                    'updated_at' => $date
                ]
            );

            $username = UserLibrary::vn_str_filter($a[0]);
            $check = DB::table('users')->where('username', $username)->count();
            $username = ( $check == 0 ) ? $username : $username.'_'.$idcanbo ;

            $iduser = DB::table('users')->insertGetId(
                [
                    'idcanbo' => $idcanbo,
                    'username' => $username,
                    'email' => $username.'@hati.bca',
                    'password' => Hash::make('123456'),
                    'idnhomquyen' => $arr_chucvu_nhomquyen[$in_arr_idchucvu],
                    'active' => 1,
                    'created_at' => $date,
                    'updated_at' => $date
                ]
            );
        }
    }

    

}
