<?php

namespace Brew\Products;

use Michelf\Markdown;
use Reinink\Query\DB;
use Reinink\Reveal\Response;
use Reinink\Trailmix\Str;

class API
{
    public function getAllProducts()
    {
        // Load products
        $products = DB::rows('products::public.products.all');

        // Add slug
        foreach ($products as $product) {
            $product->slug = Str::slug($product->title);
        }

        return $products;
    }

    public function getProduct($id)
    {
        // Load product
        if (!$product = Product::select('id, title, introduction, description, title_tag, description_tag')->where('id', $id)->row()) {
            return false;
        }

        // Add slug
        $product->slug = Str::slug($product->title);

        // Convert markdown description
        $product->description = trim(Markdown::defaultTransform(htmlentities($product->description)));

        return $product;
    }

    public function getProductPhotos($product_id)
    {
        return ProductPhoto::select('id, caption')
                           ->where('product_id', $product_id)
                           ->orderBy('display_order')
                           ->rows();
    }

    public function getPhotoResponse($size, $id)
    {
        return Response::jpg(STORAGE_PATH . 'products/photos/' . $id . '/' . $size . '.jpg');
    }
}
