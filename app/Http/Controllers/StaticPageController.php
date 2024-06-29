<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StaticPage;

class StaticPageController extends Controller
{
    public function getPage($name, Request $request)
    {
        // Determine the language from the request or use a default language
        $lang = $request->header('lang', 'en');

        // Find the static page by name and language
        $staticPage = StaticPage::where('name', $name)->first();

        if (!$staticPage) {
            return response()->json(['error' => 'Static page not found'], 404);
        }

        // Determine the title and description based on the language
        $title = $lang === 'ar' ? $staticPage->title_ar : $staticPage->title_en;
        $description = $lang === 'ar' ? $staticPage->desc_ar : $staticPage->desc_en;

        // Return the static page data
        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' =>[
                'title' => $title,
                'description' => $description,
                'is_active' => $staticPage->is_active,
            ]
        ]);

    }
}
