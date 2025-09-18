<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q', ''));

        $query = Category::query()
            ->withCount('products')
            ->with('parent');

        if ($search !== '') {
            $variants = $this->generateSearchVariants($search);
            $query->where(function ($q) use ($variants) {
                foreach ($variants as $term) {
                    $q->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($term) . '%'])
                      ->orWhereHas('parent', function ($q2) use ($term) {
                          $q2->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($term) . '%']);
                      });
                }
            });
        }

        $categories = $query->paginate(10)->appends(['q' => $search]);

        return view('admin.categories.index', compact('categories', 'search'));
    }

    private function generateSearchVariants(string $input): array
    {
        $input = trim($input);
        if ($input === '') {
            return [];
        }

        $l = mb_strtolower($input);
        $variants = [$input, $l];

        // Pluriels FR courants
        // 1) s <-> Ø
        if (str_ends_with($l, 's')) {
            $variants[] = mb_substr($l, 0, -1);
        } else {
            $variants[] = $l . 's';
        }

        // 2) x <-> Ø (ex: bijoux <-> bijou)
        if (str_ends_with($l, 'x')) {
            $variants[] = mb_substr($l, 0, -1);
        } else {
            $variants[] = $l . 'x';
        }

        // 3) -al <-> -aux (ex: animal/animaux)
        if (str_ends_with($l, 'al')) {
            $variants[] = mb_substr($l, 0, -2) . 'aux';
        }
        if (str_ends_with($l, 'aux')) {
            $variants[] = mb_substr($l, 0, -3) . 'al';
        }

        // 4) -eau <-> -eaux (ex: bateau/bateaux)
        if (str_ends_with($l, 'eau')) {
            $variants[] = $l . 'x'; // eaux
        }
        if (str_ends_with($l, 'eaux')) {
            $variants[] = mb_substr($l, 0, -1); // eau
        }

        return array_values(array_unique($variants));
    }

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }
    public function editModal(Category $category)
    {
        return view('admin.categories.edit_modal_content', compact('category'));
    }
  

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}