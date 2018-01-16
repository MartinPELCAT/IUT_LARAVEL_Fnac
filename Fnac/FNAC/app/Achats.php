<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Achats extends Model
{
    protected $table = 't_e_achat_ach';
    protected $primaryKey = 'ach_id';
    public $timestamps = false;

    
}
