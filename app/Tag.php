<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  protected $fillable = [
        'tag_id',
        'name'
    ];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function twiites()
     {
         return $this->belongsToMany(Twiite::class);
     }
}
