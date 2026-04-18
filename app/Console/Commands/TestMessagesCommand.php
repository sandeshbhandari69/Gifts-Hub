<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestMessagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-messages-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Messages System...');
        
        // Test Message model
        try {
            $count = \App\Models\Message::count();
            $this->info("Total messages in database: {$count}");
            
            if ($count > 0) {
                $messages = \App\Models\Message::orderBy('created_at', 'desc')->get();
                foreach ($messages as $message) {
                    $this->info("ID: {$message->id} - From: {$message->first_name} {$message->last_name} - Subject: {$message->subject} - Read: " . ($message->read ? 'Yes' : 'No'));
                }
            } else {
                $this->info('No messages found in database');
                
                // Create test message
                $testMessage = \App\Models\Message::create([
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'email' => 'test@example.com',
                    'subject' => 'Test Subject',
                    'message' => 'This is a test message',
                    'read' => false
                ]);
                $this->info("Created test message with ID: {$testMessage->id}");
            }
        } catch (\Exception $e) {
            $this->error("Error testing Message model: " . $e->getMessage());
        }
        
        // Test ContactController
        try {
            $controller = new \App\Http\Controllers\AdminController();
            $this->info('AdminController instantiated successfully');
        } catch (\Exception $e) {
            $this->error("Error with AdminController: " . $e->getMessage());
        }
        
        return Command::SUCCESS;
    }
}
