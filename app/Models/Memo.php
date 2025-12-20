<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'status',
        'tag_id',
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }



}

