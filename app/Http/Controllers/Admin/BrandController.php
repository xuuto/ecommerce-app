<?php

namespace App\Http\Controllers\Admin;

use App\Contract\BrandContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    protected $brandRepository;


    public function __construct (BrandContract $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $brands = $this->brandRepository->listBrands();

        $this->setPageTitle('Brands', 'List of all brands');
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        $this->setPageTitle('Brands', 'Create Brand');
        return view('admin.brands.create');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $brand = $this->brandRepository->findBrandById($id);
        $this->setPageTitle('Brands', 'Edit Brand : '.$brand->name);
        return view('admin.brands.edit', compact('brand'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'name'  => 'required|max:191',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');
        $brand = $this->brandRepository->createBrand($params);
        if (!$brand) {
            return $this->responseRedirectBack('Error occured while creating brand.', 'error');
        }
        return $this->responseRedirect('admin.brands.index', 'Brand added successfully', 'success');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|max:191',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');
        $brand = $this->brandRepository->updateBrand($params);
        if (!$brand) {
            return $this->responseRedirectBack('Error occured while updating brand', 'error',);
        }
        return $this->responseRedirectBack('Brand updated successfully', 'success');
    }

    public function delete($id)
    {
        $brand = $this->brandRepository->deleteBrand($id);
        if (!$brand) {
            return $this->responseRedirectBack('Error occured while deleting brand', 'error');
        }
        return $this->responseRedirect('admin.brands.index', 'brand deleted successfully', 'success');
    }
}
