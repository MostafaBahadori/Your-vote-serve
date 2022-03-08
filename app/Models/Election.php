<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'manager_id',
		'image'
    ];

    public function candidates(){
        return $this->hasMany(Candidate::class);
    }
    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
