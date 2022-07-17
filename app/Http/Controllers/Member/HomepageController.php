<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomepageController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $category = Category::with('barang')->get();
        $data = Barang::with('category')->get();
        return view('member.index')->with([
            'categories' => $category,
            'data' => $data
        ]);
    }

    public function product_page($id)
    {
        $data = Barang::findOrFail($id);
        return view('member.product')->with(['data' => $data]);
    }

    public function category_page($id)
    {
        $category = Category::all();
        $current_category = Category::find($id);
        $data = Barang::with('category')->where('category_id', '=', $id)->get();
        return view('member.category')->with([
            'categories' => $category,
            'data' => $data,
            'current_category' => $current_category
        ]);
    }

    public function get_product_by_name_and_category($id)
    {
        try {
            $name = $this->field('name');
            $data = Barang::with('category')
                ->where('category_id', '=', $id)
                ->where('nama', 'LIKE', '%' . $name . '%')
                ->get();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function about()
    {
        return view('member.tentang');
    }

    public function contact()
    {
        return view('member.hubungi');
    }

    public function profile()
    {
        $data = User::with('member')
            ->findOrFail(Auth::id());
        if ($this->request->method() === 'POST') {
            try {
                DB::beginTransaction();
                $id = $this->postField('id');
                $user = User::find($id);
                $data_user = [
                    'username' => $this->postField('username'),
                ];

                if ($this->postField('password') !== '') {
                    $data_user['password'] = Hash::make($this->postField('password'));
                }
                $user->update($data_user);
                $member = Member::with('user')->where('user_id', '=', $user->id)->firstOrFail();
                $member_data = [
                    'nama' => $this->postField('nama'),
                    'no_hp' => $this->postField('no_hp'),
                    'alamat' => $this->postField('alamat')
                ];
                $member->update($member_data);
                DB::commit();
                return redirect('/profil')->with(['success' => 'Berhasil Merubah Data...']);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
            }
        }
        return view('member.profile')->with(['data' => $data]);
    }
}
