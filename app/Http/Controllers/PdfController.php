<?php

namespace App\Http\Controllers;

use App\Models\Dosenpa;
use App\Models\Rating;
use Illuminate\Http\Request;

use App\Models\Tanggapan;
class PdfController extends Controller
{
    //
    public function exportpdf()
    {


        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(view('dashboard.tanggapan.admin.exportpdf', [
            'tanggapan' => Tanggapan::all()
        ])->render());
        $mpdf->Output();
    }

    public function exportrating()
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(view('dashboard.rating.admin.exportpdf', [
            'dosenpa' => Dosenpa::all()
        ])->render());
        $mpdf->Output();
    }

    public function exportratingall()
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(view('dashboard.rating.admin.exportpdfall', [
            'ratings' => Rating::all()
        ])->render());
        $mpdf->Output();
    }
}
