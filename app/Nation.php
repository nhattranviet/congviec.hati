<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
   /**
   * The connection name for the model.
   *
   * @var string
   */
  //protected $connection = 'sqlsrv2';

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tbl_dantoc';
}
