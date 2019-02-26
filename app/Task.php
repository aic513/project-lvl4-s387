<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Task
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task query()
 * @mixin \Eloquent
 */
class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'assignedTo',
    ];

    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    public function assignedTo()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\TaskStatus');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }


}
