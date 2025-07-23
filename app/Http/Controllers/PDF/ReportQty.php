<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportQty extends Controller
{
    public function download() {
        $data = [
            [
                'quantity' => 1,
                'description' => '1 Year Subscription',
                'price' => '129.00'
            ]
        ];
     
        $pdf = Pdf::loadView('pdf', ['data' => $data]);
     
        return $pdf->download();
    }
}
