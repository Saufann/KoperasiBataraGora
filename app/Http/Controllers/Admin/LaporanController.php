<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class LaporanController extends Controller
{
    /**
     * Halaman utama laporan
     */
    public function index()
    {
        return view('admin.laporan', [
            'adminName' => session('admin_name', 'Admin')
        ]);
    }

    /**
     * Data chart (AJAX)
     */
    public function data(Request $request)
    {
        $type = $request->query('type', 'bulan');

        // ===============================
        // HARIAN
        // ===============================
        if ($type === 'hari') {

            $data = DB::table('orders')
                ->selectRaw("
                    DATE(created_at) as label,
                    SUM(total) as total
                ")
                ->where('status', 'SELESAI')
                ->groupBy('label')
                ->orderBy('label', 'asc')
                ->get();
        }

        // ===============================
        // TAHUNAN
        // ===============================
        elseif ($type === 'tahun') {

            $data = DB::table('orders')
                ->selectRaw("
                    YEAR(created_at) as label,
                    SUM(total) as total
                ")
                ->where('status', 'SELESAI')
                ->groupBy('label')
                ->orderBy('label', 'asc')
                ->get();
        }

        // ===============================
        // BULANAN (DEFAULT)
        // ===============================
        else {

            $data = DB::table('orders')
                ->selectRaw("
                    DATE_FORMAT(created_at,'%Y-%m') as ym,
                    DATE_FORMAT(created_at,'%b %Y') as label,
                    SUM(total) as total
                ")
                ->where('status', 'SELESAI')
                ->groupBy('ym', 'label')
                ->orderBy('ym', 'asc')
                ->limit(6)
                ->get();
        }

        return response()->json($data);
    }

    /**
     * Export PDF laporan keuangan
     */
    public function exportPdf(Request $request)
    {
        $type = $request->input('type', 'bulan');

        // HARIAN

        if ($type === 'hari') {

            $judul = 'Laporan Keuangan Harian';

            $rows = DB::table('orders')
                ->selectRaw("
                    DATE(created_at) as label,
                    SUM(total) as total
                ")
                ->where('status', 'SELESAI')
                ->groupBy('label')
                ->orderBy('label', 'asc')
                ->get();
        }

        // TAHUNAN

        elseif ($type === 'tahun') {

            $judul = 'Laporan Keuangan Tahunan';

            $rows = DB::table('orders')
                ->selectRaw("
                    YEAR(created_at) as label,
                    SUM(total) as total
                ")
                ->where('status', 'SELESAI')
                ->groupBy('label')
                ->orderBy('label', 'asc')
                ->get();
        }

        // BULANAN

        else {

            $judul = 'Laporan Keuangan Bulanan';

            $rows = DB::table('orders')
                ->selectRaw("
                    DATE_FORMAT(created_at,'%Y-%m') as ym,
                    DATE_FORMAT(created_at,'%M %Y') as label,
                    SUM(total) as total
                ")
                ->where('status', 'SELESAI')
                ->groupBy('ym', 'label')
                ->orderBy('ym', 'asc')
                ->limit(6)
                ->get();
        }

        // Render HTML view

        $html = view('admin.laporan-pdf', [
            'judul' => $judul,
            'rows' => $rows,
            'admin' => session('admin_name', 'Admin'),
            'type' => $type,
        ])->render();

        // Generate PDF

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4'
        ]);

        $mpdf->WriteHTML($html);

        $pdfContent = $mpdf->Output('', 'S');

        // Return PDF Response

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header(
                'Content-Disposition',
                'inline; filename="laporan-keuangan.pdf"'
            );
    }
}
