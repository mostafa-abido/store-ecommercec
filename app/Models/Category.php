<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    /*
    protected $table ="categories";
    protected $guarded = [];
    protected $with = ['translations'];
    public $timestamps = true;
    */
    protected $table ="categories";
    protected $guarded = [];
    protected $with = ['translations'];
    public $timestamps = true;

    protected $translatedAttributes = ['name'];



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['translations'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

        
    
    
    public function scopeParent($query){
        return $query -> whereNull('parent_id');
    }


    public function scopeChild($query){
        return $query -> whereNull('parent_id');
    }

    public function getActive(){
        return  $this -> is_active  == 0 ?  'غير مفعل'   : 'مفعل' ;
     }



    public function _parent() 
    {
        return $this->belongsTo(self::class,'parent_id');
    } 
}