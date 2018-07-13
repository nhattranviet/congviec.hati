<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;
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
    ];

    public function index(Request $request)
    {

        $data['list_canbo'] = DB::connection('coredb')->table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_chucvu', 'tbl_chucvu.id', '=', 'tbl_canbo.idchucvu')
        ->join('tbl_nhomquyen', 'tbl_nhomquyen.id', '=', 'users.idnhomquyen')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->join('tbl_doicongtac', 'tbl_donvi_doi.iddoi', '=', 'tbl_doicongtac.id')
        ->join('tbl_donvi', 'tbl_donvi_doi.iddonvi', '=', 'tbl_donvi.id')
        ->select('tbl_canbo.id', 'hoten', 'tbl_chucvu.name as tenchucvu', 'email', 'tbl_donvi.name as tendonvi', 'tbl_doicongtac.name as tendoi', 'tbl_nhomquyen.name as tennhomquyen', 'users.active')
        ->orderBy('tbl_canbo.id', 'desc')
        ->paginate(2);

        if( $request->ajax() )
        {
            return response()->json(['html' => view('cahtcore.canbo.canbo_table', $data)->render()]);
        }

        $data['list_donvi'] = DB::connection('coredb')->table('tbl_donvi')->orderBy('id', 'ASC')->get();
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
        $data['list_donvi'] = DB::connection('coredb')->table('tbl_donvi')->get();
        $data['list_capbac'] = DB::connection('coredb')->table('tbl_capbac')->get();
        $data['list_chucvu'] = DB::connection('coredb')->table('tbl_chucvu')->get();
        $data['list_nhomquyen'] = DB::connection('coredb')->table('tbl_nhomquyen')->get();
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

        $idconnguoi = DB::connection('coredb')->table('tbl_connguoi')->insertGetId(
            [
                'hoten' => $request->hoten,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        $idcanbo = DB::connection('coredb')->table('tbl_canbo')->insertGetId(
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
            DB::connection('coredb')->table('tbl_lanhdaodonvi_quanlydoi')->insert( $data_lanhdao_doi );
        }

        $username = $this->vn_str_filter($request->hoten);
        $check = DB::connection('coredb')->table('users')->where('username', $username)->count();
        $username = ( $check == 0 ) ? $username : $username.'_'.$idcanbo ;

        $iduser = DB::connection('coredb')->table('users')->insertGetId(
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
    public function edit($id)
    {
        $canbo_info = DB::connection('coredb')->table('tbl_canbo')
        ->join('tbl_connguoi', 'tbl_connguoi.id', '=', 'tbl_canbo.idconnguoi')
        ->join('users', 'users.idcanbo', '=', 'tbl_canbo.id')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.id', '=', 'tbl_canbo.id_iddonvi_iddoi')
        ->select('tbl_canbo.id', 'hoten', 'idcapbac', 'idchucvu', 'email', 'id_iddonvi_iddoi', 'idnhomquyen', 'iddonvi', 'iddoi', 'tbl_donvi_doi.id as id_iddonvi_iddoi', 'active', 'users.id as userid', 'tbl_connguoi.id as idconnguoi') 
        ->where('tbl_canbo.id', $id)->first();

        $list_donvi = DB::connection('coredb')->table('tbl_donvi')->get();
        $list_capbac = DB::connection('coredb')->table('tbl_capbac')->get();
        $list_chucvu = DB::connection('coredb')->table('tbl_chucvu')->get();
        $list_nhomquyen = DB::connection('coredb')->table('tbl_nhomquyen')->get();

        $list_doi = DB::connection('coredb')->table('tbl_doicongtac')
        ->join('tbl_donvi_doi', 'tbl_donvi_doi.iddoi', '=', 'tbl_doicongtac.id')
        ->select('name', 'tbl_donvi_doi.id')
        ->where('iddonvi', $canbo_info->iddonvi)->get();
        // print_r($canbo_info); die;
        return view( 'cahtcore.canbo.edit', compact( 'canbo_info', 'list_donvi', 'list_capbac', 'list_chucvu', 'list_nhomquyen', 'list_doi' ) );
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
        $validator = Validator::make($request->all(),
            [
                'hoten' => 'required',
                'id_iddonvi_iddoi' => 'required',
                'email' => 'unique:users,email,'.$request->userid,
                'idchucvu' => 'required',
                'idnhomquyen' => 'required',
            ],
            [
                'hoten.required' => 'Họ tên không được trống',
                'email.required' => 'Email không được trống',
                'email.email' => 'Email không đúng định dạng',
                'id_iddonvi_iddoi.required' => 'Đội công tác không được trống',
                'idchucvu.required' => 'Chức vụ không được trống',
                'idnhomquyen.required' => 'Nhóm quyền không được trống',
            ]
        )->validate();

        $idconnguoi = DB::connection('coredb')->table('tbl_connguoi')->where('id', $request->idconnguoi)->update(
            [
                'hoten' => $request->hoten,
                'updated_at' => Carbon::now()
            ]
        );

        $idcanbo = DB::connection('coredb')->table('tbl_canbo')->where('id', $id)->update(
            [
                'idcapbac' => $request->idcapbac,
                'idchucvu' => $request->idchucvu,
                'id_iddonvi_iddoi' => $request->id_iddonvi_iddoi,
                'updated_at' => Carbon::now()
            ]
        );

        $iduser = DB::connection('coredb')->table('users')->where('id', $request->userid)->update(
            [
                'email' => $request->email,
                'idnhomquyen' => $request->idnhomquyen,
                'active' => ($request->active) ? 1 : 0,
                'updated_at' => Carbon::now()
            ]
        );

        return redirect()->route('can-bo.index');
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
