<?php

namespace App\Http\Controllers\Material;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
  /**
   * Provision a new web server.
   * @param \Illuminate\Http\Request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $query = $request->q;
    $perPage = $request->perPage ?? 10;

    $materials_ids = Material::selectRaw('distinct id')
      ->leftJoin('material_tags', 'materials.id', '=', 'material_tags.material_id')
      ->orWhere('title', 'like', "%{$query}%")
      ->orWhere('authors', 'like', "%{$query}%")
      ->orWhereIn('tag_id', function ($q) use ($query) {
        $q->select(DB::raw('id'))->from('tags')->where('tags.title', 'like', "{$query}%");
      })
      ->orWhereIn('category_id', function ($q) use ($query) {
        $q->select(DB::raw('id'))->from('categories')->where('categories.title', 'like', "{$query}%");
      })
      ->get();

    $materials = Material::whereIn('id', $materials_ids)->paginate($perPage);

    return view('material.list', compact('materials', 'query'));
  }
}
