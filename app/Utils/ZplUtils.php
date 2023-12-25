<?php

namespace App\Utils;
use App\Models\Product;
use App\Models\Setting;

class ZplUtils {
    public static function generateSingleZplCode(Product $product) {
        $print_layout = Setting::where('name', 'print_layout')->first()?->value;

        foreach ($product->getAttributes() as $key => $value) {
            if ($key == 'id') {
                $value = sprintf('DKNCK%08d', $value);
                $print_layout = str_replace('::ID_HEX::', self::idToHex($value), $print_layout);
            }
            if ($key == 'unit_price_buying') {
                $value = self::priceEncode($value);
            }
            $print_layout = str_replace("::" . strtoupper($key) . "::", $value, $print_layout);
        }

        return $print_layout;
    }

    public static function generateZplCode(Product $product) {
        $print_layout = '';
        for ($i = 0; $i < $product->quantity; $i++) {
            $print_layout .= self::generateSingleZplCode($product);
        }

        return $print_layout;
    }

    public static function idToHex($id) {
        return 'DKNCK>5' . explode('DKNCK', $id)[1];
    }

    public static function priceEncode($price) {
        return rand(100, 999) . $price * 2;
    }
}