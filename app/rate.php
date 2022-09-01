<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of rate
 *
 * @author ASUS
 */
class rate extends Model {

    protected $table = 'rate';

    public function bank() {
        return $this->hasMany('banks');
    }
    public $timestamps = false;
    
    protected $fillable = [
        'namarate', 
        'idbank', 
        'dari', 
        'sampai', 
        'jnspnj', 
        'idproduk', 
        'rate'];

}
