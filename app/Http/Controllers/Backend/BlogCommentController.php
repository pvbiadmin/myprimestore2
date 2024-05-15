<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BlogCommentDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogCommentController extends Controller
{
    /**
     * @param \App\DataTables\BlogCommentDataTable $dataTable
     * @return mixed
     */
    public function index(BlogCommentDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.blog.blog-comment.index');
    }

    /**
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $comment = BlogComment::query()->findOrFail($id);
        $comment->delete();

        return response([
            'status' => 'success',
            'message' => 'message'
        ]);
    }
}
