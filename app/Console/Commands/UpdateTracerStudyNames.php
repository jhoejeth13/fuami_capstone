<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TracerStudyResponse;

class UpdateTracerStudyNames extends Command
{
    protected $signature = 'tracer:update-names';
    protected $description = 'Update name fields in tracer study responses from fullname field';

    public function handle()
    {
        $responses = TracerStudyResponse::whereNull('first_name')
            ->orWhereNull('last_name')
            ->get();

        $bar = $this->output->createProgressBar(count($responses));
        $bar->start();

        foreach ($responses as $response) {
            if (empty($response->first_name) && !empty($response->fullname)) {
                $nameParts = explode(' ', $response->fullname);
                
                // Basic name parsing (you might need to adjust this based on your data)
                $response->first_name = $nameParts[0] ?? null;
                $response->last_name = end($nameParts) ?? null;
                
                if (count($nameParts) > 2) {
                    $response->middle_name = implode(' ', array_slice($nameParts, 1, -1));
                }
                
                $response->save();
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Successfully updated ' . count($responses) . ' records.');
    }
} 