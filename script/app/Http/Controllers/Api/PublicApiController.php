<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use App\Models\Contact;
use App\Models\GlobalSetting;
use App\Models\Tutorial;
use App\Models\TutorialCategory;
use App\Models\FrontFaq;
use App\Models\Package;

class PublicApiController extends Controller
{
    // CORS is handled cleanly by Laravel HandleCors middleware


    /**
     * GET /api/v1/public/features

     * Fetch core and more features for landing site
     */
    public function getFeatures()
    {
        try {
            $settings = function_exists('global_setting') ? global_setting() : GlobalSetting::first();
            $coreFeatures = $settings ? ($settings->core_features ?? []) : [];
            $moreFeatures = $settings ? ($settings->more_features ?? []) : [];

            return response()->json([
                'success' => true,
                'data' => [
                    'core_features' => is_array($coreFeatures) ? $coreFeatures : [],
                    'more_features' => is_array($moreFeatures) ? $moreFeatures : [],
                ]
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/public/legals?type=privacy-policy
     * Fetch legal policy sections for landing site (filtered by policy type)
     */
    public function getLegals(Request $request)
    {
        try {
            $settings = function_exists('global_setting') ? global_setting() : GlobalSetting::first();
            $legals = $settings ? ($settings->legals ?? []) : [];

            if (is_string($legals)) {
                $legals = json_decode($legals, true);
            }
            $legals = is_array($legals) ? array_values($legals) : [];

            if ($request->has('type') && !empty($request->type)) {
                $targetType = $request->type;
                $legals = array_values(array_filter($legals, function ($item) use ($targetType) {
                    return isset($item['type']) && $item['type'] === $targetType;
                }));
            }

            return response()->json([
                'success' => true,
                'count'   => count($legals),
                'data'    => $legals
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/public/social-settings
     * Fetch social settings & company handles for Table_qr_web
     */
    public function getSocialSettings()
    {
        try {
            $settings = function_exists('global_setting') ? global_setting() : GlobalSetting::first();

            return response()->json([
                'success' => true,
                'data'    => [
                    'whatsapp_number' => $settings->whatsapp_number ?? null,
                    'instagram_link'  => $settings->instagram_link ?? null,
                    'facebook_link'   => $settings->facebook_link ?? null,
                    'linkedin_link'   => $settings->linkedin_link ?? null,
                    'github_link'     => $settings->github_link ?? null,
                    'twitter_link'    => $settings->twitter_link ?? null,
                    'phone_number_1'  => $settings->phone_number_1 ?? null,
                    'phone_number_2'  => $settings->phone_number_2 ?? null,
                    'primary_email'   => $settings->primary_email ?? null,
                    'secondary_email' => $settings->secondary_email ?? null,
                ]
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/v1/public/inquiry
     * Submit a new Project Inquiry from website contact form (Table_qr_web)
     */
    public function submitInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:191',
            'email'    => 'required|email|max:191',
            'phone'    => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'message'  => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $inquiry = new Contact();
            $inquiry->name = $request->name;
            $inquiry->email = $request->email;
            $inquiry->phone = $request->phone;
            $inquiry->category = $request->category ?? 'General Inquiry';
            $inquiry->message = $request->message;
            $inquiry->save();

            return response()->json([
                'success' => true,
                'message' => 'Your project inquiry has been submitted successfully!',
                'data'    => $inquiry
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process inquiry submission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/v1/public/subscribe
     * Subscribe to Newsletter from website footer or popup (Table_qr_web)
     */
    public function subscribeNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $email = strtolower(trim($request->email));

            // Check if already subscribed
            $existing = DB::table('subscribes')->where('email', $email)->first();
            if ($existing) {
                return response()->json([
                    'success' => true,
                    'message' => 'You are already subscribed to our newsletter!'
                ], 200);
            }

            DB::table('subscribes')->insert([
                'email'      => $email,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subscribed successfully to newsletter!'
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process subscription: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/public/inquiries
     * Fetch list of inquiries (Public/Admin API)
     */
    public function getInquiries(Request $request)
    {
        try {
            $query = Contact::query();

            if ($request->has('category') && !empty($request->category)) {
                $query->where('category', $request->category);
            }

            $inquiries = $query->latest()->get();

            return response()->json([
                'success' => true,
                'count'   => $inquiries->count(),
                'data'    => $inquiries
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/public/subscribers
     * Fetch list & count of newsletter subscribers
     */
    public function getSubscribers()
    {
        try {
            $subscribers = DB::table('subscribes')->latest()->get();

            return response()->json([
                'success' => true,
                'count'   => $subscribers->count(),
                'data'    => $subscribers
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/public/tutorials
     * Fetch public list of tutorials with categories and sub categories
     */
    public function getTutorials(Request $request)
    {
        try {
            $query = Tutorial::with(['category', 'subCategory']);

            if ($request->has('category_id')) {
                $query->where('tutorial_category_id', $request->category_id);
            }
            if ($request->has('sub_category_id')) {
                $query->where('tutorial_sub_category_id', $request->sub_category_id);
            }

            $tutorials = $query->latest()->get();

            return response()->json([
                'success' => true,
                'count'   => $tutorials->count(),
                'data'    => $tutorials
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/public/tutorials/categories
     * Fetch public list of tutorial categories with sub categories
     */
    public function getTutorialCategories()
    {
        try {
            $categories = TutorialCategory::with(['subCategories'])->withCount('tutorials')->get();

            return response()->json([
                'success' => true,
                'count'   => $categories->count(),
                'data'    => $categories
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/public/tutorials/{slug}
     * Fetch tutorial details by slug
     */
    public function getTutorialDetail($slug)
    {
        try {
            $tutorial = Tutorial::with(['category', 'subCategory'])->where('slug', $slug)->first();

            if (!$tutorial) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tutorial not found'
                ], 444);
            }

            return response()->json([
                'success' => true,
                'data'    => $tutorial
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/public/faqs
     * Fetch public FAQs list managed by SuperAdmin Website Settings (global_settings.faqs)
     */
    public function getFaqs()
    {
        try {
            $settings = function_exists('global_setting') ? global_setting() : GlobalSetting::first();
            $rawFaqs = $settings ? $settings->faqs : [];

            if (is_string($rawFaqs)) {
                $rawFaqs = json_decode($rawFaqs, true);
                if (is_string($rawFaqs)) {
                    $rawFaqs = json_decode($rawFaqs, true);
                }
            }

            $faqs = is_array($rawFaqs) ? array_values($rawFaqs) : [];

            // Filter active status if status property exists
            $faqs = array_values(array_filter($faqs, function ($f) {
                if (is_array($f) && isset($f['status'])) {
                    return $f['status'] === 'active';
                }
                return true;
            }));

            if (empty($faqs)) {
                $faqs = [
                    [
                        'id' => 1,
                        'question' => 'How does TableTrack Digital QR Menu work?',
                        'answer' => 'TableTrack allows restaurant customers to scan a QR code placed on their table using their smartphone camera, view the digital interactive menu, customize their order, and place orders directly without waiting for a waiter.'
                    ],
                    [
                        'id' => 2,
                        'question' => 'Can I customize menu items, prices, and categories in real time?',
                        'answer' => 'Yes! You can update menu items, pricing, photos, variants, and availability instantly from your SuperAdmin / Restaurant Admin dashboard. Changes reflect immediately on customer smartphones.'
                    ],
                    [
                        'id' => 3,
                        'question' => 'Does TableTrack support POS & Kitchen Order Tickets (KOT)?',
                        'answer' => 'Yes, TableTrack includes a complete POS billing interface and automated KOT management. Orders placed by customers or staff automatically print or display on kitchen screens.'
                    ]
                ];
            }

            return response()->json([
                'success' => true,
                'count'   => count($faqs),
                'data'    => $faqs
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/public/packages
     * Fetch public packages (excluding trial & private packages) + pricing FAQs object
     */
    public function getPackages()
    {
        try {
            // 1. Fetch Packages (excluding trial & private)
            $packages = Package::with(['modules', 'currency'])
                ->where('package_type', '!=', 'trial')
                ->where('is_private', 0)
                ->orderBy('sort_order', 'asc')
                ->get();

            // 2. Fetch Pricing FAQs from global_settings.pricing_faqs
            $settings = function_exists('global_setting') ? global_setting() : GlobalSetting::first();
            $rawPricingFaqs = $settings ? $settings->pricing_faqs : [];

            if (is_string($rawPricingFaqs)) {
                $rawPricingFaqs = json_decode($rawPricingFaqs, true);
                if (is_string($rawPricingFaqs)) {
                    $rawPricingFaqs = json_decode($rawPricingFaqs, true);
                }
            }

            $pricingFaqs = is_array($rawPricingFaqs) ? array_values($rawPricingFaqs) : [];
            $pricingFaqs = array_values(array_filter($pricingFaqs, function ($f) {
                if (is_array($f) && isset($f['status'])) {
                    return $f['status'] === 'active';
                }
                return true;
            }));

            if (empty($pricingFaqs)) {
                $pricingFaqs = [
                    [
                        'id' => 1,
                        'question' => 'Can I change my plan later?',
                        'answer' => 'Yes, absolutely! You can upgrade, downgrade, or switch plans at any time from your dashboard. Changes take effect immediately.'
                    ],
                    [
                        'id' => 2,
                        'question' => 'Is there a free trial?',
                        'answer' => 'Yes! We offer a free trial plan so you can explore all premium features before committing. No credit card required to start your trial.'
                    ],
                    [
                        'id' => 3,
                        'question' => 'What payment methods are accepted?',
                        'answer' => 'We accept all major credit/debit cards, UPI, bank transfers, and popular payment gateways including Stripe, PayPal, and Razorpay.'
                    ],
                    [
                        'id' => 4,
                        'question' => 'Do I get a refund if I cancel?',
                        'answer' => 'We offer a 7-day refund policy for monthly plans and a 14-day refund policy for annual plans. Please contact our support team.'
                    ],
                    [
                        'id' => 5,
                        'question' => 'Can I manage multiple restaurant branches?',
                        'answer' => 'Yes! Our Professional and Enterprise plans support multiple branch management from a single super admin dashboard.'
                    ],
                    [
                        'id' => 6,
                        'question' => 'Is my data secure and backed up?',
                        'answer' => 'Absolutely. All data is encrypted with industry-standard SSL/TLS. We perform daily automated backups and maintain 99.9% uptime SLA.'
                    ]
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'packages'     => $packages,
                    'pricing_faqs' => $pricingFaqs
                ]
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}


