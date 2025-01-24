<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Services\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery\MockInterface;
use Tests\Feature\Traits\SetupTrait;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use SetupTrait;

    public function test_it_creates_product_with_valid_data()
    {
        Storage::fake('public');

        $fileName = 'test.png';
        $file = UploadedFile::fake()->image($fileName);
        $title = 'Test Product';
        $slug = Str::slug($title);

        $filePath =  "{$slug}/{$fileName}";

        $productData = [
            'title' => $title,
            'SKU' => 'asjfhj124',
            'description' => '-',
            'price' => 100,
            'discount' => 15,
            'quantity' => 20,
            'thumbnail' => $file,
        ];

        $this->mock(
            FileServiceContract::class,
            function (MockInterface $mock) use ($filePath) {
                $mock->shouldReceive('upload')
                    ->andReturn($filePath);
            }
        );

        $this->assertDatabaseMissing('products', [
            'slug' => $slug,
        ]);

        $response = $this->actingAs($this->user())
            ->post(route('admin.products.store'), $productData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('products', [
            'slug' => $slug,
            'SKU' => $productData['SKU'],
        ]);
    }
}
