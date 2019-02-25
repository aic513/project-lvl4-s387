<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * App\TaskStatus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskStatus query()
 * @mixin \Eloquent
 */
class TaskStatus extends Model
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'is_editable'
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task', 'status_id');
    }
}
