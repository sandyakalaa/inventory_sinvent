@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
		<div class="pull-left">
		    <h2>EDIT BARANG KELUAR</h2>
		</div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barangkeluar.update',$rsetBarangKeluar->id) }}" method="POST" enctype="multipart/form-data">                    
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">TANGGAL KELUAR</label>
                                <input type="text" class="form-control @error('tgl_keluar') is-invalid @enderror" name="tgl_keluar" value="{{ old('tgl_keluar',$rsetBarangKeluar->tgl_keluar) }}" placeholder="keluarkan Tanggal Keluar Barang">
           
                                @error('tgl_keluar')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">JUMLAH BARANG</label>
                                <input type="text" class="form-control @error('qty_keluar') is-invalid @enderror" name="qty_keluar" value="{{ old('qty_keluar',$rsetBarangKeluar->qty_keluar) }}" placeholder="Masukan Jumlah Barang Keluar">
                           
                                <!-- error message untuk seri -->
                                @error('qty_keluar')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold">PILIH BARANG</label>
                                <select class="form-control" name="barang_id" aria-label="Default select example">
                                    <option value="blank">Pilih Barang</option>
                                    @foreach ($abarangkeluar as $rowbarangkeluar)
                                        @if ($selectedBarang && $selectedBarang->id == $rowbarangkeluar->id)
                                            <option value="{{ $rowbarangkeluar->id }}" selected>{{ $rowbarangkeluar->merk }}</option>
                                        @else
                                            <option value="{{ $rowbarangkeluar->id }}">{{ $rowbarangkeluar->merk }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                               
                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                            <a href="{{ route('barangkeluar.index') }}" class="btn btn-md btn-primary">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection