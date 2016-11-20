<?php
/**
 * This is the abstract BaseRepository class that will be extended by all other concrete classes.
 * This contains basic and commonly used database operations.
 *
 * PHP 7
 *
 * @author Jan Cyril Segubience <jancyrilsegubience@gmail.com>
 */

namespace Janitor\Repositories;

use Log;
use Exception;

abstract class BaseRepository
{
    /**
     * A property that will hold the instance of the model.
     *
     * @var object
     */
    protected $model;

    /**
     * A property of what specific column will be selected for every query.
     *
     * @var array
     */
    public $columns = ['*'];

    /**
     * The id of the newly created record.
     *
     * @var int
     */
    public $id = 0;

    /**
     * A property of which column needs to be ordered by.
     *
     * @var string
     */
    public $order = 'id';

    /**
     * A property of how to sort the column being orderd by.
     *
     * @var string
     */
    public $sort = 'desc';

    /**
     * A property used to set the limit of the query.
     *
     * @var int
     */
    public $limit = 10;

    /**
     * A property used to set the offset of the query.
     *
     * @var int
     */
    public $offset = 0;

    /**
     * A property for the relationships to be included on query.
     *
     * @var array
     */
    public $relationships = [];

    /**
     * Constructor will make a new instance of the model.
     */
    public function __construct()
    {
        $this->model = app()->make($this->model());
    }

    /**
     * This method will create a new record on the model.
     *
     * @param array $data An array of data to be persisted
     *
     * @return bool|collection
     */
    public function add(array $data)
    {
        try {
            $entity = $this->model->create($data);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }

        $this->id = $entity->id;

        return $entity;
    }

    /**
     * This will update an existing record based on the key.
     *
     * @param string|int $value The primary key or any unique column
     * @param array      $data  An array of data that will be persisted
     * @param string     $key   The field of the primary key or of the unique
     *                          column
     *
     * @return bool
     */
    public function update($value, array $data, string $key = 'id')
    {
        try {
            $this->limit = 1;
            $this->model->where($key, $value)->first()->update($data);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * This will delete a record from the model.
     *
     * @param int|array $id An integer or an array of integers, usually the primary keys
     *
     * @return bool
     */
    public function delete(int $id)
    {
        if (!$this->model->destroy($id)) {
            return false;
        }

        return true;
    }

    /**
     * This will get records from the model.
     *
     * @return object|bool
     */
    public function get()
    {
        $entities = $this->model->select($this->columns)
            ->take($this->limit)
            ->skip($this->offset)
            ->orderBy($this->order, $this->sort)
            ->with($this->relationships)
            ->get();
                                
        if ($entities->isEmpty()) {
            return false;
        }

        return $entities;
    }

    /**
     * This will find a record from the model based on the id.
     *
     * @param int $id The id of the record to be fetched
     *
     * @return object|bool
     */
    public function findById(int $id)
    {
        try {
            $entity = $this->model->select($this->columns)
                ->orderBy($this->order, $this->sort)
                ->with($this->relationships)
                ->findOrFail($id);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }

        return $entity;
    }

    /**
     * This will find a record based on the specified field.
     *
     * @param string     $field The database column that will be used to query
     * @param string|int $value The value of the column to be queried
     *
     * @return object|bool
     */
    public function findBy(string $field, $value)
    {
        $entities = $this->model->select($this->columns)
            ->where($field, $value)
            ->take($this->limit)
            ->skip($this->offset)
            ->orderBy($this->order, $this->sort)
            ->with($this->relationships)
            ->get();

        if ($entities->isEmpty()) {
            return false;
        }

        return $entities;
    }

    /**
     * This will find a record based on a specific condition.
     *
     * @param string $field    The database column that will be used to query
     * @param mixed  $value    The value of the column to be queried
     * @param string $operator The operator to be used
     *
     * @return object|bool
     */
    public function findWhere(string $field, $value, string $operator = '=')
    {
        $entities = $this->model->select($this->columns)
            ->where($field, $operator, $value)
            ->take($this->limit)
            ->skip($this->offset)
            ->orderBy($this->order, $this->sort)
            ->with($this->relationships)
            ->get();

        if ($entities->isEmpty()) {
            return false;
        }

        return $entities;
    }

    /**
     * This will find a record using the WHERE IN query.
     *
     * @param string $field The database column that will be used to query
     * @param array  $value The value of the column to be queried
     *
     * @return object|bool
     */
    public function findWhereIn(sting $field, array $value)
    {
        $entities = $this->model->select($this->columns)
            ->whereIn($field, $value)
            ->take($this->limit)
            ->skip($this->offset)
            ->orderBy($this->order, $this->sort)
            ->with($this->relationships)
            ->get();

        if ($entities->isEmpty()) {
            return false;
        }

        return $entities;
    }

    /**
     * This will count the number of record in the model.
     *
     * @return int
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * This will count the number of record in the model with a specific condition.
     *
     * @param string $field    The database column that will be used to query
     * @param string $value    The value of the column to be queried
     * @param string $operator The operator to be used
     *
     * @return int
     */
    public function countBy(string $field, $value, string $operator = '=')
    {
        return $this->model->where($field, $operator, $value)->count();
    }
}
