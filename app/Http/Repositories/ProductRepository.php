<?php


namespace App\Http\Repositories;


use App\Models\Product;

class ProductRepository extends BaseRepository {

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product) {
        parent::__construct($product);
    }

    /**
     * @param null $categoryId
     * @return mixed
     */
    public function productTableDataQuery($categoryId = null) {
        $data = $this->model::select(
            "products.id",
            "products.name as product_name",
            "products.description as product_description",
            "products.unit as product_unit",
            "products.unit_amount as product_unit_amount",
            "products.price as product_price",
            "products.in_stock as product_in_stock",
            "products.status as product_status",
            "products.image as product_image",
            "products.category_id",
            "categories.name as category_name",
            "products.created_at"
        )
            ->join("categories", ["products.category_id" => "categories.id"])
            ->orderBy("products.created_at", "desc");

        return !$categoryId ? $data: $data->where(['products.category_id' => $categoryId]);
    }
}