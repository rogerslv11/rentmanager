<?php

namespace App\Actions\Property;

use App\Models\Property;
use Illuminate\Support\Facades\DB;

class CreatePropertyAction
{
    public function execute(array $data): Property
    {
        return DB::transaction(function () use ($data) {
            $property = Property::create($data);

            if (! empty($data['owner_id']) && ! empty($data['ownership_percent'])) {
                $property->owners()->attach($data['owner_id'], [
                    'ownership_percent' => $data['ownership_percent'],
                ]);
            } elseif (! empty($data['owner_id'])) {
                $property->owners()->attach($data['owner_id'], [
                    'ownership_percent' => 100,
                ]);
            }

            if (! empty($data['photos'])) {
                foreach ($data['photos'] as $i => $photoPath) {
                    $property->photos()->create([
                        'path' => $photoPath,
                        'is_cover' => $i === 0,
                        'sort_order' => $i,
                    ]);
                }
            }

            return $property;
        });
    }
}
