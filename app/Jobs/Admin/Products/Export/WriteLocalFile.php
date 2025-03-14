<?php

namespace App\Jobs\Admin\Products\Export;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use Throwable;

class WriteLocalFile implements ShouldQueue
{
    use Batchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $fileName, protected array $productsIds = [])
    {
        $this->onQueue('products-export');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        logs()->info("[ProductsExportJob] dispatch!");
        try {
            $fileName = "export/{$this->fileName}";
            if (!Storage::disk('local')->exists($fileName)) {
                Storage::disk('local')->put($fileName, '');
            }

            $csv = Writer::createFromPath(
                storage_path("app/private/$fileName"),
                'a+'
            );

            $csv->setDelimiter(';');

            Product::query()
                ->with(['images', 'categories'])
                ->whereIn('id', $this->productsIds)
                ->chunk(10, function (Collection $products) use ($csv) {
                    $csv->insertAll($products->toArray());
                });
        } catch (Throwable $th) {
            logs()->error("[WriteLocalFile] error: {$th->getMessage()}");
            $this->batch()->cancel();
        }
    }
}
