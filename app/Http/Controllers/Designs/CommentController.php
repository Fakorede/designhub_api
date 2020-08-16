<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Repositories\Contracts\CommentInterface;
use App\Repositories\Contracts\DesignInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $comment;
    protected $design;

    public function __construct(CommentInterface $comment, DesignInterface $design)
    {
        $this->comment = $comment;
        $this->design = $design;
    }

    public function store(Request $request, $designId)
    {
        $this->validate($request, [
            'body' => ['required'],
        ]);

        $comment = $this->design->addComment($designId, [
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return new CommentResource($comment);

    }

    public function update(Request $request, $id)
    {
        $comment = $this->comment->find($id);
        $this->authorize('update', $comment);

        $this->validate($request, [
            'body' => ['required'],
        ]);

        $comment = $this->comment->update($id, [
            'body' => $request->body
        ]);

        return new CommentResource($comment);
    }

    public function destroy($id)
    {
        $comment = $this->comment->find($id);
        $this->authorize('delete', $comment);

        $this->comment->delete($id);

        return response()->json([
            'message' => 'Comment successfully deleted!'
        ], 200);
    }
}
