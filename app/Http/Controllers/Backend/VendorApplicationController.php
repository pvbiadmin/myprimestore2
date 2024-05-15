<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorApplicationDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VendorApplicationController extends Controller
{
    /**
     * @param \App\DataTables\VendorApplicationDataTable $dataTable
     * @return mixed
     */
    public function index(VendorApplicationDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.vendor-application.index');
    }

    /**
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $vendor = Vendor::query()->findOrFail($id);

        return view('admin.vendor-application.show', compact('vendor'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus(Request $request, string $id): RedirectResponse
    {
        $vendor = Vendor::query()->findOrFail($id);
        $vendor->status = $request->status;
        $vendor->save();

        $user = User::query()->findOrFail($vendor->user_id);
        $user->role = 'vendor';
        $user->save();

        return redirect()->route('admin.vendor-applications.index')
            ->with(['message' => 'Updated successfully!', 'alert-type' => 'success']);
    }
}
