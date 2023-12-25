<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Utils\ZplUtils;
use Illuminate\Http\Request;

class ZplCodeController extends Controller {
    

    public function form(Request $request) {

        return view('admin.zpl.printer');
    }
    
    public function generateStatic(Request $req) {
        $data = $req->validate([
            'id' => 'required|string',
            'name' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
        ]);
        $zpl  = ZplUtils::generateZplCode(new Product($data));
        return $this->backToForm('Printed successfully!')->with('zpl-code', $zpl);
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
