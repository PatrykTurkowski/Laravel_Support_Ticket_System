<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\storeCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;

class CommentController extends Controller
{
    /**
     * Store the specified resource in storage.
     *
     * @param  StoreCommentRequest  $request
     * @param  Ticket $ticket
     * @return RedirectResponse
     */
    public function store(Ticket $ticket, storeCommentRequest $request)
    {
        $ticket->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return View
     */
    public function edit(Comment $comment): View
    {
        return view('comment.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCommentRequest $request
     * @param  Comment  $comment
     * @return RedirectResponse
     */
    public function update(UpdateCommentRequest $request, Comment $comment): RedirectResponse
    {

        $comment->update([
            'content' => $request->input('content')
        ]);
        $comment->save();


        return redirect()->back();
    }
}