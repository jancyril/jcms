<?php

namespace Janitor\Repositories;

use Janitor\Traits\DataTables;

class PostCategories extends BaseRepository
{
    use DataTables;

    protected function model()
    {
        return \Janitor\Models\PostCategory::class;
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
                'name' => $record->name,
                'description' => $record->description,
                'id' => $record->id,
            ];
        })->all();
    }
}
