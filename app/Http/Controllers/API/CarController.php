<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\Attachments;
use App\Models\Car;
use App\Models\CarBooking;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\CarVariant;
use App\Models\StatusTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CarController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return Car::query()->with(['carMake', 'carModel', 'carVariant', 'images', 'carBodyType', 'carCategory'])->get();
            },
            'Cars retrieved successfully',
            'Cars could not be retrieved'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vin' => 'nullable|string|max:255',
            'engine_number' => 'nullable|string|max:255',
            'car_make_id' => 'required|exists:car_makes,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_variant_id' => 'nullable|exists:car_variants,id',
            'car_body_type_id' => 'nullable|exists:car_body_types,id',
            'car_category_id' => 'nullable|exists:car_categories,id',
            'transmission' => 'nullable|in:Manual,Automatic',
            'variant_details' => 'nullable|string',
            'steering_type' => 'nullable|in:LHD,RHD',
            'fuel_type' => 'nullable|in:Petrol,Diesel,Electric',
            'fuel_tank_capacity' => 'nullable|string|max:255',
            'engine_size' => 'required|string|max:255',
            'ext_color' => 'nullable|string|max:255',
            'int_color' => 'nullable|string|max:255',
            'production_year' => 'nullable|string|max:4',
            'mileage' => 'nullable|numeric|min:0',
            'average_on_road' => 'nullable|numeric|min:0',

            // Validating car images nested array (each image has multiple details)
            'car_images' => 'nullable|array|min:1',  // Ensure car_images is an array and has at least one item
            'car_images.*.name' => 'required|string|max:255',
            'car_images.*.is_thumbnail' => 'nullable|boolean',
            'car_images.*.is_thumbnail_interior' => 'nullable|boolean',
            'car_images.*.file' => 'nullable|file|mimes:jpg,jpeg,png',  // File must be an image and max 2MB

            // Specification file validation
//            'car_specification_file' => 'nullable|file|mimes:pdf', // Specification file, max 2MB, PDF format
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                $car = Car::query()->create([
                    ...$request->except(['car_images', 'car_specification_file']),
                    'code' => $this->generateCarCode($request),
                ]);

                // Save car images
                if ($request->has('car_images')) {
                    foreach ($request->car_images as $image) {
                        if ($image['file']) {
                            $imageId = uploadMedia($image['file'], 'car/images/' . $car->slug);
                            $car->images()->create([
                                'name' => $image['name'],
                                'is_thumbnail' => $image['name'] == 'Thumbnail' ?? 0,
                                'is_thumbnail_interior' => 0,
                                'image_id' => $imageId,
                            ]);
                        }

                    }
                }

                if ($request->file('car_specification_file') !== null) {
                    $specificationFileId = uploadMedia($request->file('car_specification_file'), 'car/specification_files');
                    Attachments::query()->create([
                        'name' => 'Car Specification File',
                        'file_id' => $specificationFileId,
                        'attachment_for' => 'car',
                        'source_id' => $car->id,
                        'source_type' => Car::class,
                    ]);
                }

                return $car;
            },
            'Car created successfully',
            'Car could not be created'
        );

    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return $this->doDBTransaction(
            function () use ($car) {
                return Car::query()->with(['carMake', 'carModel', 'carVariant', 'images', 'carBodyType', 'carCategory', 'attachments'])->find($car->id);
            },
            'Car detail retrieved successfully',
            'Car detail could not be retrieved'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vin' => 'nullable|string|max:255',
            'engin_number' => 'nullable|string|max:255',
            'car_make_id' => 'required|exists:car_makes,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_variant_id' => 'nullable|exists:car_variants,id',
            'car_body_type_id' => 'nullable|exists:car_body_types,id',
            'car_category_id' => 'nullable|exists:car_categories,id',
            'transmission' => 'nullable|in:Manual,Automatic',
            'variant_details' => 'nullable|string',
            'steering_type' => 'nullable|in:LHD,RHD',
            'fuel_type' => 'nullable|in:Petrol,Diesel,Electric',
            'fuel_tank_capacity' => 'nullable|string|max:255',
            'engine_size' => 'required|string|max:255',
            'ext_color' => 'nullable|string|max:255',
            'int_color' => 'nullable|string|max:255',
            'production_year' => 'nullable|string|max:4',
            'mileage' => 'nullable|numeric|min:0',
            'average_on_road' => 'nullable|numeric|min:0',

            // Validating car images nested array (each image has multiple details)
            'car_images' => 'nullable|array|min:1',  // Ensure car_images is an array and has at least one item
            'car_images.*.name' => 'required|string|max:255',
            'car_images.*.is_thumbnail' => 'nullable|boolean',
            'car_images.*.is_thumbnail_interior' => 'nullable|boolean',
            'car_images.*.file' => 'nullable|file|mimes:jpg,jpeg,png',  // File must be an image and max 2MB

            // Specification file validation
            'car_specification_file' => 'nullable|file|mimes:pdf', // Specification file, max 2MB, PDF format
        ]);

        return $this->doDBTransaction(
            function () use ($request, $car) {
                // Update car details
                $car->update($request->except(['car_images', 'car_specification_file', 'specificationPreview']));

                // Handle car images
                if ($request->has('car_images')) {
                    // Loop through car images to save/update
                    foreach ($request->car_images as $image) {
                        // Check if file exists for the current image (upload only if a new file is provided)
                        if (isset($image['file']) && $image['file']) {
                            $imageId = uploadMedia($image['file'], 'car/images/' . $car->slug);
                            $car->images()->create([
                                'name' => $image['name'],
                                'is_thumbnail' => $image['name'] == 'Thumbnail' ?? 0,
                                'is_thumbnail_interior' => $image['is_thumbnail_interior'] ?? 0,
                                'image_id' => $imageId,
                            ]);
                        }
                    }
                }

                // Handle removing images (if preview is removed)
                if ($request->has('removed_images')) {
                    foreach ($request->removed_images as $imageId) {
                        // Delete image and its media file
                        $carImage = $car->images()->where('id', $imageId)->first();
                        if ($carImage) {
                            deleteMedia($carImage->image_id); // Function to delete the file from storage
                            $carImage->delete(); // Remove from DB
                        }
                    }
                }

                // Handle specification file upload
                if ($request->file('car_specification_file') !== null) {
                    // Delete old specification file if exists
                    $existingSpec = Attachments::query()
                        ->where('source_id', $car->id)
                        ->where('source_type', Car::class)
                        ->where('name', 'Car Specification File')
                        ->first();

                    if ($existingSpec) {
                        deleteMedia($carImage->image_id);
                        $existingSpec->delete(); // Remove from DB
                    }

                    // Upload and save new specification file
                    $specificationFileId = uploadMedia($request->file('car_specification_file'), 'car/specification_files/' . $car->slug);
                    Attachments::query()->create([
                        'name' => 'Car Specification File',
                        'file_id' => $specificationFileId,
                        'attachment_for' => 'car',
                        'source_id' => $car->id,
                        'source_type' => Car::class,
                    ]);
                }

                return $car;
            },
            'Car updated successfully',
            'Car could not be updated'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        return $this->doDBTransaction(
            function () use ($car) {
                $car->images()->delete();
                $car->attachments()->delete();
                $car->delete();
                return true;
            },
            'Car deleted successfully',
            'Car could not be deleted'
        );
    }

    public function getCarsByBrandSlug(Request $request)
    {
        return $this->doDBTransaction(
            function () use ($request) {
                $query = Car::query();

                // Initialize variables to store car make, model, and variant information
                $carMake = null;
                $carModel = null;
                $carVariant = null;

                $query->when($request->make, function ($q, $make) use (&$carMake) {
                    $carMake = CarMake::query()->where('slug', $make)->first();
                    if ($carMake) {
                        $q->where('car_make_id', $carMake->id);
                    }
                });

                $query->when($request->model, function ($q, $model) use (&$carModel) {
                    $carModel = CarModel::query()->where('slug', $model)->first();
                    if ($carModel) {
                        $q->where('car_model_id', $carModel->id);
                    }
                });

                $query->when($request->variant, function ($q, $variant) use (&$carVariant) {
                    $carVariant = CarVariant::query()->where('slug', $variant)->first();
                    if ($carVariant) {
                        $q->where('car_variant_id', $carVariant->id);
                    }
                });

                $query->when($request->steering, function ($q, $variant) {
                    $q->where('steering_type', $variant);
                });

                $query->when($request->vin, function ($q, $vin) {
                    $q->where('vin', $vin);
                });

                $result = $query->with(['carMake', 'carModel', 'carVariant', 'images', 'carBodyType', 'carCategory', 'attachments'])->paginate(10);

                return [
                    'result' => $result,
                    'car_make' => $carMake,
                    'car_model' => $carModel,
                    'car_variant' => $carVariant
                ];
            },
            'Cars retrieved successfully',
            'Cars could not be retrieved'
        );
    }

    public function getCarsDetailsBySlug($slug)
    {
        return $this->doDBTransaction(
            function () use ($slug) {
                return Car::query()->with(['carMake', 'carModel', 'carVariant', 'images', 'carBodyType', 'carCategory', 'attachments'])->where('slug', $slug)->first();
            },
            'Cars retrieved successfully',
            'Cars could not be retrieved'
        );
    }

    public function bookCar(Car $car)
    {
        return $this->doDBTransaction(
            function () use ($car) {
                $user = auth()->user();

                $carBooking = CarBooking::query()->create([
                    'car_id' => $car->id,
                    'user_id' => $user->id,
                ]);

                StatusTracking::query()->create([
                    'trackable_id' => $carBooking->id,
                    'trackable_type' => CarBooking::class,
                    'status' => StatusEnum::CREATED->value,
                    'comment' => 'Car booking submitted successfully.',
                ]);

                return $carBooking;
            },
            'Car booked successfully',
            'Car booking failed'
        );
    }

    public function generateCarCode($request)
    {
        $steering = substr($request->steering_type, 0, 1);
        match ($request->fuel_type) {
            'Petrol' => $fuel_type = 'P',
            'Diesel' => $fuel_type = 'D',
            'Electric' => $fuel_type = 'EV',
            'Hybrid' => $fuel_type = 'PH',
        };

        $model = CarModel::query()->where('car_make_id', $request->car_make_id)->find($request->car_model_id);
        $model_name = explode(' ', $model->name);
        $model_code = '';
        foreach ($model_name as $name) {
            $model_code .= strtoupper(substr($name, 0, 1));
        }
//        engine
        $engineSize = $request->engine_size;

        $productionYear = $request->production_year ?? 'X';
        return $steering . $model_code . $engineSize . $fuel_type . '-' . $productionYear;
    }
}
