<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeStatus extends Model
{
    use HasFactory;

    protected $table = 'sys_trainee_status';

    protected $primaryKey = 'trainee_status_id';

    public $timestamps = false;

    protected $fillable = ['trainee_status_id', 'trainee_status_kh', 'trainee_status_en'];

    const Trainee = 1;
    const Deleted = 2;
    const Quit = 3;
    const Postpone = 4;
    const Completed = 5;
}
