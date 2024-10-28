<?php

namespace Tests\Feature;

use App\Jobs\ProcessProductImage;
use App\Models\Product;
use App\Services\SpreadsheetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SpreadsheetServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testProcessSpreadsheet()
    {
        // Mock the importer service
        $importerMock = $this->mock('importer');
        $importerMock->shouldReceive('import')
            ->once()
            ->andReturn([
                ['product_code' => 'ABC123', 'quantity' => 10],
                ['product_code' => 'XYZ789', 'quantity' => 5],
            ]);

        // Mock the queue
        Queue::fake();

        // Create an instance of the service
        $service = new SpreadsheetService();

        // Call the method
        $service->processSpreadsheet('path/to/test_spreadsheet.csv');

        // Assert that products were created
        $this->assertDatabaseHas('products', [
            'code' => 'ABC123',
            'quantity' => 10,
        ]);

        $this->assertDatabaseHas('products', [
            'code' => 'XYZ789',
            'quantity' => 5,
        ]);

        // Assert that the job was dispatched
        Queue::assertPushed(ProcessProductImage::class, 2);
    }
}
