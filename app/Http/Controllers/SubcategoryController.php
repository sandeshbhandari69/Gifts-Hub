<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index($slug)
    {
        // Simple logic to format title from slug
        $title = ucwords(str_replace('-', ' ', $slug));

        // Mock Data based on slug to populate the view dynamically
        $allProducts = [
            'gadgets' => [
                ['name' => 'Luxury Watch', 'price' => '$9999.99', 'image' => 'assets/images/SubCategory/Gadgets/watch.png'],
                ['name' => 'Headphone', 'price' => '$299.99', 'image' => 'assets/images/SubCategory/Gadgets/headphone.png'],
                ['name' => 'Hp Laptop', 'price' => '$799.99', 'image' => 'assets/images/SubCategory/Gadgets/laptop.png'],
                ['name' => 'Iphone', 'price' => '$1299.99', 'image' => 'assets/images/SubCategory/Gadgets/Iphone.png'],
            ],
            'anniversary-gifts' => [
                ['name' => 'Love Figure', 'price' => '$129.99', 'image' => 'assets/images/SubCategory/Anniversary/01001528_Lladro_I_Love_You_Truly_Couple_Figurine_-_Window_Close-up_600x600-removebg-preview.png'],
                ['name' => 'Couple Statue', 'price' => '$89.99', 'image' => 'assets/images/SubCategory/Anniversary/asset_1164_transformation_3318_720x_73598d93-0618-469d-821c-723e2150c2d7_800x-removebg-preview.png'],
                ['name' => 'Golden Ring', 'price' => '$259.99', 'image' => 'assets/images/SubCategory/Anniversary/bce24f7f22e8656991d5e69e7b5740ec.png_720x720q80-removebg-preview.png'],
                ['name' => 'Champagne Set', 'price' => '$59.99', 'image' => 'assets/images/SubCategory/Anniversary/f309c656006b-affordable-wedding-gift-m-and-s-champagne.jpg-removebg-preview.png'],
                ['name' => 'Couple Watch', 'price' => '$199.99', 'image' => 'assets/images/SubCategory/Anniversary/s-l1200-removebg-preview.png'],
            ],
            'birthday-gifts' => [
                ['name' => 'Birthday Pack', 'price' => '$49.99', 'image' => 'assets/images/SubCategory/Birthday/2.png'], 
                ['name' => 'Happy Birthday Mug', 'price' => '$15.99', 'image' => 'assets/images/SubCategory/Birthday/VH01_d0e6c9a6-6c6e-4395-98d7-769ac474b32d-removebg-preview.png'],
                ['name' => 'Party Set', 'price' => '$39.99', 'image' => 'assets/images/SubCategory/Birthday/s-l1200-removebg-preview.png'],
            ],
            'christmas-gifts' => [
                ['name' => 'Xmas Decoration', 'price' => '$25.99', 'image' => 'assets/images/SubCategory/Chrismas/298204b6ed92b6d418f2f9afbe732e1a-removebg-preview.png'],
                ['name' => 'Santa Gift Bag', 'price' => '$19.99', 'image' => 'assets/images/SubCategory/Chrismas/dd85688371f476e0eefe49a6d4533694-removebg-preview.png'],
                ['name' => 'Red Fleece Hat', 'price' => '$12.99', 'image' => 'assets/images/SubCategory/Chrismas/santa-claus-embroidered-red-fleece-christmas-hat-fancy-dress-accessory-product-image-removebg-preview.png'],
                ['name' => 'Winter Flowers', 'price' => '$34.99', 'image' => 'assets/images/SubCategory/Chrismas/winter-wonderland-flowers-removebg-preview.png'],
                ['name' => 'Movie Crate Treat', 'price' => '$45.99', 'image' => 'assets/images/SubCategory/Chrismas/xmasmoviecratetreat-removebg-preview.png'],
            ],
            'combo-gifts' => [
                ['name' => 'Mega Combo', 'price' => '$59.99', 'image' => 'assets/images/SubCategory/Combo/1.png'],
                ['name' => 'Teddy & Checkers', 'price' => '$39.99', 'image' => 'assets/images/SubCategory/Combo/10.png'],
            ],
            'flower' => [
                ['name' => 'Rose Bouquet', 'price' => '$29.99', 'image' => 'assets/images/SubCategory/Flower/9.png'],
                ['name' => 'Bliss Basket', 'price' => '$49.99', 'image' => 'assets/images/SubCategory/Flower/A-Bliss-Flowers-Basket-removebg-preview.png'],
                ['name' => 'Tulip Arrangement', 'price' => '$39.99', 'image' => 'assets/images/SubCategory/Flower/Product-Photo-7-removebg-preview.png'],
                ['name' => 'Winter Wonderland', 'price' => '$34.99', 'image' => 'assets/images/SubCategory/Flower/winter-wonderland-flowers-removebg-preview.png'],
                ['name' => 'Snowy Bouquet', 'price' => '$44.99', 'image' => 'assets/images/SubCategory/Flower/xsnow24-category-removebg-preview.png'],
            ],
            'personalized' => [
                ['name' => 'Custom Mug', 'price' => '$19.99', 'image' => 'assets/images/SubCategory/Personalized/5.png'],
                ['name' => 'Photo Frame', 'price' => '$24.99', 'image' => 'assets/images/SubCategory/Personalized/7.png'],
                ['name' => 'Passport Cover', 'price' => '$14.99', 'image' => 'assets/images/SubCategory/Personalized/personalized-couple-passport-cover-925924-removebg-preview.png'],
                ['name' => 'Birthday Box', 'price' => '$39.99', 'image' => 'assets/images/SubCategory/Personalized/personalized-delight-birthday-box-5404582-removebg-preview.png'],
            ],
            'valentine-gifts' => [
                ['name' => 'Valentine Cake', 'price' => '$29.99', 'image' => 'assets/images/SubCategory/Valentine\'s/4.png'],
            ],
            // Add generic fallback for other categories using Category images or random product images
            'default' => [
                ['name' => 'Special Gift 1', 'price' => '$49.99', 'image' => 'assets/images/product/2.png'],
                ['name' => 'Special Gift 2', 'price' => '$69.99', 'image' => 'assets/images/product/3.png'],
                ['name' => 'Special Gift 3', 'price' => '$89.99', 'image' => 'assets/images/product/8.png'],
                ['name' => 'Special Gift 4', 'price' => '$99.99', 'image' => 'assets/images/product/4.png'],
            ]
        ];

        // normalize slug to lower case for matching
        $key = strtolower($slug);
        
        $products = $allProducts[$key] ?? $allProducts['default'];

        return view('subcategory', compact('title', 'slug', 'products'));
    }

    public function detail($slug)
    {
         return $this->index($slug);
    }
}
