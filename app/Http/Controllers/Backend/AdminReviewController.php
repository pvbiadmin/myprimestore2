<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdminReviewDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminReviewController extends Controller
{
    /**
     * @param \App\DataTables\AdminReviewDataTable $dataTable
     * @return mixed
     */
    public function index(AdminReviewDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.product.review.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = ProductReview::query()->findOrFail($request->idToggle);

        $slider->status = ($request->isChecked == 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
            'message' => 'Review Status Updated.'
        ]);
    }
}
