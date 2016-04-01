<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 系统设置.
 */
class SettingController extends Controller
{
    /**
     * 系统设置界面.
     */
    public function getIndex()
    {
        return admin_view('settings.index');
    }

    /**
     * 推荐设置.
     */
    public function getRecommand()
    {
        return admin_view('settings.recommand');
    }
}
