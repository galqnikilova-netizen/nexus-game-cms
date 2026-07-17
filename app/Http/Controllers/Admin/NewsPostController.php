<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsPostController extends Controller
{
    public function index(): View { return view('admin.news.index', ['posts'=>NewsPost::latest()->paginate(20)]); }
    public function create(): View { return view('admin.news.form', ['post'=>new NewsPost]); }
    public function edit(NewsPost $news): View { return view('admin.news.form', ['post'=>$news]); }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['author_id'] = auth()->id();
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['published_at'] = $data['is_published'] ? now() : null;
        if ($request->hasFile('image')) $data['image_path'] = $request->file('image')->store('news', 'public');
        NewsPost::create($data);
        return to_route('admin.news.index')->with('success', 'Новината е създадена.');
    }

    public function update(Request $request, NewsPost $news): RedirectResponse
    {
        $data = $this->validated($request);
        if ($news->title !== $data['title']) $data['slug'] = $this->uniqueSlug($data['title'], $news->id);
        $data['published_at'] = $data['is_published'] ? ($news->published_at ?? now()) : null;
        if ($request->hasFile('image')) {
            if ($news->image_path) Storage::disk('public')->delete($news->image_path);
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }
        $news->update($data);
        return to_route('admin.news.index')->with('success', 'Новината е обновена.');
    }

    public function destroy(NewsPost $news): RedirectResponse
    {
        if ($news->image_path) Storage::disk('public')->delete($news->image_path);
        $news->delete();
        return back()->with('success', 'Новината е изтрита.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'=>['required','string','max:180'], 'excerpt'=>['required','string','max:500'],
            'content'=>['required','string','max:50000'], 'category'=>['required','string','max:80'],
            'image'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_published'=>['nullable','boolean'], 'is_featured'=>['nullable','boolean'],
        ]);
        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        unset($data['image']);
        return $data;
    }

    private function uniqueSlug(string $title, ?int $ignore = null): string
    {
        $base = Str::slug($title) ?: 'news'; $slug = $base; $counter = 2;
        while (NewsPost::where('slug',$slug)->when($ignore,fn($q)=>$q->where('id','!=',$ignore))->exists()) $slug = $base.'-'.$counter++;
        return $slug;
    }
}
