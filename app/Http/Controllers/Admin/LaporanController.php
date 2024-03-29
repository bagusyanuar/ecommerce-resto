<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Payment;
use App\Models\ProductStock;
use App\Models\Transaction;

class LaporanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function laporan_pesanan()
    {
        return view('admin.laporan.pesanan.index');
    }

    public function laporan_pesanan_data()
    {
        try {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = Transaction::with(['user.member', 'waiting_payment'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->where('status', '!=', 'menunggu')
                ->where('status', '!=', 'tolak')
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_pesanan_cetak()
    {
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = Transaction::with(['user.member', 'waiting_payment'])
            ->whereBetween('tanggal', [$tgl1, $tgl2])
            ->where('status', '!=', 'menunggu')
            ->where('status', '!=', 'tolak')
            ->get();
        return $this->convertToPdf('admin.laporan.pesanan.cetak', [
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'data' => $data
        ]);
    }

    public function laporan_pembayaran()
    {
        return view('admin.laporan.pembayaran.index');
    }

    public function laporan_pembayaran_data()
    {
        try {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = Payment::with(['transaction.user.member'])
                ->whereHas('transaction', function ($q) use ($tgl1, $tgl2) {
                    return $q->whereBetween('tanggal', [$tgl1, $tgl2]);
                })
                ->where('status', '=', 'terima')
                ->where('total', '>', 0)
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_pembayaran_cetak()
    {
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = Payment::with(['transaction.user.member'])
            ->whereHas('transaction', function ($q) use ($tgl1, $tgl2) {
                return $q->whereBetween('tanggal', [$tgl1, $tgl2]);
            })
            ->where('status', '=', 'terima')
            ->where('total', '>', 0)
            ->get();
        return $this->convertToPdf('admin.laporan.pembayaran.cetak', [
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'data' => $data
        ]);
    }

    public function laporan_stock()
    {
        return view('admin.laporan.stock.index');
    }

    public function laporan_stock_data()
    {
        try {
            $data = Barang::with(['category'])
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_stock_cetak()
    {
        $data = Barang::with(['category'])
            ->get();
        return $this->convertToPdf('admin.laporan.stock.cetak', [
            'data' => $data
        ]);
    }

    public function laporan_tambah_stock()
    {
        return view('admin.laporan.tambah-stock.index');
    }

    public function laporan_tambah_stock_data()
    {
        try {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = ProductStock::with(['product'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_tambah_stock_cetak()
    {
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = ProductStock::with(['product'])
            ->whereBetween('tanggal', [$tgl1, $tgl2])
            ->get();
        return $this->convertToPdf('admin.laporan.tambah-stock.cetak', [
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'data' => $data
        ]);
    }
}
