<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class Product extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'title',
        'description',
        'price',
        'stock',
    ];

    /**
     * Rules for validation
     *
     * @var array
     */
    public static $rules = [
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg', // Aturan validasi untuk memastikan image field berisi gambar
    ];

    // Fungsi index seharusnya berada di dalam kelas Product
    public function index(): View
    {
        // Mendapatkan semua produk
        $products = Product::latest()->paginate(10);
        // Mengirimkan tampilan dengan produk
        return view('products.index', compact('products'));
    }
}
