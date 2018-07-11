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
    public function index()
    {
        $list_donvis = DB::table('tbl_donvi')->orderBy('id', 'desc')->paginate(10);
        return view('cahtcore.donvi.index', compact('list_donvis'));
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
        $donvi = DB::table('tbl_donvi')->where('id', $id)->first();
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

    public function setdoi($id)
    {
        $donvi = DB::table('tbl_donvi')->where('id', $id)->first();
        $list_dois = DB::table('tbl_doicongtac')->get()->toArray();
        $list_doi_currents = DB::table('tbl_donvi_doi')->where('iddonvi', $id)->pluck('iddoi')->toArray();
        return view('cahtcore.donvi.setdoi', compact('list_dois', 'donvi', 'list_doi_currents'));
    }

    public function store_set_doi(Request $request, $id)
    {
        $this->validate($request,
            [
                'list_doi_donvi' => 'required',
            ],
            [
                'list_doi_donvi.required' => 'Tên đơn vị không được trống',
            ]
        );
        
        $listdoi_post = $request->list_doi_donvi;
        $listdoi_db = DB::table('tbl_donvi_doi')->where('iddonvi', $id)->pluck('iddoi')->toArray();

        $list_doi_add = array_diff($listdoi_post, $listdoi_db);
        $list_doi_xoa = array_diff($listdoi_db, $listdoi_post);

        if( ! empty($list_doi_add ) )
        {
            $data_add = array();
            foreach ($list_doi_add as $doi)
            {
                $data_add[] = array(
                    'iddonvi' => $id,
                    'iddoi' => $doi,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );
            }

            $id = DB::table('tbl_donvi_doi')->insert($data_add);
            $str = ($id) ? 'Thêm đội thành công' : 'Thêm đội không thành công';
        }

        if( ! empty( $list_doi_xoa ) )
        {
            foreach ($list_doi_xoa as $doi)
            {
                DB::table('tbl_donvi_doi')->where(['iddoi' => $doi, 'iddonvi' => $id])->delete();
            }
        }
        
        return redirect()->route('don-vi.index');
        
    }

    public function getDoi($id)
    {
        $list_doi = DB::table('tbl_donvi_doi')
                ->join('tbl_donvi', 'tbl_donvi.id', '=', 'tbl_donvi_doi.iddonvi')
                ->join('tbl_doicongtac', 'tbl_doicongtac.id', '=', 'tbl_donvi_doi.iddoi')
                ->where('tbl_donvi.id', $id)
                ->select('tbl_doicongtac.name', 'tbl_donvi_doi.id')
                ->get()->toArray();
        return view('cahtcore.doicongtac.option_select_doi', compact('list_doi'));

    }
}
