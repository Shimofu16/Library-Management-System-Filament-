<?php

namespace App\Observers;

use App\Models\BorrowedBook;
use Carbon\Carbon;

class BorrowedBookObserver
{
    /**
     * Handle the BorrowedBook "created" event.
     */
    public function created(BorrowedBook $borrowedBook): void
    {
        //
    }

    /**
     * Handle the BorrowedBook "updated" event.
     */
    public function updated(BorrowedBook $borrowedBook): void
    {
        if ($borrowedBook->isDirty('is_returned') && $borrowedBook->is_returned) {
            $borrowedBook->returned_date = Carbon::now();
            $borrowedBook->save();
        }
    }

    /**
     * Handle the BorrowedBook "deleted" event.
     */
    public function deleted(BorrowedBook $borrowedBook): void
    {
        //
    }

    /**
     * Handle the BorrowedBook "restored" event.
     */
    public function restored(BorrowedBook $borrowedBook): void
    {
        //
    }

    /**
     * Handle the BorrowedBook "force deleted" event.
     */
    public function forceDeleted(BorrowedBook $borrowedBook): void
    {
        //
    }

    public static function register()
    {
        $observer = new static;
        BorrowedBook::observe($observer);
    }   
}
