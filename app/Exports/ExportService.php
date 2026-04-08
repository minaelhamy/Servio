<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;


class ExportService implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        return Service::with('multi_image')->where('vendor_id', $vendor_id)->orderBy('reorder_id')->get();
    }
    public function map($item): array
    {

        $newimages = [];
        if (!empty($item->multi_image)) {
            foreach ($item->multi_image as $image) {
                $newimages[] = $image->image;
            }
        }
        return [
            $item->category_id,
            $item->name,
            $item->price,
            $item->tax,
            implode('|', $newimages),
            $item->interval_time,
            $item->interval_type,
            $item->per_slot_limit,
            $item->video_url,
            $item->staff_assign,
            $item->staff_id,
            $item->description,
        ];
    }
    public function headings(): array
    {
        return [
            'category_id',
            'service_name',
            'price',
            'tax',
            'image',
            'time_slot_interval',
            'interval_type',
            'per_slot_booking_limit',
            'video_url',
            'staff_assign',
            'staff_id',
            'description',
        ];
    }
}
