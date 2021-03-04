<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Traits\UploadAble;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;


class SettingController extends BaseController
{
    use UploadAble;


    /**
     * @return Application|Factory|View
     */
    public function index ()
    {
        $this->setPageTitle('Settings', 'Manage Settings');
        return view('admin.settings.index');
    }


    public function update (Request $request): RedirectResponse
    {
        if ($request->has('site_logo') && ($request->file('site_logo') instanceof UploadedFile)) {

            if (Config('settings.site_logo') != null) {
                $this->deleteOne(config('settings.site_logo'));
            }
            $logo = $this->uploadOne($request->file('site_logo'), 'img');
            Setting::set('site_logo', $logo);
        } elseif ($request->has('site_favicon') && ($request->file('site_favicon') instanceof UploadedFile)) {
            if (config('settings.site_favicon') != null) {
                $this->deleteOne(config('settings.site_favicon'));
            }

            $favicon = $this->uploadOne($request->file('site_favicon'), 'img');
            Setting::set('site_favicon', $favicon);
        } else {
            $keys = $request->except('_token');

            foreach ($keys as $key => $value) {
                Setting::set($key, $value);
            }
        }
        return $this->responseRedirectBack('Settings updated successfully.', 'success');
    }
}
