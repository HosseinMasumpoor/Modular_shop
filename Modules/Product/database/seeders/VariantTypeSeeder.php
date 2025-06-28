<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Product\Models\ProductVariantType;
use Modules\Product\Models\ProductVariantTypeValue;

class VariantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $variantTypes = [
             'size' => [
                 'SM',
                 'MD',
                 'LG',
                 'XL',
                 '2XL',
                 '3XL'
             ],
             'color' => [
                 '#000000' => 'Black',
                 '#FFFFFF' => 'White',
                 '#FF0000' => 'Red',
                 '#008000' => 'Green',
                 '#0000FF' => 'Blue',
                 '#FFFF00' => 'Yellow',
                 '#FFA500' => 'Orange',
                 '#FFC0CB' => 'Pink',
                 '#800080' => 'Purple',
                 '#A52A2A' => 'Brown',
                 '#808080' => 'Gray',
                 '#000080' => 'Navy',
                 '#00FFFF' => 'Cyan',
                 '#008080' => 'Teal',
                 '#F5F5DC' => 'Beige',
                 '#800000' => 'Maroon',
                 '#808000' => 'Olive',
                 '#00FF00' => 'Lime',
                 '#4B0082' => 'Indigo',
                 '#FFD700' => 'Gold',
             ],
         ];

         foreach ($variantTypes as $variantName => $variantValues) {
             $variantType = ProductVariantType::create([
                 'name' => $variantName,
                 'slug' => Str::slug($variantName),
             ]);

             $order = 0;
             foreach ($variantValues as $key => $variantValue) {
                 $order++;
                 $data = [
                     'variant_type_id' => $variantType->id,
                     'value' => $variantValue,
                     'slug' => $variantType->slug . '-' . Str::slug($variantValue),
                     'order' => $order
                 ];

                 if($variantName == 'color')
                 {
                     $data['meta'] = ['color' => $key];
                 }

                 ProductVariantTypeValue::create($data);
             }
         }
    }
}
