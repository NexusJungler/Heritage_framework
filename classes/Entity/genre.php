<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 13/01/17
 * Time: 15:44
 */

namespace Aston\Entity;


use Illuminate\Database\Eloquent\Model;


class author extends Model
{

    protected $fillable = ['title','body'];
    protected $table = 'genre';

    public function books() {
        return $this->hasMany('book');
    }

}