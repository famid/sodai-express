<?php


namespace App\Http\Repositories;


use App\Models\Category;

class CategoryRepository extends BaseRepository {

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category) {
        parent::__construct($category);
    }
}