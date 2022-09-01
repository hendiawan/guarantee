<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cetaks extends Model
{
    //
      public  $timestamps=false;
      protected $fillable=[
          'nomorsertifikat',
          'tglcetak',
          'oleh',
          'keterangan',
       ];
}
