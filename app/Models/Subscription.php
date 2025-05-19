<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin Builder
 */
class Subscription extends Model
{
    protected $fillable = ['email', 'city', 'frequency', 'token'];

    public static function store(array $data): Subscription
    {
        $data['token'] = Str::random(40);
        return Subscription::create($data);
    }
}
