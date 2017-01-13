<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 13/01/17
 * Time: 13:54
 */

namespace Aston\Entity;


use Illuminate\Database\Eloquent\Model;


class book extends Model
{
    /*
    public $title;
    public $author;
    public $body;
    public $genre;
    */

    protected $fillable = ['title', 'author_id', 'genre_id', 'body'];

    public function author() {
        return $this->belongsTo('Author');
    }

    public function genre() {
        return $this->belongsTo('Genre');
    }

}