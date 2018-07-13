<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
   /**
   * The connection name for the model.
   *
   * @var string
   */
  //protected $connection = 'coredb';

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tbl_huyen_tx';
}
