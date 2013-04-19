<?php

namespace Brew\Products;

use Michelf\Markdown;
use Reinink\Query\DB;
use Reinink\Reveal\Response;

class API
{
    public function getAllProducts()
    {
        return DB::rows('products::public.products.all');
    }

    public function getProductById($id)
    {
        // Load product
        if (!$product = Product::select('id, title, introduction, description, title_tag, description_tag, slug')
                               ->where('id', $id)
                               ->row()) {
            return false;
        }

        // Convert markdown description
        $product->description = trim(Markdown::defaultTransform(htmlentities($product->description)));

        // Return product
        return $product;
    }

    public function getProductBySlug($slug)
    {
        // Load product
        if (!$product = Product::select('id, title, introduction, description, title_tag, description_tag, slug')
                               ->where('slug', $slug)
                               ->row()) {
            return false;
        }

        // Convert markdown description
        $product->description = trim(Markdown::defaultTransform(htmlentities($product->description)));

        // Return product
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
