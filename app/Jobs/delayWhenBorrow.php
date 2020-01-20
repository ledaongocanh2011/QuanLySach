<?php

namespace App\Jobs;

use App\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class delayWhenBorrow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Book
     */
    private $book;

    /**
     * Create a new job instance.
     *
     * @return void
     */
// init $this Use Alt+enter
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if ($this->book->status != Book::DAMUON) {
            $this->book->update([
                'status' => Book::COTHEMUON,
            ]);
        }
        // ghi vao file log
        logger("huy trang thai dang xem");
    }
}
