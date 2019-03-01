<?php

namespace App\Services;

use App\Tag;
use App\Task;
use Illuminate\Support\Facades\Input;

class TaskService
{
    public static function getValidTagString($tags)
    {
        return empty($tags) ? '' : $tags;
    }

    public static function getTagsIdsFromStr($tagsString)
    {
        $tagNames = collect(explode(',', $tagsString));

        return $tagNames->map(function ($item, $key) {
            $tagName = trim($item);
            if (strlen($tagName) > 10) {
                throw new \Exception(" Length of {$tagName} is too long. Max length is 15 characters");
            }

            return $tagName;
        })->unique()->reject(function ($name) {
            return empty($name);
        })->map(function ($tagName, $key) {
            return Tag::firstOrCreate(['name' => strtolower($tagName)])->id;
        })->toArray();
    }

    public static function getListAndFilterTasks()
    {
        return Task::with(['tags', 'creator', 'assignedTo'])
            ->createdByAuthUser(Input::get('is_my_task'))
            ->withStatus(Input::get('status_id'))
            ->assignedToUser(Input::get('assigned_to_id'))
            ->withTag(Input::get('tag_id'))
            ->paginate(10);
    }
}
