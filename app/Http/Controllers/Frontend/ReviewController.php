<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\UserProductReviewsDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductReviewGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    use ImageUploadTrait;

    public function index(UserProductReviewsDataTable $dataTable)
    {
        return $dataTable->render('frontend.dashboard.review.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $checkReviewExist = ProductReview::query()
            ->where([
                'product_id' => $request->product_id,
                'user_id' => Auth::user()->id
            ])->first();

        if ($checkReviewExist) {
            return redirect()->back()
                ->with([
                    'message' => 'You already added a review for this product!',
                    'alert-type' => 'error'
                ]);
        }

        $validator = Validator::make($request->all(), [
            'rating' => ['required'],
            'review' => ['required', 'max:200'],
            'images.*' => ['image']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();

            return redirect()->back()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $imagePaths = $this->uploadMultiImage($request, 'images', 'uploads');

        $productReview = new ProductReview();

        $productReview->product_id = $request->product_id;
        $productReview->vendor_id = $request->vendor_id;
        $productReview->user_id = Auth::user()->id;
        $productReview->rating = $request->rating;
        $productReview->review = $request->review;
        $productReview->status = 0;

        $productReview->save();

        if (!empty($imagePaths)) {
            foreach ($imagePaths as $path) {
                $reviewGallery = new ProductReviewGallery();

                $reviewGallery->product_review_id = $productReview->id;
                $reviewGallery->image = $path;

                $reviewGallery->save();
            }
        }

        return redirect()->back()
            ->with(['message' => 'Review added successfully!', 'alert-type' => 'success']);
    }
}
