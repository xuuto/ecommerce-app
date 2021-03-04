<?php


namespace App\Repositories;


use App\Contract\BaseContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository implements BaseContract
{

    protected $model;


    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(array $attributes, int $id)
    {
        return $this->find($id)->update($attributes);
    }


    /**
     * @param array|string[] $columns
     * @param string         $orderBy
     * @param string         $sortBy
     * @return mixed
     */
    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc')
    {
        if (isset($this->model)) {
            return $this->model->orderBy($orderBy, $sortBy)->get($columns);
        }
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }


    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data)
    {
        return $this->model->where($data)->all();
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->first();
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }
}
