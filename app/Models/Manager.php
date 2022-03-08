<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'position',
        'creator_id',
        'user_id',
    ];


    /**
     * Get the user associated with the manager.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the requests associated with the manager.
     */
    public function requests()
    {
        return $this->hasMany(Request::class, 'to', 'id');
    }
}
