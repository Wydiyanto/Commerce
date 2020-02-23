<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductPrice;

use App\Interfaces\IProductRepository; 

class ProductRepository implements IProductRepository {
    //  find product by fabelio product id
    public function findOrCreateProduct($fabelio_id, $data = []) {
        return Product::firstOrCreate(['fabelio_id' => $fabelio_id], $data);
    }

    //  get latest price
    public function getLatestPriceUpdated($product_id) {
        return ProductPrice::where('product_id', $product_id)
                           ->latest()
                           ->value('created_at');
    }

    public function insertProductPrice($data) {
        ProductPrice::create($data);
    }

    public function getProducts() {
        return Product::all();
    }

    public function updateLatestPrice($product_id, $latest_price) {
        Product::where('id', $product_id)->update(['latest_price' => $latest_price]);
    }

    public function getProductPriceList($product_id) {

//         $products = Product::with('product_prices')
//                            // ->where('id', $product_id)
//                            ->find($product_id);

//         return $products;
    }
}
