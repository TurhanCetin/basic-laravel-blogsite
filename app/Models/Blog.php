<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Blog extends Model
{
    use HasFactory;

    public function getCatName() {
       return $this->hasOne('App\Models\Category', 'id','categoryid');
        /*$cat = DB::table('categories')->where('id', $id)->first();
        return $cat->name;*/
    }

}
