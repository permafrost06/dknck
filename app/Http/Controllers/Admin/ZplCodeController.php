<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Utils\ZplUtils;
use Illuminate\Http\Request;

class ZplCodeController extends Controller {
    

    public function form(Request $request) {

        return view('admin.products.zpl-printer');
    }
    
    public function generateStatic(Request $req) {
        return [];
    }

    public function generate(Request $req, int $id) {
        $product = Product::find($id);
        if (!$product) {
            return [
                "data" => null,
                "error" => "Invalid product id!"
            ];
        }

        $print_layout = ZplUtils::generateZplCode($product);

        return [
            "data" => $print_layout
        ];
    }

}
