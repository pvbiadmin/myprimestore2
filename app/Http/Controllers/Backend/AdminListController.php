<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdminListDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminListController extends Controller
{
    /**
     * @param \App\DataTables\AdminListDataTable $dataTable
     * @return mixed
     */
    public function index(AdminListDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.admin-list.index');
    }

    /**
     * Handles Coupon Status Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $user = User::query()->findOrFail($request->input('idToggle'));

        $user->setAttribute('status', $request->input('isChecked') == 'true' ? 'active' : 'inactive');

        $user->save();

        return response([
            'status' => 'success',
            'message' => 'Status has been updated!'
        ]);
    }

    /**
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $admin = User::query()->findOrFail($id);

        $products = Product::query()->where('vendor_id', $admin->vendor->id)->get();

        if (count($products) > 0) {
            return response([
                'status' => 'error',
                'message' => 'Admin can\'t be deleted, ban the user instead!']);
        }

        Vendor::query()->where('user_id', $admin->id)->delete();

        $admin->delete();

        return response(['status' => 'success', 'message' => 'Deleted successfully']);
    }
}
