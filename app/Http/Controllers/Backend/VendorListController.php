<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorListDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VendorListController extends Controller
{
    /**
     * @param \App\DataTables\VendorListDataTable $dataTable
     * @return mixed
     */
    public function index(VendorListDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.vendor-list.index');
    }

    /**
     * Handles Coupon Status Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $user = User::query()->findOrFail($request->idToggle);

        $user->status = ($request->isChecked == 'true' ? 'active' : 'inactive');
        $user->save();

        return response([
            'status' => 'success',
            'message' => 'Status has been updated!'
        ]);
    }
}
