<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class CategoryController extends Controller
{
    public function index (){
        // akses record table category, semua record
        $rsetCategory = Kategori::all();
        // return $rsetCategory[0];
        // echo $rsetCategory[1]->deskripsi;

        return view('v_category.index', compact('rsetCategory'));

        // return view('v_category.master');
    }
}
