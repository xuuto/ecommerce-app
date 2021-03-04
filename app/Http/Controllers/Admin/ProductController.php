<?php

namespace App\Http\Controllers\Admin;

use App\Contract\BrandContract;
use App\Contract\CategoryContract;
use App\Contract\ProductContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductFormRequest;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    protected $brandRepository;
    protected $categoryRepository;
    protected $productRepository;

    public function __construct (
        BrandContract $brandRepository,
        CategoryContract $categoryRepository,
        ProductContract $productRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index ()
    {
        $products = $this->productRepository->listProducts();

        $this->setPageTitle('Products', 'Product List');
        return view('admin.products.index', compact('products'));
    }

    public function create ()
    {
        $brands = $this->brandRepository->listBrands('name', 'asc');
        $categories = $this->categoryRepository->listCategories('name', 'asc');

        $this->setPageTitle('Products', 'Create Product');
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store (StoreProductFormRequest $request)
    {
        $params = $request->except('_token');
        $product = $this->productRepository->createProduct($params);
        if (!$product) {
            return $this->responseRedirectBack('Error Occurred while updating product.', 'error',);
        }
        return $this->responseRedirect('admin.products.index', 'Product added successfully', 'success', false, false);
    }

    public function edit($id)
    {
        $product = $this->productRepository->findProductById($id);
        $brands = $this->brandRepository->listBrands('name', 'asc');
        $categories = $this->categoryRepository->listCategories('name', 'asc');

        $this->setPageTitle('Products', 'Edit Product');
        return view('admin.products.edit', compact('categories', 'brands', 'product'));
    }

    public function update(StoreProductFormRequest $request)
    {
        $params = $request->except('_token');
//        dd($params);

        $product = $this->productRepository->updateProduct($params);

        if (!$product) {
            return $this->responseRedirectBack('Error occurred while updating product.', 'error',);
        }
        return $this->responseRedirect('admin.products.index', 'Product updated successfully' ,'success',false, false);
    }
}
