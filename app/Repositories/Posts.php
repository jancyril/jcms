<?php

namespace Janitor\Repositories;

use Janitor\Models\Post;
use Janitor\Traits\DataTables;
use Illuminate\Database\Eloquent\Collection;

class Posts extends BaseRepository
{
    use DataTables;

    protected function model()
    {
        return Post::class;
    }

    public function create(array $data)
    {
        $data['user_id'] = $data['user_id'] ?? auth()->user()->id;

        return parent::create($data);
    }

    /**
     * The data to be returned to datatables.
     *
     * @param object $records Instance of \Illuminate\Database\Eloquent\Collection
     *
     * @return array
     */
    protected function map(Collection $records): array
    {
        return $records->map(function ($record) {
            return [
                'title' => $record->title,
                'date' => $record->created_at->format('F d, Y H:i'),
                'status' => ucwords($record->status),
                'url' => route('admin::edit-post', $record->id),
                'id' => $record->id,
            ];
        })->all();
    }
}
