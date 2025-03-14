<?php

namespace App\Jobs\Admin\Products\Export;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Writer;
use Throwable;

class SaveToS3Job implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $userId)
    {
        $this->onQueue('products-export');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Storage::delete("export/combined_$this->userId.csv");
            $files = Storage::disk('local')->allFiles('export');

            $csv = Writer::createFromString('');
            $csv->setDelimiter(';');

            $csv->insertOne([
                'id',
                'slug',
                'title',
                'SKU',
                'description',
                'price',
                'discount',
                'quantity',
                'thumbnail',
                'created_at',
                'updated_at',
            ]);

            foreach ($files as $file) {
                $content = Storage::disk('local')->get($file);
                $reader = Reader::createFromString($content)->setDelimiter(';');
                $csv->insertAll($reader->getRecords());
                Storage::disk('local')->delete($file);
            }

            Storage::put("export/combined_$this->userId.csv", $csv->toString());
        } catch (Throwable $th) {
            logs()->error("[ProductsExportJob] error: {$th->getMessage()}");
        }
    }
}
