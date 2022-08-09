<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /*
     * using mutators for description
     *
     * */
    public function setDescriptionAttribute($value){
        if($this->isHtml($value)){
            $this->attributes['description']  = $value;
        }else{
            $converter = new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]);
            $this->attributes['description'] = $converter->convert($value)->getContent();
        }
    }

    /*
     * check if the string contains only letters ans spaces
     * */
    private function isHtml($string)
    {
        return preg_match("/^[a-zA-Z\s]+$/", $string);
    }
}
