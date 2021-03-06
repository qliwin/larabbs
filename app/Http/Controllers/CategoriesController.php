<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        // 读取分类 ID 关联的话题，并按每 10 条分页
        // $topics = Topic::where('category_id', $category->id)->with('user', 'category')->paginate(10);
        $topics = Topic::where('category_id', $category->id)->withOrder(request('order'))->paginate(10);
        return view('topics.index', compact('category','topics'));
    }
}
