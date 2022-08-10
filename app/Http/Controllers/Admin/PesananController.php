<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class PesananController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Transaction::with(['user.member', 'cart'])
            ->where('status', '=', 'packing')
            ->get();
        return view('admin.transaksi.pesanan-proses.index')->with(['data' => $data]);
    }

    public function detail($id)
    {
        $data = Transaction::with(['user.member', 'cart.product'])
            ->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data->update([
                    'status' => 'kirim',
                    'waktu' => $this->postField('waktu')
                ]);
                return redirect('/pesanan-proses');
            } catch (\Exception $e) {
                return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
            }

        }
        return view('admin.transaksi.pesanan-proses.detail')->with(['data' => $data]);
    }

    public function ambil()
    {
        $data = Transaction::with(['user.member', 'cart'])
            ->where('status', '=', 'kirim')
            ->get();
        return view('admin.transaksi.pesanan-ambil.index')->with(['data' => $data]);
    }

    public function detail_ambil($id)
    {
        $data = Transaction::with(['user.member', 'cart.product'])
            ->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $data->update([
                    'status' => 'selesai'
                ]);
                $jenis = $data->waiting_payment->jenis;
                if ($jenis === 'cod') {
                    $data_request = [
                        'transaction_id' => $data->id,
                        'bank' => 'CASH',
                        'no_rekening' => '-',
                        'nama' => '-',
                        'total' => $data->total,
                        'status' => 'terima',
                        'jenis' => $jenis
                    ];
                    Payment::create($data_request);
                }
                DB::commit();
                return redirect('/pesanan-selesai-menunggu');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
            }
        }
        return view('admin.transaksi.pesanan-ambil.detail')->with(['data' => $data]);
    }

    public function selesai()
    {
        $data = Transaction::with(['user.member', 'cart'])
            ->where('status', '=', 'selesai')
            ->get();
        return view('admin.transaksi.pesanan-selesai.index')->with(['data' => $data]);
    }

    public function detail_selesai($id)
    {
        $data = Transaction::with(['user.member', 'cart.product'])
            ->findOrFail($id);
        return view('admin.transaksi.pesanan-selesai.detail')->with(['data' => $data]);
    }
}
