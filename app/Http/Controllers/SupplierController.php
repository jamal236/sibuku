<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use App\Services\KodeGeneratorService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $suppliers = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        $kodeSupplier = KodeGeneratorService::generateKodeSupplier();
        return view('supplier.create', compact('kodeSupplier'));
    }

    public function store(SupplierRequest $request)
    {
        $data = $request->validated();
        $data['kode_supplier'] = KodeGeneratorService::generateKodeSupplier();
        $data['is_aktif'] = $request->has('is_aktif');

        Supplier::create($data);

        return redirect()->route('supplier.index')->with('success', 'Supplier/Donatur berhasil ditambahkan!');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();
        $data['is_aktif'] = $request->has('is_aktif');

        $supplier->update($data);

        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil diperbarui!');
    }

    public function destroy(Supplier $supplier)
    {
        // PENTING: Database memiliki constraint ON DELETE RESTRICT
        if ($supplier->stokMasuk()->exists()) {
            return back()->with('error', 'Supplier tidak dapat dihapus karena memiliki riwayat stok masuk. Anda bisa menonaktifkannya saja.');
        }

        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
    }

}