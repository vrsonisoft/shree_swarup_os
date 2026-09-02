<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Enums\PackageType;
use App\Models\Contact;
use App\Models\CustomMenu;
use App\Models\FrontDetail;
use App\Models\FrontFaq;
use App\Models\FrontFeature;
use App\Models\FrontReviewSetting;
use App\Models\LanguageSetting;
use App\Models\Restaurant;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Module;
use Nwidart\Modules\Facades\Module as  ModuleFacade;

class HomeController extends Controller
{

    use AppBoot;

    protected $language;

    public function __construct()
    {
        parent::__construct();

        $locale = session('customer_locale') ?? (global_setting()->locale ?? 'en');
        $languageSetting = LanguageSetting::where('language_code', $locale)->first();

        if (!$languageSetting) {
            $locale = 'en';
            $languageSetting = LanguageSetting::where('language_code', 'en')->first();
        }

        if (!session()->has('customer_is_rtl')) {
            session(['customer_is_rtl' => $languageSetting ? ($languageSetting->is_rtl == 1) : false]);
        }

        app()->setLocale($locale);
        $this->language = $locale;
    }

    public function changeLocale($locale)
    {
        // Validate if the locale exists in language settings
        $languageSetting = LanguageSetting::where('language_code', $locale)->first();

        // Set the customer locale in session
        session(['customer_locale' => $locale]);
        session(['customer_is_rtl' => $languageSetting ? ($languageSetting->is_rtl == 1) : false]);
        app()->setLocale($locale);
        $this->language = $locale;
        return redirect()->back()->with('success', 'Language changed successfully');
    }

    public function landing()
    {
        $this->showInstall();

        return redirect()->route('login');
    }

    public function signup()
    {
        return view('auth.restaurant_register');
    }

    public function customerLogout()
    {
        session()->flush();
        return redirect(module_enabled('Subdomain') ? url('/') : route('shop_restaurant', [request()->restaurant]));
    }

    public function manifest()
    {
        $hash = request()->query('hash', '');

        if (!empty($hash)) {
            $slug = 'restaurant/' . $hash . '/';
        } else {
            $slug = 'super-admin/';
        }

        $relativeUrl = urldecode(request()->query('url', ''));

        $superadminUrl1 = File::exists(public_path('user-uploads/favicons/super-admin/android-chrome-192x192.png')) ? asset('user-uploads/favicons/super-admin/android-chrome-192x192.png') : asset('img/192x192.png');
        $superadminUrl2 = File::exists(public_path('user-uploads/favicons/super-admin/android-chrome-512x512.png')) ? asset('user-uploads/favicons/super-admin/android-chrome-512x512.png') : asset('img/512x512.png');


        $firstimagePath = public_path('user-uploads/favicons/' . $slug . 'android-chrome-192x192.png');
        $secondimagePath = public_path('user-uploads/favicons/' . $slug . 'android-chrome-512x512.png');
        $firsticonUrl = File::exists($firstimagePath) ? asset('user-uploads/favicons/' . $slug . 'android-chrome-192x192.png') : $superadminUrl1;
        $secondiconUrl = File::exists($secondimagePath) ? asset('user-uploads/favicons/' . $slug . 'android-chrome-512x512.png') : $superadminUrl2;
        $globalSetting = global_setting();

        $restaurant = Restaurant::where('hash', $hash)->first();

        return response()->json([
            'name' => $restaurant ? $restaurant->name : $globalSetting->name,
            'short_name' => $restaurant ? $restaurant->name : $globalSetting->name,
            'description' => $restaurant ? $restaurant->name : $globalSetting->name,
            'start_url' => url($relativeUrl),
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => '#000000',
            'icons' => [
                [
                    'src' => $firsticonUrl,
                    'sizes' => '192x192',
                    'type' => 'image/png'
                ],
                [
                    'src' => $secondiconUrl,
                    'sizes' => '512x512',
                    'type' => 'image/png'
                ]
            ]
        ]);
    }



    public function validatePartnerDomain(Request $request)
    {
        $restApiInstalled = ModuleFacade::has('RestApi');

        if (!$restApiInstalled) {
            return response()->json([
                'status' => false,
                'code' => 'REST_API_MODULE_NOT_INSTALLED',
                'message' => __('messages.restApiModuleNotInstalledForDelivery'),
            ], 422);
        }

        if (!module_enabled('RestApi')) {
            return response()->json([
                'status' => false,
                'code' => 'REST_API_MODULE_NOT_ENABLED',
                'message' => __('messages.restApiModuleNotEnabledForDelivery'),
            ], 422);
        }

        $globalSetting = global_setting();
        $mapProvider = $globalSetting->map_provider ?? 'google';

        if ($mapProvider === 'google') {
            $googleMapApiKey = $globalSetting->google_map_api_key;
            if (blank($googleMapApiKey)) {
                return response()->json([
                    'status' => false,
                    'code' => 'GOOGLE_MAP_API_KEY_NOT_CONFIGURED',
                    'message' => __('messages.googleMapApiKeyMissingForDelivery'),
                ], 422);
            }
        }

        $plugins = ModuleFacade::all(); /* @phpstan-ignore-line */
        $updateArray = [];
        $updateArrayEnabled = [];

        foreach ($plugins as $key => $plugin) {
            $modulePath = $plugin->getPath();
            $version = trim(File::get($modulePath . '/version.txt'));

            if ($plugin->isEnabled()) {
                $updateArrayEnabled[$key] = $version;
            }

            $updateArray[$key] = $version;
        }


        return response()->json([
            'status' => true,
            'code' => 'VALIDATION_SUCCESSFUL',
            'message' => __('messages.partnerValidationSuccessful'),
            'map_provider' => $mapProvider,
            'module_enabled' => $updateArray,
            'restaurant' => [
                'name' => global_setting()->name,
                'theme_hex' => global_setting()->theme_hex,
                'logo' => global_setting()->logoUrl,
                'locale' => global_setting()->locale,
            ],
        ], 200);
    }
}
