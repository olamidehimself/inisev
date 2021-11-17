<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url'];

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }
}
