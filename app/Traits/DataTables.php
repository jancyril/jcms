<?php

namespace Janitor\Traits;

trait DataTables
{
    /**
     * Will be used for data table that uses ajax to fetch data.
     *
     * @param array $data The data requested by the client
     *
     * @return array
     */
    public function dataTables(array $data): array
    {
        $index = $data['order'][0]['column'];
        $column = $data['columns'][$index]['name'];
        $keyword = $data['search']['value'];

        $results = $this->records($data, $column, $keyword);

        $count = $this->countBy($column, $keyword.'%', 'like');

        return $this->format($data['draw'], $count, $this->map($results));
    }

    /**
     * This will query the model for the records requested
     * A custom whereRaw condition is appended at the bottom if
     * the query needs specific result.
     *
     * @param array  $data    The data requested by the client
     * @param string $column  The column used for sorting and searching
     * @param string $keyword The value of the column
     *
     * @return collection
     */
    private function records(array $data, string $column, string $keyword)
    {
        $query = $this->model->select($this->fields($data['columns']))
                        ->with($this->dataTablesRelationships())
                        ->where($column, 'like', $keyword.'%')
                        ->orderBy($column, $data['order'][0]['dir'])
                        ->take($data['length'])
                        ->skip($data['start']);

        if (!$this->dataTablesWhere()) {
            return $query->get();
        }

        return $query->whereRaw($this->dataTablesWhere())->get();
    }

    /**
     * This will get the fields requested.
     *
     * @param array $columns The columns requested
     *
     * @return collection
     */
    private function fields(array $columns)
    {
        return collect($columns)->filter(function ($column) {
            return $column['name'] != '';
        })->map(function ($column) {
            return $column['name'];
        })->all();
    }

    /**
     * This will format the data to be returned to the user.
     *
     * @param int   $draw    An integer sent by dataTables
     * @param int   $count   The number of the total results
     * @param array $results The number of results filtered
     *
     * @return array
     */
    private function format($draw, $count, $results): array
    {
        return [
            'draw' => intval($draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $results,
        ];
    }

    /**
     * Abstract method to force being required.
     *
     * @param object $records
     */
    abstract public function map(\Illuminate\Database\Eloquent\Collection $records);

    /**
     * This method will contain the relationships for the dataTables.
     *
     * @return array
     */
    protected function dataTablesRelationships(): array
    {
        return [];
    }

    /**
     * This method will contain the additional conditions for dataTables.
     *
     * @return bool|object
     */
    protected function dataTablesWhere()
    {
        return false;
    }
}
