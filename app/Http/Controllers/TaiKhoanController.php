<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaiKhoanRepository\ITaiKhoan;

class TaiKhoanController extends Controller
{
    //
  protected $taikhoan;
  public function __construct(ITaiKhoan $taikhoan) 
  {
    $this->taikhoan = $taikhoan;
  }
  public function index()
  {
    $listTaiKhoan = $this->taikhoan->getAll();
    return $listTaiKhoan;
  }
}
