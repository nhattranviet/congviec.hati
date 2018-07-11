<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brief extends Model
{
/**
   * The connection name for the model.
   *
   * @var string
   */
  protected $connection = 'sqlsrv';
  
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tbl_hoso';

  public function getDates()
  {
      return [];
  }
}
