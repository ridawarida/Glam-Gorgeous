<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function edit()
    {
        $contents = Content::whereIn('key', [
            'home_hero_title',
            'home_hero_subtitle',
            'home_hero_button',
            'home_about_title',
            'home_about_text',
            'home_about_button',
            'home_contact_title',
            'home_contact_text',
            'home_address'
        ])->get()->pluck('value', 'key')->toArray();
        
        return view('admin.content.edit', compact('contents'));
    }
    
    public function update(Request $request)
    {
        $fields = [
            'home_hero_title', 'home_hero_subtitle', 'home_hero_button',
            'home_about_title', 'home_about_text', 'home_about_button',
            'home_contact_title', 'home_contact_text', 'home_address'
        ];
        
        foreach ($fields as $field) {
            if ($request->has($field)) {
                Content::setValue($field, $request->input($field));
            }
        }
        
        return redirect()->route('admin.content.edit')
            ->with('success', 'Homepage content updated successfully!');
    }
}