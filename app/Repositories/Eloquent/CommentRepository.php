<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Repositories\Contracts\CommentInterface;
use App\Repositories\Eloquent\BaseRepository;

class CommentRepository extends BaseRepository implements CommentInterface
{
    public function model()
    {
        return Comment::class;
    }
}
