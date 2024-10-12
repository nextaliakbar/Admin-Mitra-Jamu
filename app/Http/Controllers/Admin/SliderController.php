<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();

        return view('pages.CMS.slider.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'path' => ['required'],
        ]);

        $slider = Slider::create([
            'title' => $request->title,
            'image' => $request->path,
            'link' => $request->link,
            'status' => $request->status ? true : false,
            'order' => $request->order ? $request->order : 0,
            'layout' => $request->layout ? $request->layout : 'desktop',
        ]);

        return response()->json([
            'status' => true,
            'data' => $slider,
        ]);
    }

    public function edit(Slider $slider)
    {
        return response()->json([
            'status' => true,
            'data' => $slider,
        ]);
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'path' => ['required'],
        ]);

        $slider->update([
            'title' => $request->title,
            'image' => $request->path,
            'link' => $request->link,
            'status' => $request->status ? true : false,
            'order' => $request->order ? $request->order : 0,
            'layout' => $request->layout ? $request->layout : 'desktop',
        ]);

        return response()->json([
            'status' => true,
            'data' => $slider,
        ]);
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();

        return response()->json([
            'status' => true,
            'data' => $slider,
        ]);
    }
}
