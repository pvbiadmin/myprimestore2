<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\PusherSetting;
use App\Traits\ImageUploadTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    use ImageUploadTrait;

    /**
     * View Settings Page
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $general_settings = GeneralSetting::query()->first();
        $email_settings = EmailConfiguration::query()->first();
        $logo_settings = LogoSetting::query()->first();
        $pusher_setting = PusherSetting::query()->first();

        return view('admin.setting.index',
            compact('general_settings', 'email_settings', 'logo_settings', 'pusher_setting'));
    }

    /**
     * Update General Settings
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateGeneralSetting(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name_site' => ['required', 'max:200'],
            'email_contact' => ['required', 'max:200'],
            'name_currency' => ['required', 'max:200'],
            'icon_currency' => ['required', 'max:200'],
            'timezone' => ['required', 'max:200'],
            'layout_site' => ['required', 'max:200']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        GeneralSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => $request->input('name_site'),
                'site_layout' => $request->input('layout_site'),
                'contact_email' => $request->input('email_contact'),
                'contact_phone' => $request->input('contact_phone'),
                'contact_address' => $request->input('contact_address'),
                'map' => $request->input('map'),
                'currency_name' => $request->input('name_currency'),
                'currency_icon' => $request->input('icon_currency'),
                'timezone' => $request->input('timezone'),
            ]
        );

        return redirect()->back()->with(['message' => 'General Settings Updated Successfully']);
    }

    /**
     * Email Configuration Setting
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function emailConfigSettingUpdate(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'host' => ['required', 'max:200'],
            'username' => ['required', 'max:200'],
            'password' => ['required', 'max:200'],
            'port' => ['required', 'max:200'],
            'encryption' => ['required', 'max:200'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()->with([
                'anchor' => 'list-email-config',
                'message' => $error,
                'alert-type' => 'error'
            ]);
        }

        EmailConfiguration::query()->updateOrCreate(
            ['id' => 1],
            $validator->validated()
        );

        return redirect()->back()->with([
            'anchor' => 'list-email-config',
            'message' => 'Email Configuration Updated'
        ]);
    }

    /**
     * Update Logo Settings
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logoSettingUpdate(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'logo' => ['image', 'max:3000'],
            'favicon' => ['image', 'max:3000'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()->with([
                'anchor' => 'list-logo-setting',
                'message' => $error,
                'alert-type' => 'error'
            ]);
        }

        $logoPath = $this->updateImage(
            $request, 'logo', 'uploads', $request->input('old_logo'));
        $favicon = $this->updateImage(
            $request, 'favicon', 'uploads', $request->input('old_favicon'));

        LogoSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'logo' => (!empty($logoPath)) ? $logoPath : $request->input('old_logo'),
                'favicon' => (!empty($favicon)) ? $favicon : $request->input('old_favicon')
            ]
        );

        return redirect()->back()->with([
            'anchor' => 'list-logo-setting',
            'message' => 'Logo Setting Updated'
        ]);
    }

    /**
     * Pusher settings update
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function pusherSettingUpdate(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'pusher_app_id' => ['required'],
            'pusher_key' => ['required'],
            'pusher_secret' => ['required'],
            'pusher_cluster' => ['required'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()->with([
                'anchor' => 'list-pusher-setting',
                'message' => $error,
                'alert-type' => 'error'
            ]);
        }

        PusherSetting::query()->updateOrCreate(
            ['id' => 1],
            $validator->validated()
        );

        return redirect()->back()->with([
            'anchor' => 'list-pusher-setting',
            'message' => 'Pusher Setting Updated'
        ]);
    }
}
