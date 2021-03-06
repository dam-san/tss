<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
    use HasFactory;

    // #インシデント：ソフトデリート
    use SoftDeletes;


    // #インシデント：リレーション
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function threads()
    {
      return $this->hasMany(Thread::class)->orderBy('created_at', 'desc');
    }

    // #インシデント：リレーション：depends on destroy
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($incident) {
            $incident->threads()->delete();
        });
    }


    public function strlength() {
        $str = $this->body;
        $limit = 20;

        if (mb_strlen($str) > $limit ) {
            $str = mb_substr($str, 0, $limit);
            return $str . "...";
        } else {
            return $str;
        }
    }
}
