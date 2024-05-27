<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service';

    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path("Services/{$name}.php");

        if (File::exists($servicePath)) {
            $this->error('Service already exists!');
            return;
        }

        File::put($servicePath, $this->generateServiceStub($name));

        $this->info("Service {$name} created successfully!");
    }

    private function generateServiceStub($name)
    {
        return "<?php\n\nnamespace App\Services;\n\nuse Illuminate\Support\Facades\Log;\n\nclass {$name}\n{\n    // Your service logic here\n}\n";
    }
}
