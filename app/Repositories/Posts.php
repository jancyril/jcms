<?php

namespace Janitor\Repositories;

use Janitor\Traits\DataTables;

class Posts extends BaseRepository
{
    use DataTables;

    protected function model()
    {
        return \Janitor\Models\Post::class;
    }

    /**
     * The data to be returned to datatables.
     *
     * @param object $records Instance of \Illuminate\Database\Eloquent\Collection
     *
     * @return array
     */
    protected function map(\Illuminate\Database\Eloquent\Collection $records): array
    {
        return $records->map(function ($record) {
            return [
                $record->title,
                $record->created_at->format('F d, Y H:i'),
                $record->id,
            ];
        })->all();
    }
}
