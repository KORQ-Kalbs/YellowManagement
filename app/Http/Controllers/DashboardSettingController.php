<?php

namespace App\Http\Controllers;

use App\Models\DashboardSetting;
use App\Models\DiscountEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardSettingController extends Controller
{
    public function index(): View
    {
        $welcomeSetting = DashboardSetting::query()->where('page', 'welcome')->first();
        $menuSetting = DashboardSetting::query()->where('page', 'menu')->first();
        $activeDiscount = DiscountEvent::active()->latest('start_date')->first();

        return view('admin.dashboard-setting.index-dashboard-setting', compact('welcomeSetting', 'menuSetting', 'activeDiscount'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSettingRequest($request);

        DashboardSetting::upsertPage($validated['page'], $validated['content']);

        return back()->with('success', 'Dashboard settings updated successfully.');
    }

    public function update(Request $request, DashboardSetting $dashboardSetting): RedirectResponse
    {
        $validated = $this->validateSettingRequest($request, $dashboardSetting->page);

        $dashboardSetting->update([
            'content' => $validated['content'],
        ]);

        return back()->with('success', ucfirst($dashboardSetting->page) . ' settings updated successfully.');
    }

    public function destroy(DashboardSetting $dashboardSetting): RedirectResponse
    {
        $dashboardSetting->delete();

        return back()->with('success', ucfirst($dashboardSetting->page) . ' settings reset to defaults.');
    }

    private function validateSettingRequest(Request $request, ?string $page = null): array
    {
        $validated = $request->validate([
            'page' => ['required', 'in:welcome,menu'],
            'content_json' => ['required', 'json'],
        ]);

        $content = json_decode($validated['content_json'], true);

        if (! is_array($content)) {
            abort(422, 'Invalid settings content.');
        }

        return [
            'page' => $validated['page'],
            'content' => $content,
        ];
    }
}