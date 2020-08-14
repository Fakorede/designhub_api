<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use App\Models\Design;
use App\Repositories\Contracts\DesignInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DesignController extends Controller
{
    protected $designs;

    public function __construct(DesignInterface $designs)
    {
        $this->designs = $designs;
    }

    public function index()
    {
        $designs = $this->designs->all();
        return DesignResource::collection($designs);
    }

    public function update(Request $request, $id)
    {
        $design = Design::findOrFail($id);

        $this->authorize('update', $design);

        $this->validate($request, [
            'title' => ['required', 'unique:designs,title,' . $id],
            'description' => ['required', 'string', 'min:20', 'max:140'],
            'tags' => ['required'],
        ]);

        $design->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'is_live' => !$design->upload_successful ? false : $request->is_live,
        ]);

        // apply tags
        $design->retag($request->tags);

        return new DesignResource($design);
    }

    public function destroy(Request $request, $id)
    {
        $design = Design::findOrFail($id);
        $this->authorize('delete', $design);

        // delete associated files
        foreach (['thumbnail', 'large', 'original'] as $size) {
            // check if file exists
            $path = "uploads/designs/${size}/" . $design->image;
            if (Storage::disk($design->disk)->exists($path)) {
                Storage::disk($design->disk)->delete($path);
            }
        }

        $design->delete();

        return response()->json(['message' => 'Design successfully deleted!'], 200);
    }
}