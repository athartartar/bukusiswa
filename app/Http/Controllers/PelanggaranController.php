<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\Pembinaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class PelanggaranController extends Controller
{
    private static $notifSudahTerkirim = false;
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswas,id_siswa',
            'jenis_pelanggaran' => 'required|string',
            'poin' => 'required|integer',
            'keterangan' => 'nullable|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $dicatatOleh = Auth::check() ? (Auth::user()->namalengkap ?? Auth::user()->username) : 'admin';

        $data = [
            'id_siswa' => $request->id_siswa,
            'tanggal' => now()->format('Y-m-d'),
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan,
            'dicatat_oleh' => $dicatatOleh
        ];

        if ($request->hasFile('bukti_foto')) {
            $data['bukti_foto'] = $request->file('bukti_foto')->store('bukti', 'public');
        }

        // 1. Simpan Pelanggaran
        $pelanggaran = Pelanggaran::create($data);

        // 2. Update Total Poin
        $totalPoin = $this->updateTotalPoin($request->id_siswa);

        $is_last = $request->input('is_last', 0);

        // PASANG CCTV: Catat di log setiap kali data masuk
        \Log::info("Data masuk: {$request->jenis_pelanggaran} | is_last nilainya: {$is_last}");

        // 3. JIKA INI REQUEST TERAKHIR
        if ($is_last == 1 || $is_last == '1') {
            $siswa = Siswa::find($request->id_siswa);
            $targetRole = $totalPoin < 20 ? 'walas' : 'bk';
            $tokens = \App\Models\User::where('usertype', $targetRole)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            \Log::info("Mencoba kirim notif ke Role: {$targetRole}. Jumlah Token HP yg aktif: " . count($tokens));

            if (count($tokens) > 0) {
                $this->kirimNotifKeRole($tokens, $siswa->namalengkap, $totalPoin, $targetRole);
                \Log::info("Notif berhasil ditembakkan ke Firebase!");
            }

            // PERBAIKAN: Kirim kembali total_poin terbarunya
            return response()->json([
                'success' => true,
                'total_poin' => $totalPoin, // <--- TAMBAHAN INI
                'swal_konfirmasi' => [
                    'title' => 'Tercatat!',
                    'text'  => "Total {$totalPoin} Poin Pelanggaran telah masuk ke sistem.",
                    'icon'  => 'success'
                ]
            ], 201);
        }

        // Kalau bukan request terakhir, kirim sukses dan total poin juga
        return response()->json(['success' => true, 'total_poin' => $totalPoin], 201);
    }
    private function kirimNotifDenganJeda($id_siswa)
    {
        $lockKey = 'notif_execution_lock_' . $id_siswa;

        // Jika tidak sedang dalam proses "menunggu", buat proses baru
        if (!\Illuminate\Support\Facades\Cache::has($lockKey)) {
            \Illuminate\Support\Facades\Cache::put($lockKey, true, 2); // Lock 2 detik

            // Beri jeda 1 detik agar semua request Livewire masuk dulu ke database
            usleep(1000000);

            $data = \Illuminate\Support\Facades\Cache::get('pending_notif_' . $id_siswa);
            if ($data) {
                $tokens = \App\Models\User::where('usertype', $data['role'])
                    ->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

                if (count($tokens) > 0) {
                    $this->kirimNotifKeRole($tokens, $data['nama'], $data['total'], $data['role']);
                }
                \Illuminate\Support\Facades\Cache::forget('pending_notif_' . $id_siswa);
            }
            \Illuminate\Support\Facades\Cache::forget($lockKey);
        }
    }
    public function riwayat($id_siswa)
    {
        $user = Auth::user();

        if ($user && strtolower(trim($user->usertype)) === 'siswa') {
            $siswa = Siswa::where('id_user', $user->id_user)->first();

            if (!$siswa || $siswa->id_siswa != $id_siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda hanya bisa melihat riwayat pelanggaran Anda sendiri'
                ], 403);
            }
        }

$pelanggaran = Pelanggaran::where('id_siswa', $id_siswa)->get()->map(function ($item) use ($user) {
            $canDelete = false;
            if ($user) {
                if ($user->usertype === 'admin') {
                    $canDelete = true;
                } else {
                    $userName = $user->namalengkap ?? $user->username;
                    if ($item->dicatat_oleh === $userName) {
                        $canDelete = true;
                    }
                }
            }

            return [
                'id' => $item->id_pelanggaran,
                'type' => 'pelanggaran',
                'judul' => $item->jenis_pelanggaran,
                'poin' => $item->poin,
                'keterangan' => $item->keterangan,
                'aktor' => $item->dicatat_oleh,
                'bukti_foto' => $item->bukti_foto,
                'tanggal' => $item->created_at,
                'can_delete' => $canDelete
            ];
        });

        $pembinaan = \App\Models\Pembinaan::where('id_siswa', $id_siswa)
            ->where('tindakan', 'not like', '%SP %')
            ->get()->map(function ($item) {
            return [
                'id' => $item->id_pembinaan,
                'type' => 'pembinaan',
                'judul' => $item->tindakan,
                'poin' => $item->pengurangan_poin,
                'keterangan' => $item->feedback,
                'aktor' => $item->dibina_oleh,
                'bukti_foto' => null,
                'tanggal' => $item->created_at,
                'can_delete' => false
            ];
        });

        $riwayat = $pelanggaran->concat($pembinaan)->sortByDesc('tanggal')->values();

        return response()->json($riwayat);
    }

    private function updateTotalPoin($id_siswa)
    {
        try {
            $siswa = Siswa::where('id_siswa', $id_siswa)->first();
            $totalPoin = 0;

            if ($siswa) {
                $poinPelanggaran = Pelanggaran::where('id_siswa', $id_siswa)->sum('poin');
                $poinPengurangan = Pembinaan::where('id_siswa', $id_siswa)->sum('pengurangan_poin');
                
                $totalPoin = $poinPelanggaran - $poinPengurangan;
                
                if ($totalPoin < 0) {
                    $totalPoin = 0;
                }

                if (isset($siswa->total_poin) || array_key_exists('total_poin', $siswa->getAttributes())) {
                    $siswa->update(['total_poin' => $totalPoin]);
                }
            }

            // Return total poin agar bisa dicek di method store
            return $totalPoin;
        } catch (\Exception $e) {
            \Log::info('Total poin tidak diupdate: ' . $e->getMessage());
            return 0;
        }
    }

    // Fungsi khusus untuk mengirim Notifikasi FCM
    private function kirimNotifKeRole($tokens, $namaSiswa, $totalPoin, $targetRole)
    {
        try {
            $credentialsPath = base_path(env('FIREBASE_CREDENTIALS', 'storage/app/firebase-auth.json'));

            if (!file_exists($credentialsPath)) {
                return;
            }

            $firebase = (new Factory)->withServiceAccount($credentialsPath);
            $messaging = $firebase->createMessaging();

            $roleLabel = strtoupper($targetRole);

            // 1. Buat pesannya DULU pakai CloudMessage biasa (tanpa masukin token di sini)
            $message = CloudMessage::fromArray([
                'notification' => [
                    'title' => "🚨 Peringatan Murid ({$roleLabel})",
                    'body'  => "Murid {$namaSiswa} telah mencapai {$totalPoin} poin pelanggaran.",
                ],
            ]);

            // 2. Tembakkan pesan tersebut ke banyak token sekaligus pakai sendMulticast
            $messaging->sendMulticast($message, $tokens);
        } catch (\Throwable $e) {
            \Log::error('Gagal kirim notif FCM ke role: ' . $e->getMessage());
        }
    }

    public function destroy($id_pelanggaran)
    {
        $pelanggaran = Pelanggaran::where('id_pelanggaran', $id_pelanggaran)->firstOrFail();
        $user = Auth::user();
        $canDelete = false;

        if ($user) {
            if ($user->usertype === 'admin') {
                $canDelete = true;
            } else {
                $userName = $user->namalengkap ?? $user->username;
                if ($pelanggaran->dicatat_oleh === $userName) {
                    $canDelete = true;
                }
            }
        }

        if (!$canDelete) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus pelanggaran ini'
            ], 403);
        }

        if ($pelanggaran->bukti_foto) {
            Storage::disk('public')->delete($pelanggaran->bukti_foto);
        }

        $id_siswa = $pelanggaran->id_siswa;
        $pelanggaran->delete();
        $totalPoinBaru = $this->updateTotalPoin($id_siswa);
        $this->updateTotalPoin($id_siswa);

    return response()->json([
            'success' => true,
            'message' => 'Pelanggaran berhasil dihapus',
            'total_poin' => $totalPoinBaru
        ]);
    }

    public function storePembinaan(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswas,id_siswa',
            'tindakan' => 'required|string',
            'feedback' => 'nullable|string',
            'pengurangan_poin' => 'nullable|integer|min:0'
        ]);

        $dicatatOleh = Auth::check() ? (Auth::user()->namalengkap ?? Auth::user()->username) : 'admin';

        $pembinaanBaru = Pembinaan::create([
            'id_siswa' => $request->id_siswa,
            'tanggal' => now()->format('Y-m-d'),
            'dibina_oleh' => $dicatatOleh,
            'tindakan' => $request->tindakan,
            'feedback' => $request->feedback,
            'pengurangan_poin' => $request->pengurangan_poin ?? 0
        ]);

        $totalPoin = $this->updateTotalPoin($request->id_siswa);

        return response()->json([
            'success' => true,
            'total_poin' => $totalPoin,
            'data_baru' => $pembinaanBaru
        ], 201);
    }
}