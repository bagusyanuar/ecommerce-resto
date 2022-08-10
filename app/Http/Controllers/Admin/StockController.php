<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\ProductStock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StockController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = ProductStock::with('product')
            ->where('tanggal', '=', Carbon::now()->format('Y-m-d'))
            ->get();
        return view('admin.data.stok.index')->with(['data' => $data]);
    }

    public function add_page()
    {
        $data = Barang::all();
        return view('admin.data.stok.add')->with(['data' => $data]);
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            $barang = Barang::find($this->postField('product'));
            $current_qty = $barang->qty;
            $tambahan = $this->postField('qty');
            $qty = $current_qty + $tambahan;
            $barang->update([
                'qty' => $qty
            ]);
            $data = [
                'tanggal' => Carbon::now(),
                'qty' => $tambahan,
                'product_id' => $this->postField('product')
            ];
            ProductStock::create($data);
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
        }
    }

    public function destroy()
    {
        DB::beginTransaction();
        try {
            $id = $this->postField('id');
            $stock = ProductStock::find($id);
            $tambahan = $stock->qty;
            $barang = Barang::find($stock->product_id);
            $qty_current = $barang->qty;
            $qty = $qty_current - $tambahan;
            $barang->update(['qty' => $qty]);
            $stock->delete();
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed', 500);
        }
    }
}
