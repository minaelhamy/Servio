<?php

namespace App\Imports;

use App\Models\Service;
use App\Models\ServiceImage;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;

class ImportService implements ToCollection, WithHeadingRow
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

                $item = new Service();
                $item->category_id = $row['category_id'];
                $item->vendor_id = $vendor_id;
                $item->name = $row['service_name'];
                $item->slug = Str::slug($row['service_name'] . ' ', '-') . '-' . Str::random(5);
                $item->price = $row['price'];
                $item->tax = $row['tax'];
                $item->interval_time = $row['interval_time'];
                $item->interval_type = $row['interval_type'];
                $item->per_slot_limit = $row['per_slot_limit'];
                $item->video_url = $row['video_url'];
                $item->staff_assign = $row['staff_assign'];
                $item->staff_id = $row['staff_assign'] == 1 ? $row['staff_id'] : '';
                $item->description = $row['description'];
                $item->is_imported = 1;
                $item->save();
                if ($row['image'] != "" && $row['image'] != null) {
                    $images = explode('|', $row['image']);
                    foreach ($images as $image) {
                        $productimage = new ServiceImage();
                        $url =  strtok($image, '?');
                        $filename = basename($url);
                        $productimage->service_id = $item->id;
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
