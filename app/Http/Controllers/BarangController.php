<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Exceptions\PostTooLargeException;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $rsetBarang = Barang::with('kategori')->latest()->paginate(10);

        // return view('barang.index', compact('rsetBarang'))
        //     ->with('i', (request()->input('page', 1) - 1) * 10);
        $keyword = $request->input('keyword');

        // Query untuk mencari barang berdasarkan keyword
        $rsetBarang = Barang::where('merk', 'LIKE', "%$keyword%")
            ->orWhere('seri', 'LIKE', "%$keyword%")
            ->orWhere('spesifikasi', 'LIKE', "%$keyword%")
            ->orWhere('stok', 'LIKE', "%$keyword%")
            ->orWhereHas('kategori', function ($query) use ($keyword) {
                $query->where('deskripsi', 'LIKE', "%$keyword%");
            })
            ->latest()
            ->paginate(10);
    
        return view('barang.index', compact('rsetBarang'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akategori = Kategori::all();
        return view('barang.create',compact('akategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        //validate form
        $request->validate([
            'merk'          => 'required',
            'seri'          => 'required',
            'spesifikasi'   => 'required',
            // 'stok'        => 'required',
            'kategori_id'   => 'required',
        ]);

        //create post
        Barang::create([
            'merk'             => $request->merk,
            'seri'             => $request->seri,
            'spesifikasi'      => $request->spesifikasi,
            // 'stok'             => $request->stok,
            'kategori_id'      => $request->kategori_id,
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);

        //return view
        return view('barang.show', compact('rsetBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $akategori = Kategori::all();
        $rsetBarang = Barang::find($id);
        $selectedKategori = Kategori::find($rsetBarang->kategori_id);
        return view('barang.edit', compact('rsetBarang', 'akategori', 'selectedKategori'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'merk'        => 'required',
            'seri'        => 'required',
            'spesifikasi' => 'required',
            // 'stok'        => 'required',
            'kategori_id' => 'required|integer',
        ]);

        $rsetBarang = Barang::find($id);

        // Update the "Barang" item with the new category ID
        $rsetBarang->update([
            'merk'        => $request->merk,
            'seri'        => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            // 'stok'        => $request->stok,
            'kategori_id' => $request->kategori_id,
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarang = Barang::find($id);


        // cek stok apakah lebih dari 0
        if ($rsetBarang->stok > 0) {
            return redirect()->route('barang.index')->with(['error' => 'Stok Barang masih ada, tidak dapat dihapus!']);
        }

        // cek apakah berelasi dengan barangkeluar
        $relatedBarangKeluar = BarangKeluar::where('barang_id', $id)->exists();
    
        if ($relatedBarangKeluar) {
            return redirect()->route('barang.index')->with(['gagal' => 'Data Gagal Dihapus! Data masih tercantum dalam tabel Barang Keluar']);
        }

        // cek apakah berelasi dengan barangmasuk
        $relatedBarangMasuk = BarangMasuk::where('barang_id', $id)->exists();

        if ($relatedBarangMasuk) {
            return redirect()->route('barang.index')->with(['gagal' => 'Data Gagal Dihapus! Data masih tercantum dalam tabel Barang Masuk']);
        }

        // delete
        $rsetBarang->delete();

        // Redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

        //menampilkan semua barang
        function barangAPI(){
            $barang = Barang::all();
            $data = array("data"=>$barang);
    
            return response()->json($data);
        }
    
        //menampilkan seluruh barang
        function ShowbarangAPI(string $id){
            $satubarang = Barang::find($id);
            if (!$satubarang) {
                return response()->json(['message' => 'Barang tidak ditemukan'], 404);
            }
            else{
                $data = array("data"=>$satubarang);
        
                return response()->json($data);
    
            }
        }
    
        public function UpdateKategoriAPI(Request $request, string $id) {
            $kategori = Kategori::find($id);
            if (!$kategori) {
                return response()->json(['status' => 'Kategori tidak ditemukan'], 404);
            }
    
            $kategori->deskripsi=$request->deskripsi;
            $kategori->kategori=$request->kategori;
            $kategori->save();
    
            return response()->json(['status' => 'Kategori berhasil diubah'], 200);          
            // }
        }

        public function cari($keyword){
            $query = "SELECT * FROM barang WHERE
                        merk LIKE '%$keyword%' OR
                        seri LIKE '%$keyword%' OR
                        spesifikasi LIKE '%$keyword%' OR
                        kategori LIKE '%$keyword%' 
                        ";
        
            return query($query);
        }

}