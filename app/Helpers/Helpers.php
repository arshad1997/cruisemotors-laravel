<?php


use App\Models\Car;
use App\Models\CarBodyType;
use App\Models\CarBooking;
use App\Models\CarCategory;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\CarVariant;
use App\Models\Company;
use App\Models\Deal;
use App\Models\Documentation;
use App\Models\DocumentService;
use App\Models\Inquiry;
use App\Models\OfferVehicle;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\Quotation;
use App\Models\SupplyContract;
use App\Models\Tender;
use App\Models\Upload;
use App\Models\VehicleOrder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

if (!function_exists('generateCode')) {
    function generateCode($type): string
    {
        if ($type == 'product') {
            return generateCodePattern($type, 'P', Product::query(), 'code');
        } elseif ($type == 'sub_category') {
            return generateCodePattern($type, 'SC', ProductSubCategory::query(), 'code');
        } elseif ($type == 'category') {
            return generateCodePattern($type, 'C', ProductCategory::query(), 'code');
        } elseif ($type == 'car-make') {
            return generateCodePattern($type, 'CMake', CarMake::query(), 'code');
        } elseif ($type == 'car-model') {
            return generateCodePattern($type, 'CModel', CarModel::query(), 'code');
        } elseif ($type == 'car-variant') {
            return generateCodePattern($type, 'CVariant', CarVariant::query(), 'code');
        } elseif ($type == 'tender') {
            return generateCodePattern($type, 'TD', Tender::query(), 'code');
        } elseif ($type == 'supply-contract') {
            return generateCodePattern($type, 'SC', SupplyContract::query(), 'code');
        } elseif ($type == 'company') {
            return generateCodePattern($type, 'COM', Company::query(), 'code');
        } elseif ($type == 'deal') {
            return generateCodePattern($type, 'DEAL', Deal::query(), 'code');
        } elseif ($type == 'quotation') {
            return generateCodePattern($type, 'QT', Quotation::query(), 'code');
        } elseif ($type == 'payment-method') {
            return generateCodePattern($type, 'PM', PaymentMethod::query(), 'code');
        } elseif ($type == 'inquiry') {
            return generateCodePattern($type, 'INQ', Inquiry::query(), 'code');
        } elseif ($type == 'order-vehicle') {
            return generateCodePattern($type, 'VO', VehicleOrder::query(), 'code');
        } elseif ($type == 'offer-vehicle') {
            return generateCodePattern($type, 'OV', OfferVehicle::query(), 'code');
        } elseif ($type == 'car') {
            return generateCodePattern($type, 'CAR', Car::query(), 'code');
        } elseif ($type == 'car-category') {
            return generateCodePattern($type, 'CC', CarCategory::query(), 'code');
        } elseif ($type == 'car-body-type') {
            return generateCodePattern($type, 'CBT', CarBodyType::query(), 'code');
        } elseif ($type == 'document-service') {
            return generateCodePattern($type, 'DS', DocumentService::query(), 'code');
        } elseif ($type == 'documentation') {
            return generateCodePattern($type, 'DaC', Documentation::query(), 'code');
        } elseif ($type == 'car-booking') {
            return generateCodePattern($type, 'BaC', CarBooking::query(), 'code');
        }
        return '';
    }
}

if (!function_exists('generateCodePattern')) {
    function generateCodePattern($type, $prefix, $modal, $column): string
    {
        $record = $modal->orderBy('created_at', 'desc')->orderBy('id', 'desc')->withTrashed()->first();
        if ($record) {
            $lastId = explode('-', $record->{$column});
            $year = substr($lastId[1], 0, 2);
            $month = $lastId[2];
            $sequence = intval($lastId[3]);
            $currentYear = date('y');
            $currentMonth = date('m');
            if ($year == $currentYear && $month == $currentMonth) {
                $newSequence = $sequence + 1;
                $sequenceFormatted = str_pad($newSequence, 3, '0', STR_PAD_LEFT);
                $code = "$prefix-$currentYear-$currentMonth-$sequenceFormatted";
            } else {
                $sequenceFormatted = str_pad(1, 3, '0', STR_PAD_LEFT);
                $code = "$prefix-$currentYear-$currentMonth-$sequenceFormatted";
            }
        } else {
            $currentYear = date('y');
            $currentMonth = date('m');
            $sequenceFormatted = str_pad(1, 3, '0', STR_PAD_LEFT);
            $code = "$prefix-$currentYear-$currentMonth-$sequenceFormatted";
        }
        return $code;
    }
}


if (!function_exists('uploadMedia')) {
    function uploadMedia($file, $path)
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $nameWithoutExtension = str_replace('.' . $extension, '', $originalName);
        $slugName = Str::slug($nameWithoutExtension, '_');
        $fileName = time() . '_' . $slugName . '.' . $extension;
        $publicPath = public_path('uploads');
        if (!File::exists($publicPath)) {
            File::makeDirectory($publicPath, 0775, true); // creates directory
        }
        $uploadedFile = $file->move($publicPath . '/' . $path, $fileName);
        $dbPath = 'uploads' . '/' . $path . '/' . $fileName;

        $fInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fInfo, $uploadedFile->getRealPath());
        finfo_close($fInfo);
        $fileSize = filesize($uploadedFile->getRealPath());

        $upload = new Upload();
        $upload->original_name = $originalName;
        $upload->new_name = $fileName;
        $upload->path = $dbPath;
        $upload->size = $fileSize;
        $upload->extension = $extension;
        $upload->type = $mimeType;
        $upload->save();

        return $upload->id;

    }
}

if (!function_exists('deleteMedia')) {
    /**
     * Delete media file from the storage and the database.
     *
     * @param int $fileId The ID of the file to delete.
     * @return bool Returns true if the file was successfully deleted, false otherwise.
     */
    function deleteMedia($fileId)
    {
        // Find the file in the database
        $file = Upload::query()->find($fileId);

        // Check if file exists
        if (!$file) {
            return false; // File not found
        }

        // Get the full path of the file
        $filePath = public_path($file->path);

        // Check if the file exists on the filesystem
        if (File::exists($filePath)) {
            // Delete the file from the filesystem
            File::delete($filePath);
        }

        // Remove the file record from the database
        $file->delete();

        return true; // File deleted successfully
    }
}
