<?php


namespace App\Http\Services\Product;


use App\Http\Repositories\ProductRepository;
use App\Http\Services\Boilerplate\BaseService;
use App\Http\Services\Boilerplate\FileManagementService;
use Exception;
use Illuminate\Database\QueryException;
use Yajra\DataTables\DataTables;

class ProductService extends BaseService {

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var FileManagementService
     */
    private $fileManagementService;

    /**
     * ProductService constructor.
     * @param ProductRepository $productRepository
     * @param FileManagementService $fileManagementService
     */
    public function __construct(ProductRepository $productRepository,
                                FileManagementService $fileManagementService) {
        $this->productRepository = $productRepository;
        $this->fileManagementService = $fileManagementService;
    }

    /**
     * @param $request
     * @return array
     */
    public function createProduct($request) :array {
        try {
            $createProductResponse = $this->productRepository->create(
                $this->preparedCreateProductData($request)
            );

            return !$createProductResponse ?
                $this->response()->error() :
                $this->response()->success('Product is created');
        } catch(Exception $e) {

            return $this->response()->error($e->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     * @throws Exception
     */
    private function preparedCreateProductData (object $request) :array {
        return [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'unit' => $request->unit,
            'unit_amount' => $request->unit_amount,
            'price' => $request->price,
            'in_stock' => $request->in_stock,
            'product_discount' => $request->product_discount,
            'tax_percentage' => $request->tax_percentage,
            'status' => $request->status,
            'image' => !$request->hasFile('image') ? null : $this->imageFileUpload($request),
        ];
    }

    /**
     * @param $request
     * @param object|null $product
     * @return mixed
     * @throws Exception
     */
    private function imageFileUpload ($request, object $product = null) {
        $replacementPart =  env('SERVER_URL').'storage/'.$this->fileManagementService->productImagePath();
        $oldFileName = !isset($product) ? null : str_replace($replacementPart,'',$product->image);
        $imagePath = $this->fileManagementService->uploadFile(
            $request->image,
            $this->fileManagementService->productImagePath(),
            $oldFileName
        );
        if(!$imagePath['success']) throw new Exception($this->response()->error());

        return $imagePath['data'];
    }

    /**
     * @param $request
     * @return array
     */
    public function updateProduct($request) :array {
        try {
            $product = $this->productRepository->find($request->product_id);
            if(!isset($product)) return $this->response()->error('No product was found');

            $updateProductResponse = $this->productRepository->updateWhere(
                ['id' => $request->product_id],
                $this->preparedUpdateProductData($request, $product)
            );

            return !$updateProductResponse ?
                $this->response()->error() :
                $this->response()->success('Product is updated');
        } catch(Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param object $request
     * @param object $product
     * @return array
     * @throws Exception
     */
    private function preparedUpdateProductData (object $request, object $product) :array {
        return [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'unit' => $request->unit,
            'unit_amount' => $request->unit_amount,
            'price' => $request->price,
            'in_stock' => $request->in_stock,
            'product_discount' => $request->product_discount,
            'tax_percentage' => $request->tax_percentage,
            'status' => $request->status,
            'image' => !$request->hasFile('image') ? $product->image : $this->imageFileUpload($request, $product),
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteProduct(int $id) :array {
        try{
            $deleteFileResponse = $this->deleteImageFile($id);
            if(!$deleteFileResponse) return $deleteFileResponse;
            $deleteProductResponse = $this->productRepository->deleteWhere(
                ['id' => $id]
            );

            return $deleteProductResponse <= 0 ?
                $this->response()->error() :
                $this->response()->success('Product is deleted');
        } catch(Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param $id
     * @return array
     */
    private function deleteImageFile ($id): array {
        $product = $this->productRepository->find($id);
        if(!isset($product)) return $this->response()->error('No product was found');
        if(is_null($product->image)) return $this->response()->success();

        $replacementPart =  env('SERVER_URL').'storage/'.$this->fileManagementService->productImagePath();
        $file = !isset($product) ? null : str_replace($replacementPart,'', $product->image);
        $deleteFileResponse = $this->fileManagementService->deleteFile(
            $this->fileManagementService->productImagePath(),
            $file
        );

        return !$deleteFileResponse ?
            $this->response()->error():
            $this->response()->success();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getProductById (int $id) :array {
        try {
            $product = $this->productRepository->find($id);

            return !isset($product) ?
                $this->response()->error() :
                $this->response($product)->success();
        } catch (QueryException $e) {

            return $this->response()->error();
        }
    }

    /**
     * @return array
     */
    public function getAllProducts () :array {
        try {
            $allProduct = $this->productRepository->getData(['status' => ACTIVE]);

            return ($allProduct->isEmpty()) ?
                $this->response()->error('no product was found') :
                $this->response($allProduct)->success();
        } catch (QueryException $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param null $categoryId
     * @return array
     */
    private function queryProductTableData ($categoryId = null) :array {
        try {
            $allProduct = $this->productRepository->productTableDataQuery($categoryId);

            return !isset($allProduct) ?
                $this->response()->error() :
                $this->response($allProduct)->success();
        } catch (QueryException $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param object $request
     * @param null $categoryId
     * @return object|null
     */
    public function productTableData(object $request, $categoryId = null): ?object {
        if (!$request->ajax()) return null;

        $allProduct = $this->queryProductTableData($categoryId);

        if (!$allProduct['success']) return null;
        $allProduct = $allProduct['data'];

        try {
            return Datatables::of($allProduct)
                ->addColumn('name', function ($item) {
                    return !isset($item->product_name) ? 'N/A' : $item->product_name;
                })
                ->addColumn('category_name', function ($item) {
                    return !isset($item->category_name) ? 'N/A' : $item->category_name;
                })

                ->addColumn('in_stock', function ($item) {
                    return !isset($item->product_in_stock) ? 'N/A' : $item->product_in_stock;
                })

                ->addColumn('description', function ($item) {
                    return !isset($item->product_description) ? 'N/A' : $item->product_description;
                })

                ->addColumn('status', function ($item) {
                    $status = $item->product_status != ACTIVE ?
                        '<a class="text-danger mr-2" href="#">INACTIVE</a>' :
                        '<a class="text-success mr-2" href="#">ACTIVE</a>';
                    return !isset($item->product_status) ? 'N/A' : $status;
                })

                ->addColumn('unit', function ($item) {
                    return !isset($item->product_unit) ? 'N/A' : $item->product_unit;
                })

                ->addColumn('unit_amount', function ($item) {
                    return !isset($item->product_unit_amount) ? 'N/A' : $item->product_unit_amount;
                })

                ->addColumn('price', function ($item) {
                    return !isset($item->product_price) ? 'N/A' : $item->product_price;
                })
                ->addColumn('image', function ($item) {
                    $url = asset(str_replace(env('SERVER_URL'),'',$item->product_image));
                    return !isset($item->product_image) ?
                        'N/A' :
                        '<a href="'.$item->product_image.'" target="_blank">
                            <img src="'.$url.'" alt="product_image" width="60" height="50" class="img-rounded"/>
                        </a>';
                })
                ->addColumn('action', function ($item) {
                    return '<ul class="activity-menu list-unstyled" style="display: inline-flex;">
                                <li>
                                    <a class="text-success mr-2" 
                                    href="' . route('web.product.edit', ['id' => encrypt($item->id)]) .'" data-placement="top" title="' . __('Edit') . '">
                                        <i class="nav-icon i-Pen-2 font-weight-bold editProduct"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="text-danger mr-2 confirmedDelete" href="' . route('web.product.delete', ['id' => encrypt($item->id)]) . '"
                                    data-toggle="tooltip" data-placement="top" title="' . __('Delete') . '">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                    </a>
                                </li> 
                            </ul>';
                })
                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        } catch (Exception $e) {

            return null;
        }
    }
}