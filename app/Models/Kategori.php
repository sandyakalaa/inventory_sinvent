<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = ['deskripsi','kategori'];

    public function ketKategori()
    {
        switch ($this->kategori) {
            case 'M':
                return 'Barang Modal';
            case 'A':
                return 'Alat';
            case 'BHP':
                return 'Bahan Habis Pakai';
            case 'BTHP':
                return 'Bahan Tidak Habis Pakai';
            default:
                return 'Unknown';
        }
    }

   
    public static function getKategoriAll(){
        return DB::table('kategori')
        ->join('barang', 'kategori_id', '=', 'barang.kategori_id')
        ->select('kategori_id', 'deskripsi', DB::raw('ketKategorik (kategori) as ketkategorik'), 'barang.merk');
    }

}
