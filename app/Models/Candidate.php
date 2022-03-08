<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'election_id'
    ];


    public function election(){
        return $this->belongsTo(Election::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class, 'candidate_id', 'user_id');
    }
}
