<?php


namespace App\Http\Services\Category;


use App\Http\Repositories\CategoryRepository;
use App\Http\Services\Boilerplate\BaseService;
use Exception;
use Illuminate\Database\QueryException;
use Yajra\DataTables\DataTables;

class CategoryService extends BaseService {

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $request
     * @return array
     */
    public function createCategory($request) :array {
        try {
            $createCategoryResponse = $this->categoryRepository->create(
                $this->preparedCreateCategoryData($request)
            );

            return !$createCategoryResponse ?
                $this->response()->error() :
                $this->response()->success('Category is created');
        } catch(Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @return array
     */
    private function preparedCreateCategoryData($request): array {
        return [
            'name' => $request->name,
            'status' => $request->status
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getCategoryById (int $id) :array {
        try {
            $category = $this->categoryRepository->find($id);

            return !isset($category) ?
                $this->response()->error() :
                $this->response($category)->success();
        } catch (QueryException $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function updateCategory($request) :array {
        try {
            $category = $this->categoryRepository->find($request->category_id);
            if(!isset($category)) return $this->response()->error('No category was found');

            $updateCategoryResponse = $this->categoryRepository->updateWhere(
                ['id' => $request->category_id],
                $this->preparedUpdateCategoryData($request, $category)
            );

            return !$updateCategoryResponse ?
                $this->response()->error() :
                $this->response()->success('Category is updated');
        } catch(Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @param $category
     * @return array
     */
    private function preparedUpdateCategoryData($request, $category): array {
        return [
            'name' => $request->name,
            'status' => $request->status
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteCategory(int $id) :array {
        try{
            $deleteCategoryResponse = $this->categoryRepository->deleteWhere(
                ['id' => $id]
            );

            return $deleteCategoryResponse <= 0 ?
                $this->response()->error() :
                $this->response()->success('Category is deleted');
        } catch(Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param object $request
     * @return object|null
     */
    public function categoryTableData(object $request): ?object {
        if (!$request->ajax()) return null;

        $allCategory = $this->queryCategoryTableData();

        if (!$allCategory['success']) return null;
        $allCategory = $allCategory['data'];

        try {
            return Datatables::of($allCategory)
                ->addColumn('name', function ($item) {
                    return '<ul class="activity-menu list-unstyled" style="display: inline-flex;">
                                <li>
                                    <a class="text-success mr-2"  href="' . route('web.product.list', encrypt($item->id)) .'" data-placement="top" title="' . __('Category name') . '">
                                        '.$item->name.'
                                    </a>
                                </li>
                            </ul>';
                })
                ->addColumn('status', function ($item) {
                    $status = $item->status != ACTIVE ?
                        '<a class="text-danger mr-2" href="#">INACTIVE</a>' :
                        '<a class="text-success mr-2" href="#">ACTIVE</a>';
                    return !isset($item->status) ? 'N/A' : $status;
                })
                ->addColumn('action', function ($item) {
                    return '<ul class="activity-menu list-unstyled" style="display: inline-flex;">
                                <li>
                                    <a class="text-success mr-2" 
                                    href="' . route('web.category.edit', ['id' => encrypt($item->id)]) .'" data-placement="top" title="' . __('Edit') . '">
                                        <i class="nav-icon i-Pen-2 font-weight-bold editCategory"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="text-danger mr-2 confirmedDelete" href="' . route('web.category.delete', ['id' => encrypt($item->id)]) . '"data-toggle="tooltip" data-placement="top" title="' . __('Delete') . '">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                    </a>
                                </li> 
                            </ul>';
                })
                ->rawColumns(['action', 'name', 'status'])
                ->make(true);
        } catch (Exception $e) {

            return null;
        }
    }

    /**
     * @return array
     */
    public function queryCategoryTableData(): array {
        try {
            $allCategory = $this->categoryRepository->selectData();

            return !isset($allCategory) ?
                $this->response()->error() :
                $this->response($allCategory)->success();
        } catch (QueryException $e) {

            return $this->response()->error();
        }
    }

    /**
     * @return array
     */
    public function getAllCategory () :array {
        try {
            $allCategory = $this->categoryRepository->getData(['status' => ACTIVE]);

            return $allCategory->isEmpty() ?
                $this->response()->error('No category found') :
                $this->response($allCategory)->success();
        } catch (QueryException $e) {

            return $this->response()->error();
        }
    }

}