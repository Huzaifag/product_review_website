<?php

namespace App\Exports;

use App\Models\NewsletterSubscriber;
use Maatwebsite\Excel\Concerns\FromCollection;

class NewsletterSubscribersExport implements FromCollection
{
    public function collection()
    {
        return NewsletterSubscriber::select('email')->get();
    }
}