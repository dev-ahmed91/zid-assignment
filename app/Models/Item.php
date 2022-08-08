<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','url','description'];

    protected $guarded = ['id'];


    public function setDescriptionAttribute($value){
        $converter = new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]);
        $this->attributes['description'] = $converter->convert($value)->getContent();

    }
}
