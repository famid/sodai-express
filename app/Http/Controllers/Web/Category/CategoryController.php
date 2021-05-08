<?php


namespace App\Http\Controllers\Web\Category;


use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateCategoryRequest;
use App\Http\Requests\Web\UpdateCategoryRequest;
use App\Http\Services\Category\CategoryService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller {

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * CategoryService constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    /**
     * @return Application|Factory|View
     */
    public function listView () {
        return view('category.list');
    }

    /**
     * @param Request $request
     * @return object|null
     */
    public function categoryTableData (Request $request): ?object {
        return $this->categoryService->categoryTableData($request);
    }

    /**
     * @return Application|Factory|View
     */
    public function createView() {
        return view('category.create');
    }

    /**
     * @param CreateCategoryRequest $request
     * @return RedirectResponse
     */
    public function create(CreateCategoryRequest $request): RedirectResponse {
        return $this->webResponse($this->categoryService->createCategory($request), 'web.category.listView');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function editView($id) {
        $data = $this->categoryService->getCategoryById(decrypt($id));
        return view('category.edit', $data);
    }

    /**
     * @param UpdateCategoryRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateCategoryRequest $request): RedirectResponse {
        return $this->webResponse($this->categoryService->updateCategory($request), 'web.category.listView');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse {
        return $this->webResponse($this->categoryService->deleteCategory(decrypt($id)), 'web.category.listView');
    }
}