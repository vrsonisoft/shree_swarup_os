<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Contact;
use App\Models\GlobalSetting;

class WebsiteSettingsController extends Controller
{
    /**
     * Inquiries Page (Dynamic)
     */
    public function inquiries()
    {
        $inquiries = collect();
        $inquiriesCount = 0;
        try {
            if (Schema::hasTable('contacts')) {
                $inquiries = Contact::latest()->get();
                $inquiriesCount = $inquiries->count();
            }
        } catch (\Throwable $e) {
            $inquiries = collect();
            $inquiriesCount = 0;
        }

        return view('superadmin.website-settings.inquiries', compact('inquiries', 'inquiriesCount'));
    }

    /**
     * Delete Inquiry
     */
    public function deleteInquiry($id)
    {
        try {
            if (Schema::hasTable('contacts')) {
                Contact::where('id', $id)->delete();
            }
            return response()->json(['success' => true, 'message' => 'Inquiry deleted successfully']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Subscribes Page (Dynamic)
     */
    public function subscribes()
    {
        $subscribers = collect();
        $subscribesCount = 0;
        try {
            if (Schema::hasTable('subscribes')) {
                $subscribers = DB::table('subscribes')->latest()->get();
                $subscribesCount = $subscribers->count();
            }
        } catch (\Throwable $e) {
            $subscribers = collect();
            $subscribesCount = 0;
        }

        return view('superadmin.website-settings.subscribes', compact('subscribers', 'subscribesCount'));
    }

    /**
     * Delete Subscriber
     */
    public function deleteSubscriber($id)
    {
        try {
            if (Schema::hasTable('subscribes')) {
                DB::table('subscribes')->where('id', $id)->delete();
            }
            return response()->json(['success' => true, 'message' => 'Subscriber removed successfully']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Social Settings Page
     */
    public function socialSettings()
    {
        Cache::forget('global_setting');
        $settings = GlobalSetting::first();

        return view('superadmin.website-settings.social-settings', compact('settings'));
    }

    /**
     * Save Social Settings (AJAX Compatible)
     */
    public function saveSocialSettings(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'nullable|string|max:50',
            'instagram_link'  => 'nullable|string|max:255',
            'facebook_link'   => 'nullable|string|max:255',
            'linkedin_link'   => 'nullable|string|max:255',
            'github_link'     => 'nullable|string|max:255',
            'twitter_link'    => 'nullable|string|max:255',
            'phone_number_1'  => 'nullable|string|max:50',
            'phone_number_2'  => 'nullable|string|max:50',
            'primary_email'   => 'nullable|string|max:100',
            'secondary_email' => 'nullable|string|max:100',
        ]);

        Cache::forget('global_setting');
        $settings = GlobalSetting::first();
        if (!$settings) {
            $settings = new GlobalSetting();
        }

        $settings->whatsapp_number = $request->whatsapp_number;
        $settings->instagram_link = $request->instagram_link;
        $settings->facebook_link = $request->facebook_link;
        $settings->linkedin_link = $request->linkedin_link;
        $settings->github_link = $request->github_link;
        $settings->twitter_link = $request->twitter_link;
        $settings->phone_number_1 = $request->phone_number_1;
        $settings->phone_number_2 = $request->phone_number_2;
        $settings->primary_email = $request->primary_email;
        $settings->secondary_email = $request->secondary_email;
        $settings->save();

        Cache::forget('global_setting');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Social handles updated successfully.'
            ]);
        }

        return back()->with('success', 'Social handles updated successfully.');
    }

    /**
     * Features Page (Clean DB Data Only)
     */
    public function features()
    {
        Cache::forget('global_setting');
        $settings = GlobalSetting::first();
        $coreFeatures = $settings ? $this->parseJsonArray($settings->core_features) : [];
        $moreFeatures = $settings ? $this->parseJsonArray($settings->more_features) : [];

        return view('superadmin.website-settings.features', compact('coreFeatures', 'moreFeatures'));
    }

    /**
     * Save Features (AJAX DB Save + Cache Eviction)
     */
    public function saveFeatures(Request $request)
    {
        try {
            Cache::forget('global_setting');
            $settings = GlobalSetting::first();
            if (!$settings) {
                $settings = new GlobalSetting();
            }

            if ($request->has('core_features')) {
                $coreFeatures = $request->input('core_features', []);
                if (is_string($coreFeatures)) {
                    $coreFeatures = json_decode($coreFeatures, true);
                }
                $settings->core_features = is_array($coreFeatures) ? array_values($coreFeatures) : [];
            }

            if ($request->has('more_features')) {
                $moreFeatures = $request->input('more_features', []);
                if (is_string($moreFeatures)) {
                    $moreFeatures = json_decode($moreFeatures, true);
                }
                $settings->more_features = is_array($moreFeatures) ? array_values($moreFeatures) : [];
            }

            $settings->save();
            Cache::forget('global_setting');

            return response()->json([
                'success' => true,
                'core_features' => $settings->core_features,
                'more_features' => $settings->more_features,
                'message' => 'Features updated successfully.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper to safely decode array columns
     */
    private function parseJsonArray($val)
    {
        if (empty($val)) return [];
        if (is_array($val)) return array_values($val);
        if (is_string($val)) {
            $decoded = json_decode($val, true);
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
            return is_array($decoded) ? array_values($decoded) : [];
        }
        return [];
    }

    /**
     * FAQs Page (Clean DB Data Only - Direct DB Query, No Cache)
     */
    public function faqs()
    {
        Cache::forget('global_setting');
        $settings = GlobalSetting::first();
        $faqs = $settings ? $this->parseJsonArray($settings->faqs) : [];

        return view('superadmin.website-settings.faqs', compact('faqs'));
    }

    /**
     * Save FAQs (AJAX DB Save + Cache Eviction)
     */
    public function saveFaqs(Request $request)
    {
        try {
            Cache::forget('global_setting');
            $settings = GlobalSetting::first();
            if (!$settings) {
                $settings = new GlobalSetting();
            }

            $faqs = $request->input('faqs', []);
            if (is_string($faqs)) {
                $faqs = json_decode($faqs, true);
            }
            $cleanFaqs = is_array($faqs) ? array_values($faqs) : [];

            $settings->faqs = $cleanFaqs;
            $settings->save();

            Cache::forget('global_setting');

            return response()->json([
                'success' => true,
                'faqs' => $cleanFaqs,
                'message' => 'FAQs updated successfully.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Pricing FAQs Page (Clean DB Data Only - Direct DB Query, No Cache)
     */
    public function pricingFaqs()
    {
        Cache::forget('global_setting');
        $settings = GlobalSetting::first();
        $pricingFaqs = $settings ? $this->parseJsonArray($settings->pricing_faqs) : [];

        return view('superadmin.website-settings.pricing-faqs', compact('pricingFaqs'));
    }

    /**
     * Save Pricing FAQs (AJAX DB Save + Cache Eviction)
     */
    public function savePricingFaqs(Request $request)
    {
        try {
            Cache::forget('global_setting');
            $settings = GlobalSetting::first();
            if (!$settings) {
                $settings = new GlobalSetting();
            }

            $pricingFaqs = $request->input('pricing_faqs', []);
            if (is_string($pricingFaqs)) {
                $pricingFaqs = json_decode($pricingFaqs, true);
            }
            $cleanPricingFaqs = is_array($pricingFaqs) ? array_values($pricingFaqs) : [];

            $settings->pricing_faqs = $cleanPricingFaqs;
            $settings->save();

            Cache::forget('global_setting');

            return response()->json([
                'success' => true,
                'pricing_faqs' => $cleanPricingFaqs,
                'message' => 'Pricing FAQs updated successfully.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * App Reviews Page (Clean DB Data Only - Direct DB Query, No Cache)
     */
    public function appReviews()
    {
        Cache::forget('global_setting');
        $settings = GlobalSetting::first();
        $reviews = $settings ? $this->parseJsonArray($settings->app_reviews) : [];

        return view('superadmin.website-settings.app-reviews', compact('reviews'));
    }

    /**
     * Save App Reviews (AJAX DB Save + Cache Eviction)
     */
    public function saveAppReviews(Request $request)
    {
        try {
            Cache::forget('global_setting');
            $settings = GlobalSetting::first();
            if (!$settings) {
                $settings = new GlobalSetting();
            }

            $reviews = $request->input('reviews', []);
            if (is_string($reviews)) {
                $reviews = json_decode($reviews, true);
            }
            $cleanReviews = is_array($reviews) ? array_values($reviews) : [];

            $settings->app_reviews = $cleanReviews;
            $settings->save();

            Cache::forget('global_setting');

            return response()->json([
                'success' => true,
                'reviews' => $cleanReviews,
                'message' => 'App Reviews updated successfully.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Legal Page with Single Table managed by Type (Clean DB Data Only)
     */
    public function legal(Request $request)
    {
        $activeTab = $request->get('tab', 'privacy-policy');
        
        $validTabs = [
            'privacy-policy' => 'Privacy Policy',
            'cookie-policy' => 'Cookie Policy',
            'terms-conditions' => 'Terms & Conditions',
            'refund-policy' => 'Refund Policy',
            'gdpr-compliance' => 'GDPR Compliance',
        ];

        if (!array_key_exists($activeTab, $validTabs)) {
            $activeTab = 'privacy-policy';
        }

        Cache::forget('global_setting');
        $settings = GlobalSetting::first();
        $legals = $settings ? $this->parseJsonArray($settings->legals) : [];

        return view('superadmin.website-settings.legal', compact('activeTab', 'validTabs', 'legals'));
    }

    /**
     * Save Legal Policy Sections (AJAX DB Save + Cache Eviction)
     */
    public function saveLegal(Request $request)
    {
        try {
            Cache::forget('global_setting');
            $settings = GlobalSetting::first();
            if (!$settings) {
                $settings = new GlobalSetting();
            }

            $legals = $request->input('legals', []);
            if (is_string($legals)) {
                $legals = json_decode($legals, true);
            }
            $cleanLegals = is_array($legals) ? array_values($legals) : [];

            $settings->legals = $cleanLegals;
            $settings->save();

            Cache::forget('global_setting');

            return response()->json([
                'success' => true,
                'legals' => $cleanLegals,
                'message' => 'Legal policies updated successfully.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function parseJsonObject($val)
    {
        if (empty($val)) return [];
        if (is_array($val)) return $val;
        if (is_string($val)) {
            $decoded = json_decode($val, true);
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    /**
     * Home Page Settings with 4 Tabs (Clean DB Data Only)
     */
    public function homePage()
    {
        Cache::forget('global_setting');
        $settings = GlobalSetting::first();

        $heroSettings = $settings ? $this->parseJsonObject($settings->hero_settings) : [];
        $videoSettings = $settings ? $this->parseJsonObject($settings->video_settings) : [];
        $whyChooseUs = $settings ? $this->parseJsonArray($settings->why_choose_us) : [];
        $templates = $settings ? $this->parseJsonArray($settings->templates) : [];

        return view('superadmin.website-settings.home-page', compact(
            'heroSettings',
            'videoSettings',
            'whyChooseUs',
            'templates'
        ));
    }

    /**
     * Save Home Page Settings (AJAX DB Save + Cache Eviction)
     */
    public function saveHomePage(Request $request)
    {
        try {
            Cache::forget('global_setting');
            $settings = GlobalSetting::first();
            if (!$settings) {
                $settings = new GlobalSetting();
            }

            if ($request->has('hero_settings')) {
                $hero = $request->input('hero_settings', []);
                if (is_string($hero)) $hero = json_decode($hero, true);
                $settings->hero_settings = is_array($hero) ? $hero : [];
            }

            if ($request->has('video_settings')) {
                $video = $request->input('video_settings', []);
                if (is_string($video)) $video = json_decode($video, true);
                $settings->video_settings = is_array($video) ? $video : [];
            }

            if ($request->has('why_choose_us')) {
                $why = $request->input('why_choose_us', []);
                if (is_string($why)) $why = json_decode($why, true);
                $settings->why_choose_us = is_array($why) ? array_values($why) : [];
            }

            if ($request->has('payment_gateways')) {
                $gateways = $request->input('payment_gateways', []);
                if (is_string($gateways)) $gateways = json_decode($gateways, true);
                $settings->payment_gateways = is_array($gateways) ? array_values($gateways) : [];
            }

            if ($request->has('templates')) {
                $templates = $request->input('templates', []);
                if (is_string($templates)) $templates = json_decode($templates, true);
                $settings->templates = is_array($templates) ? array_values($templates) : [];
            }

            $settings->save();
            Cache::forget('global_setting');

            return response()->json([
                'success' => true,
                'hero_settings' => $settings->hero_settings,
                'video_settings' => $settings->video_settings,
                'why_choose_us' => $settings->why_choose_us,
                'payment_gateways' => $settings->payment_gateways,
                'templates' => $settings->templates,
                'message' => 'Home Page settings updated successfully.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
