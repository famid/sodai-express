<?php


namespace App\Http\Controllers\Web\Product;


use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateProductRequest;
use App\Http\Requests\Web\UpdateProductRequest;
use App\Http\Services\Category\CategoryService;
use App\Http\Services\Product\ProductService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller {

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * ProductService constructor.
     * @param ProductService $productService
     * @param CategoryService $categoryService
     */
    public function __construct(ProductService $productService, CategoryService $categoryService) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    /**
     * @param $categoryId
     * @return Application|Factory|View
     */
    public function list ($categoryId) {
        $category = $this->categoryService->getCategoryById(decrypt($categoryId));
        return view('product.list', ['categoryId' => $categoryId, 'nav' => $category['data']['name']]);
    }

    /**
     * @param $categoryId
     * @param Request $request
     * @return object|null
     */
    public function filterProductTableData ($categoryId, Request $request): ?object {
        return $this->productService->productTableData($request, decrypt($categoryId));
    }

    /**
     * @return Application|Factory|View
     */
    public function listView () {
        return view('product.list');
    }

    /**
     * @param Request $request
     * @return object|null
     */
    public function productTableData (Request $request): ?object {
        return $this->productService->productTableData($request);
    }

    /**
     * @return Application|Factory|View
     */
    public function createView() {
        $data['categories'] = $this->categoryService->getAllCategory();
        return view('product.create', $data);
    }

    /**
     * @param CreateProductRequest $request
     * @return RedirectResponse
     */
    public function create(CreateProductRequest $request): RedirectResponse {
        return $this->webResponse($this->productService->createProduct($request), 'web.product.listView');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function editView($id) {
        $data['categories'] = $this->categoryService->getAllCategory();
        $data ['product'] = $this->productService->getProductById(decrypt($id));
//        dd($data['product']);
        return view('product.edit', $data);
    }

    /**
     * @param UpdateProductRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request): RedirectResponse {
        return $this->webResponse($this->productService->updateProduct($request), 'web.product.listView');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse {
        return $this->webResponse($this->productService->deleteProduct(decrypt($id)), 'web.product.listView');
    }
}