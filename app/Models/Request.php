<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'title',
        'from',
        'to',
        'answer',
        'answered_at'
    ];


    /**
     * Get the User associated with the Request.
     */
    public function from()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    /**
     * Get the Manager associated with the Request.
     */
    public function to()
    {
        return $this->belongsTo(Manager::class, 'to', 'id');
    }




}
