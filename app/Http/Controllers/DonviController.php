<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DonviController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if($request->keyword)
        {
            $data['list_donvi'] = DB::table('tbl_donvi')
            ->where('name', 'LIKE', '%'.$request->keyword.'%')
            ->orWhere('kyhieu', 'LIKE', '%'.$request->keyword.'%')
            ->orderBy('id', 'ASC')
            ->paginate(12);
        }
        else
        {
            $data['list_donvi'] = DB::table('tbl_donvi')->orderBy('id', 'ASC')->paginate(12);
        }

        if( $request->ajax() )
        {
            return response()->json(['html' => view('cahtcore.donvi.donvi_table', $data)->render()]);
        }

        return view('cahtcore.donvi.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cahtcore.donvi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|unique:tbl_donvi',
                'kyhieu' => 'nullable|unique:tbl_donvi',
                'loaidonvi' => 'required',
            ],
            [
                'name.required' => 'Tên đơn vị không được trống',
                'name.unique' => 'Tên đơn vị đã tồn tại',
                'kyhieu.unique' => 'Ký hiệu đơn vị đã tồn tại',
                'loaidonvi.required' => 'Loại đơn vị không được trống',
            ]
        );
        $id = DB::table('tbl_donvi')->insertGetId(
            [
                'name' => $request->name,
                'kyhieu' => $request->kyhieu,
                'loaidonvi' => $request->loaidonvi,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        if($id)
        {
            $notification = array(
                'message' => 'Thêm thành công!', 
                'alert-type' => 'success'
            );
        }
        else{
            $notification = array(
                'message' => 'Thêm không thành công!', 
                'alert-type' => 'error'
            );
        }
        return redirect()->route('don-vi.index')->with($notification);
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
        $data['donvi'] = DB::table('tbl_donvi')->where('id', $id)->first();
        return view('cahtcore.donvi.edit', compact('donvi'));
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
        $this->validate($request,
            [
                'name' => 'required',
                'loaidonvi' => 'required',
            ],
            [
                'name.required' => 'Tên đơn vị không được trống',
                'loaidonvi.required' => 'Loại đơn vị không được trống',
            ]
        );
        $id = DB::table('tbl_donvi')->where('id', $id)->update(
            [
                'name' => $request->name,
                'kyhieu' => $request->kyhieu,
                'loaidonvi' => $request->loaidonvi,
                'updated_at' => Carbon::now()
            ]
        );
        if($id)
        {
            $notification = array(
                'message' => 'Cập nhật thành công!', 
                'alert-type' => 'success'
            );
        }
        else{
            $notification = array(
                'message' => 'Cập nhật không thành công!', 
                'alert-type' => 'error'
            );
        }
        return redirect()->route('don-vi.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = DB::table('tbl_donvi')->where('id', $id)->delete();
        if($check)
        {
            $notification = array(
                'message' => 'Xóa thành công!', 
                'alert-type' => 'success'
            );
        }
        else{
            $notification = array(
                'message' => 'Xóa không thành công!', 
                'alert-type' => 'error'
            );
        }
        return redirect()->route('don-vi.index')->with($notification);
    }

    public function setdoi( $iddonvi )
    {
        $data['donvi'] = DB::table('tbl_donvi')->where('id', $iddonvi)->first();
        $data['page_name'] = 'Thiết lập đội cho đơn vị';
        $data['list_doi'] = DB::table('tbl_doicongtac')->get()->toArray();
        $data['list_doi_currents'] = DB::table('tbl_donvi_doi')->where('iddonvi', $iddonvi)->pluck('iddoi')->toArray();
        // print_r( $data['donvi'] ); die;
        return view('cahtcore.donvi.set_doi', $data);
    }

    public function store_set_doi(Request $request, $iddonvi)
    {
        $this->validate($request,
            [
                'list_doi_donvi' => 'required',
            ],
            [
                'list_doi_donvi.required' => 'Danh sách đội chọn không được trống',
            ]
        );
        
        $listdoi_post = $request->list_doi_donvi;
        $listdoi_db = DB::table('tbl_donvi_doi')->where('iddonvi', $iddonvi)->pluck('iddoi')->toArray();

        $list_doi_add = array_diff($listdoi_post, $listdoi_db);
        $list_doi_xoa = array_diff($listdoi_db, $listdoi_post);

        if( ! empty($list_doi_add ) )
        {
            $data_add = array();
            foreach ($list_doi_add as $doi)
            {
                $data_add[] = array(
                    'iddonvi' => $iddonvi,
                    'iddoi' => $doi,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );
            }

            $id_insert = DB::table('tbl_donvi_doi')->insert($data_add);
            $str = ($id_insert) ? 'Thêm đội thành công' : 'Thêm đội không thành công';
        }

        if( ! empty( $list_doi_xoa ) )
        {
            foreach ($list_doi_xoa as $doi)
            {
                DB::table('tbl_donvi_doi')->where(['iddoi' => $doi, 'iddonvi' => $iddonvi])->delete();
            }
        }
        
        return redirect()->route('don-vi.index');
        
    }

    public function getDoi($iddonvi = NULL)
    {
        $data['list_doi'] = DB::table('tbl_donvi_doi')
                ->join('tbl_donvi', 'tbl_donvi.id', '=', 'tbl_donvi_doi.iddonvi')
                ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
                ->where('tbl_donvi.id', $iddonvi)
                ->select('tbl_doicongtac.name', 'tbl_donvi_doi.id')
                ->get()->toArray();
        return response()->json(['html' => view('cahtcore.doicongtac.option_select_doi', $data)->render()]);

    }

    
}
