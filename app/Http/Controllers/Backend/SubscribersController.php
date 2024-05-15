<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\NewsletterSubscriberDataTable;
use App\Helper\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\Newsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SubscribersController extends Controller
{
    /**
     * @param \App\DataTables\NewsletterSubscriberDataTable $dataTable
     * @return mixed
     */
    public function index(NewsletterSubscriberDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.subscriber.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMail(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required'],
            'message' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $emails = NewsletterSubscriber::query()
            ->where('is_verified', 1)
            ->pluck('email')->toArray();

        MailHelper::setMailConfig();
        Mail::to($emails)->send(new Newsletter($request->subject, $request->message));

        return redirect()->back()->with(['message' => 'Mail has been sent']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $subscriber = NewsletterSubscriber::query()->findOrFail($id);

        $subscriber->delete();

        return response([
            'status' => 'success',
            'message' => 'Deleted Successfully.'
        ]);
    }
}
