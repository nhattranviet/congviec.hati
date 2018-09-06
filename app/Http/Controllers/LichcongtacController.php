<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LichcongtacController extends Controller
{
    public function index(Request $request)
    {
        echo 1;
    }

    public function create()
    {
        $data['page_name'] = 'Thêm lịch công tác';
        return view('cahtcore.lichcongtac.create', $data);
    }
}
