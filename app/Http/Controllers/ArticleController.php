<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function view()
    {
        $articles = Article::paginate(10);

        return view('home', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('show', compact('article'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function index()
    {
        $articles = Article::where('user_id', Auth::id())->get();
        return view('articles.articles', compact('articles'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'audio_video_url' => 'nullable|url|max:255',
            'thumbnail_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail_image_url' => 'nullable|url|max:255',
            'content' => 'required|string',
            'posted_by' => 'required|string|max:255',
        ]);

        // Handle the thumbnail image upload
        if ($request->hasFile('thumbnail_image_file')) {
            $fileName = time() . '.' . $request->thumbnail_image_file->extension();
            $request->thumbnail_image_file->move(public_path('images'), $fileName);
            $thumbnailImageUrl = 'images/' . $fileName;
        } else {
            $thumbnailImageUrl = $request->thumbnail_image_url;
        }

        // Log the validated data and thumbnail image URL for debugging
        \Log::info('Validated Data:', $validated);
        \Log::info('Thumbnail Image URL:', $thumbnailImageUrl);

        // Create a new article
        $article = new Article([
            'title' => $validated['title'],
            'audio_video_url' => $validated['audio_video_url'],
            'thumbnail_image_url' => $thumbnailImageUrl,
            'content' => $validated['content'],
            'posted_by' => $validated['posted_by'],
            'status' => 'pending',
            'user_id' => Auth::id(),
        ]);

        // Log the article data before saving for debugging
        \Log::info('Article Data:', $article->toArray());

        // Save the article to the database
        $article->save();

        return redirect()->route('articles.create')->with('success', 'Article created successfully!');
    }
}
