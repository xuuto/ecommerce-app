<?php

namespace App\Http\Controllers\Admin;

use App\Contract\CategoryContract;
use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends BaseController
{
    protected $categoryRepository;

    public function __construct (CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index ()
    {
        $categories = $this->categoryRepository->listCategories();
        $this->setPageTitle('Categories', 'List of All Categories');
        return view('admin.categories.index', compact('categories'));
    }

    public function create ()
    {
        $categories = $this->categoryRepository->listCategories('id', 'asc');
        $this->setPageTitle('Categories', 'Create Category');
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store (Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'parent_id' => 'required|not_in:0',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);
        $params = $request->except('_token');
//        dd($params);
        $category = $this->categoryRepository->createCategory($params);
        if (!$category) {
            return $this->responseRedirectBack('Error occurred while creating category', 'error',);
        }
        return $this->responseRedirect('admin.categories.index', 'Category added successfully', 'success', false, false);

    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit ($id)
    {

        $targetCategory = $this->categoryRepository->findCategoryById($id);
        $categories = $this->categoryRepository->listCategories();

        $this->setPageTitle('Categories', 'Edit Category : ' . $targetCategory->name);
        return view('admin.categories.edit', compact('targetCategory', 'categories'));
    }

    public function update (Request $request): RedirectResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:191',
                'parent_id' => 'required|not_in:0',
                'image' => 'mimes:jpg,jpeg,png|max:1000'
            ]);
        } catch (ValidationException $e) {
        }

        $params = $request->except('_token');

        $category = $this->categoryRepository->updateCategory($params);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while updating category.', 'error' );
        }
        return $this->responseRedirectBack('Category updated successfully', 'success');
    }

    public function delete($id): RedirectResponse
    {
        $category = $this->categoryRepository->deleteCategory($id);
        if (!$category) {
            return $this->responseRedirectBack('Error ocured while trying to delete category.', 'error');
        }

        return $this->responseRedirect('admin.categories.index', 'category deleted successfully',
            'success');

    }
}
