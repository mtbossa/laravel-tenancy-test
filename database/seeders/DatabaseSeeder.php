<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->deleteTenantSchemas();

         \App\Models\User::factory(5)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 't@t',
         ]);

        \App\Models\Tenant::create();
        \App\Models\Tenant::create();

        \App\Models\Tenant::all()->runForEach(function () {
            \App\Models\User::factory(5)->create();
        });
    }

    private function deleteTenantSchemas() {
        $schemas = DB::select("SELECT schema_name FROM information_schema.schemata");

        $tenantSchemas = Collection::make($schemas)
            ->map(fn (\stdClass $schema) => $schema->schema_name)
            ->filter(fn (string $schema_name) => Str::of($schema_name)->before('_') == 'tenant');

        foreach ($tenantSchemas as $tenantSchema) {
            DB::statement("drop schema \"$tenantSchema\" cascade");
        }

    }
}
