<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class MediaController extends Controller
{
    private function generateImageName($extension)
    {
        return Str::random(10) . '.' . $extension;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media = Media::all();
        return response()->json(['media' => $media]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpg,png,svg|max:10240',
        ]);
        $image = $request->name;
        $media = new Media();
        if ($image) {
            $imageName = $this->generateImageName($image->extension());
            $imagePath = $image->storeAs('public/upload/' . date('Y/m/d'), $imageName);
            $imageUrl = Storage::url($imagePath);
            $media->name = $imageName;
            $media->path = $imagePath;
            $media->url = $imageUrl;
        }
        $media->save();
        $response = [
            'message' => 'Media uploaded successfully',
            'media' => $media,
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $media  = Media::find($id);
        return response()->json($media);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'image|mimes:jpg,png,svg|max:10240',
        ]);
        $image = $request->name;
        $media = Media::find($id);
        if ($image) {
            if ($media->name) {
                Storage::delete($media->path);
            }
            $imageName = $this->generateImageName($image->extension());
            $imagePath = $image->storeAs('public/upload/' . date('Y/m/d'), $imageName);
            $imageUrl = Storage::url($imagePath);
            $media->name = $imageName;
            $media->path = $imagePath;
            $media->url = $imageUrl;
            $media->save();
            $response = [
                'message' => 'Media updated successfully',
                'media' => $media,
            ];
            return response()->json($response);
        }
        return response()->json($media);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = media::find($id);
        Storage::delete($media->path);
        $media->delete();

        return response()->json([
            'message' => 'Media deleted successfully'
        ]);
    }
}
