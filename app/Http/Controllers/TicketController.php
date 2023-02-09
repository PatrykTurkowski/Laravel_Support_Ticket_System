<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Models\Category;
use App\Models\CategoryTicket;
use App\Models\Comment;
use App\Models\File;
use App\Models\Label;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use App\Tables\TicketTable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Contracts\Activity;
use ProtoneMedia\Splade\FileUploads\ExistingFile;
use Spatie\Activitylog\Facades\LogBatch;

class TicketController extends Controller
{
    /**
     * authorizeResource cooperate with policy and gates.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Ticket::class, 'ticket');
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {

        $tickets = TicketTable::class;
        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $priorities = Priority::all()->pluck('name', 'id')->toArray();
        $labels = Label::all()->pluck('name', 'id')->toArray();
        $categories = Category::all()->pluck('name', 'id')->toArray();
        return view('ticket.create', compact('priorities', 'labels', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTicketRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreTicketRequest $request): RedirectResponse
    {
        LogBatch::startBatch();
        $ticket = new Ticket($request->validated());

        $ticket->categoryTicket();
        $ticket->save();
        $ticket->categoryTicketLog($request->category_id);
        $ticket->labelTicketLog($request->label_id);
        $ticket->addFiles($request);
        $ticket->save();
        LogBatch::endBatch();

        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Ticket  $ticket
     * @return View
     */
    public function show(Ticket $ticket): View
    {
        $bufor = File::where('ticket_id', $ticket->id)->get();
        $files = [];
        foreach ($bufor as $key => $item) {
            array_push($files, ExistingFile::fromDisk('s3')->get($item->path, $item->previewUrl, ['filename' => $item->name]));
            $files[$key]->filename = $item->name;
        }
        $comments = Comment::select('comments.*', 'users.name as name')
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->where('comments.ticket_id', '=', ':ticket')
            ->setBindings(
                [':ticket' => $ticket->id]
            )->get();
        $agents = User::where('role', RoleEnum::AGENT->value)->pluck('name', 'id')->toArray();
        $priorities = Priority::all()->pluck('name', 'id')->toArray();
        $labels = Label::all()->pluck('name', 'id')->toArray();
        $categories = Category::all()->pluck('name', 'id')->toArray();
        $statuses = Status::all()->pluck('name', 'id')->toArray();
        return view('ticket.show', compact('ticket', 'priorities', 'labels', 'categories', 'agents', 'comments', 'statuses', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Ticket $ticket
     * @return View
     */
    public function edit(Ticket $ticket): View
    {

        $bufor = File::where('ticket_id', $ticket->id)->get();
        $files = [];
        foreach ($bufor as $key => $item) {
            array_push($files, ExistingFile::fromDisk('s3')->get($item->path, $item->previewUrl, ['filename' => $item->name]));
            $files[$key]->filename = $item->name;
        }
        $agents = User::where('role', RoleEnum::AGENT->value)->pluck('name', 'id')->toArray();
        $priorities = Priority::all()->pluck('name', 'id')->toArray();
        $labels = Label::all()->pluck('name', 'id')->toArray();
        $categories = Category::all()->pluck('name', 'id')->toArray();
        $statuses = Status::all()->pluck('name', 'id')->toArray();
        return view('ticket.edit', compact('ticket', 'priorities', 'labels', 'categories', 'agents', 'statuses', 'files'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTicketRequest  $request
     * @param  Ticket  $ticket
     * @return RedirectResponse
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket): RedirectResponse
    {

        $ticket->fill($request->validated());
        $ticket->categories()->detach();
        $ticket->labels()->detach();
        $ticket->categoryTicketLog($request->category_id);
        $ticket->labelTicketLog($request->label_id);
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {

                $ticket->files()->create([
                    'name' => $file->getClientOriginalName(),
                    'path' => 'files/' . $file->hashname(),
                    'ticket_id' => $ticket->id
                ]);
                Storage::disk('s3')->put('files', $file);
            }
        }
        $ticket->save();

        return redirect()->route('tickets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Ticket  $ticket
     * @return RedirectResponse
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }


    /**
     *  Restore Ticket
     * 
     * Ticket $ticket
     * 
     * @return RedirectResponse
     */
    public function restore(Ticket $ticket): RedirectResponse
    {
        $ticket->restore();
        return redirect()->route('tickets.index');
    }
}