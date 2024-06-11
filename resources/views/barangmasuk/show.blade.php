@extends('layouts.adm-main')


@section('content')
    <div class="container">
    <div class="row">
            <div class="col-md-12">
		<div class="pull-left">
		    <h2>DETAIL BARANG MASUK</h2>
		</div>
            <div class="col-md-8">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>TANGGAL MASUK</td>
                                <td>{{ $rsetBarangMasuk->tgl_masuk }}</td>
                            </tr>
                            <tr>
                                <td>JUMLAH MASUK</td>
                                <td>{{ $rsetBarangMasuk->qty_masuk }}</td>
                            </tr>
                            <tr>
                                <td>BARANG</td>
                                <td>{{ $rsetBarangMasuk->barang->merk }} {{ $rsetBarangMasuk->barang->seri }}</td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12  text-center pt-3">
                <a href="{{ route('barangmasuk.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>
@endsection