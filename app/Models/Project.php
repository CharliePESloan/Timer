<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Segment;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'timer_started_at',
        'stop_at'
    ];

    public function segments() {
        return $this->hasMany(Segment::class);
    }
}
