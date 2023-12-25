<?php

namespace App\Utils;
use App\Models\Product;
use App\Models\Setting;

class ZplUtils {
    private static function generateSingleZplCode(Product $product, string $print_layout) {
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

    public static function generateZplCode(Product $product): ?string {
        $print_layout = Setting::where('name', 'print_layout')->first()?->value;
        if (!$print_layout) {
            return null;
        }
        $zpl_code = '';
        for ($i = 0; $i < $product->quantity; $i++) {
            $zpl_code .= self::generateSingleZplCode($product, $print_layout);
        }

        return $zpl_code;
    }

    public static function idToHex($id) {
        return 'DKNCK>5' . explode('DKNCK', $id)[1];
    }

    public static function priceEncode($price) {
        return rand(100, 999) . $price * 2;
    }
}