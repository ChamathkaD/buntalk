<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;

class HomeController extends Controller
{
    /**
     * Using const variable for status
     */
    const STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ThemeCustomizationRepository $themeCustomizationRepository)
    {
    }

    /**
     * Loads the home page for the storefront.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $exists = DB::table('settings')->exists();

        if (! $exists) {
            DB::table('settings')->updateOrInsert([
                'is_launched' => false,
            ], [
                'is_launched' => false,
            ]);
        }

        // Check if the website has been launched before
        $launched = DB::table('settings')->where('is_launched', true)->exists();

        // If the website has been launched, redirect to the main page
        if (! $launched) {
            return view('shop::home.launch');
        }

        visitor()->visit();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id,
        ]);

        return view('shop::home.index', compact('customizations'));
    }

    public function launch()
    {
        DB::table('settings')->updateOrInsert([
            'is_launched' => false,
        ], [
            'is_launched' => true,
        ]);

        // Redirect to the main page
        return redirect()->route('shop.home.index');
    }

    /**
     * Loads the home page for the storefront if something wrong.
     *
     * @return \Exception
     */
    public function notFound()
    {
        abort(404);
    }
}
