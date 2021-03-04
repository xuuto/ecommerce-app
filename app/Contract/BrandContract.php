<?php


namespace App\Contract;


interface BrandContract
{
    /**
     * @param string         $order
     * @param string         $sort
     * @param array|string[] $columns
     * @return mixed
     */
    public function listBrands(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findBrandById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createBrand(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBrand(array $params);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteBrand($id);
}