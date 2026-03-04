<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mpdf\Mpdf;

class PinjamanController extends Controller
{
    /**
     * Tampilkan daftar pinjaman
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'ALL');

        $loans = ($status === 'ALL')
            ? Loan::latest()->get()
            : Loan::where('status', $status)
                ->latest()
                ->get();

        return view('admin.pinjaman', [
            'loans' => $loans,
            'status' => $status,
            'adminName' => session('admin_name', 'Admin')
        ]);
    }

    /**
     * Approve pinjaman
     */
    public function approve($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'MENUNGGU') {
            return back();
        }

        $loan->update([
            'status' => 'DISETUJUI'
        ]);

        return back()->with('success', 'Pinjaman disetujui');
    }

    /**
     * Reject pinjaman
     */
    public function reject(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'MENUNGGU') {
            return back();
        }

        $loan->update([
            'status' => 'DITOLAK',
            'catatan_admin' => $request->input('catatan')
        ]);

        return back()->with('success', 'Pinjaman ditolak');
    }

    /**
     * Detail pinjaman
     */
    public function show($id)
    {
        $loan = Loan::findOrFail($id);

        return view('admin.pinjaman-detail', [
            'loan' => $loan,
            'adminName' => session('admin_name', 'Admin')
        ]);
    }

    /**
     * Cetak PDF pinjaman
     */
    public function cetakPdf($id): Response
    {
        $loan = Loan::findOrFail($id);
        $profile = $this->getBorrowerProfile($loan);
        $user = (object) [
            'name' => $profile['nama'] ?? '-',
            'nip' => $profile['nip'] ?? '-',
            'unit_kerja' => $profile['unit_kerja'] ?? '-',
            'gaji' => $profile['gaji'] ?? 0,
        ];

        $html = view('admin.pinjaman-pdf', [
            'loan' => $loan,
            'admin' => session('admin_name', 'Admin'),
            'profile' => $profile,
            'user' => $user,
        ])->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4'
        ]);

        $mpdf->WriteHTML($html);

        $pdfContent = $mpdf->Output('', 'S');

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header(
                'Content-Disposition',
                'inline; filename="Surat-Pinjaman-' . $loan->kode . '.pdf"'
            );
    }

    /**
     * Print langsung tanpa simpan PDF
     */
    public function print($id)
    {
        $loan = Loan::findOrFail($id);
        $profile = $this->getBorrowerProfile($loan);
        $user = (object) [
            'name' => $profile['nama'] ?? '-',
            'nip' => $profile['nip'] ?? '-',
            'unit_kerja' => $profile['unit_kerja'] ?? '-',
            'gaji' => $profile['gaji'] ?? 0,
        ];

        return view('admin.pinjaman-print', [
            'loan' => $loan,
            'profile' => $profile,
            'user' => $user,
        ]);
    }

    private function getBorrowerProfile(Loan $loan): array
    {
        $profile = [
            'nama' => $loan->nama_peminjam ?? '-',
            'nip' => '-',
            'unit_kerja' => '-',
            'gaji' => null,
        ];

        if (!Schema::hasTable('users')) {
            return $profile;
        }

        $nameColumn = null;
        if (Schema::hasColumn('users', 'nama')) {
            $nameColumn = 'nama';
        } elseif (Schema::hasColumn('users', 'name')) {
            $nameColumn = 'name';
        }

        if ($nameColumn === null || empty($loan->nama_peminjam)) {
            return $profile;
        }

        $query = DB::table('users')->where($nameColumn, $loan->nama_peminjam);
        $select = [$nameColumn . ' as nama'];

        if (Schema::hasColumn('users', 'nip')) {
            $select[] = 'nip';
        }
        if (Schema::hasColumn('users', 'unit_kerja')) {
            $select[] = 'unit_kerja';
        }
        if (Schema::hasColumn('users', 'gaji')) {
            $select[] = 'gaji';
        }

        $user = $query->select($select)->first();
        if (!$user) {
            return $profile;
        }

        $profile['nama'] = $user->nama ?? $profile['nama'];
        $profile['nip'] = $user->nip ?? $profile['nip'];
        $profile['unit_kerja'] = $user->unit_kerja ?? $profile['unit_kerja'];
        $profile['gaji'] = $user->gaji ?? $profile['gaji'];

        return $profile;
    }

    /**
     * Riwayat pinjaman user
     */
    public function riwayatUser($id)
{
    $user = \App\Models\User::findOrFail($id);

    $loans = Loan::where('nama_peminjam', $user->nama)
        ->latest()
        ->get();

    return view('admin.user-pinjaman',[
        'nama' => $user->nama,
        'loans' => $loans,
        'adminName' => session('admin_name','Admin')
    ]);
}

}
