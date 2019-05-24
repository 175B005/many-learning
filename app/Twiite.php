<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Twiite extends Model
{
  protected $fillable = [
        'user_id',
        'contents'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

   public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
