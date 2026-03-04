<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class KatalogController extends Controller
{
    /**
     * Tampilkan katalog produk
     */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', 'ALL'));
        $status = trim((string) $request->query('status', 'ALL'));

        $productsQuery = Product::query();

        if ($keyword !== '') {
            $productsQuery->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('category', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        if (in_array($category, ['ATK', 'Snack', 'Drink'], true)) {
            $productsQuery->where('category', $category);
        } else {
            $category = 'ALL';
        }

        if (in_array($status, ['Aktif', 'Nonaktif'], true)) {
            $productsQuery->where('status', $status);
        } else {
            $status = 'ALL';
        }

        return view('admin.katalog', [
            'products' => $productsQuery->latest()->get(),
            'adminName' => session('admin_name', 'Admin'),
            'filters' => [
                'q' => $keyword,
                'category' => $category,
                'status' => $status,
            ],
        ]);
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|in:ATK,Snack,Drink',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:Aktif,Nonaktif',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        Product::create($data);

        return back()->with('success', 'Produk ditambahkan');
    }

    /**
     * Update produk
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|in:ATK,Snack,Drink',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:Aktif,Nonaktif',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // jika upload image baru
        if ($request->hasFile('image')) {

            // hapus image lama
            if (!empty($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // simpan image baru
            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($data);

        return back()->with('success', 'Produk diperbarui');
    }

    /**
     * Hapus produk
     */
    public function destroy($id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        // hapus image dari storage
        if (!empty($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Produk dihapus');
    }
}
