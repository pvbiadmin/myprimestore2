<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BlogController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function blog(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->has('search')) {
            $blogs = Blog::with('category')
                ->where('title', 'like', '%' . $request->search . '%')
                ->where('status', 1)->orderBy('id', 'DESC')
                ->paginate(12);
        } elseif ($request->has('category')) {
            $category = BlogCategory::query()->where('slug', $request->category)
                ->where('status', 1)->firstOrFail();

            $blogs = Blog::with('category')->where('category_id', $category->id)
                ->where('status', 1)->orderBy('id', 'DESC')
                ->paginate(12);
        } else {
            $blogs = Blog::with('category')
                ->where('status', 1)
                ->orderBy('id', 'DESC')->paginate(12);
        }

        return view('frontend.pages.blog', compact('blogs'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function blogDetails(string $slug): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $blog = Blog::with('comments')
            ->where('slug', $slug)
            ->where('status', 1)->firstOrFail();

        $moreBlogs = Blog::query()
            ->where('slug', '!=', $slug)
            ->where('status', 1)
            ->orderBy('id', 'DESC')->take(5)->get();

        $recentBlogs = Blog::query()
            ->where('slug', '!=', $slug)
            ->where('status', 1)
            ->where('category_id', $blog->category_id)
            ->orderBy('id', 'DESC')->take(12)->get();

        $comments = $blog->comments()->paginate(20);

        $categories = BlogCategory::query()->where('status', 1)->get();

        return view('frontend.pages.blog-detail',
            compact('blog', 'moreBlogs', 'recentBlogs', 'comments', 'categories'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'comment' => ['required', 'max:1000']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $comment = new BlogComment();

        $comment->user_id = auth()->user()->id;
        $comment->blog_id = $request->blog_id;
        $comment->comment = $request->comment;

        $comment->save();

        return redirect()->back()->with([
            'message' => 'Comment added successfully!',
            'alert-type' => 'success'
        ]);
    }
}
