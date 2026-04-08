<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductImage;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;

class ImportProduct implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        try {
            if (Auth::user()->type == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            foreach ($rows as $row) {

                $item = new Product();
                $item->vendor_id = $vendor_id;
                $item->category_id = $row['category_id'];
                $item->name = $row['product_name'];
                $item->slug = Str::slug($row['product_name'] . ' ', '-') . '-' . Str::random(5);
                $item->price = $row['selling_price'];
                $item->original_price = $row['original_price'];
                $item->discount_percentage = $row['original_price'] > 0 ? number_format(100 - ($row['selling_price'] * 100) / $row['original_price'], 1) : 0;
                $item->tax = $row['tax'];
                $item->stock_management = $row['stock_management'];
                $item->qty =  $row['stock_management'] == 1 ? $row['qty'] : 0;
                $item->min_order = $row['stock_management'] == 1 ? $row['min_order'] : 0;
                $item->max_order = $row['stock_management'] == 1 ? $row['max_order'] : 0;
                $item->low_qty = $row['stock_management'] == 1 ? $row['low_qty'] : 0;
                $item->video_url = $row['video_url'];
                $item->description = $row['description'];
                $item->is_imported = 1;
                $item->save();
                if ($row['image'] != "" && $row['image'] != null) {
                    $images = explode('|', $row['image']);
                    foreach ($images as $image) {
                        $productimage = new ProductImage();
                        $url =  strtok($image, '?');
                        $filename = basename($url);
                        $productimage->product_id = $item->id;
                        $productimage->image = preg_replace('/\s+/', '', $filename);
                        $productimage->is_imported = 1;
                        $productimage->save();
                    }
                }
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function headingRow(): int
    {
        return 1;
    }
}
