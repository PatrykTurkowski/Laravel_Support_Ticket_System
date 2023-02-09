<?php

namespace App\Http\Controllers;

use App\Http\Requests\Label\StoreLabelRequest;
use App\Http\Requests\Label\UpdateLabelRequest;
use App\Models\Label;
use App\Tables\LabelTable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use ProtoneMedia\Splade\Facades\Toast;

class LabelController extends Controller
{
    /**
     * authorizeResource cooperate with policy and gates.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $labels = LabelTable::class;

        return view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {

        return view('Label.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLabelRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreLabelRequest $request): RedirectResponse
    {
        $label = new Label($request->validated());

        $label->save();

        return redirect()->route('labels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Label  $label
     * @return View
     */
    public function show(Label $label): View
    {
        return view('label.show', compact('label'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Label $label
     * @return View
     */
    public function edit(Label $label): View
    {

        return view('label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLabelRequest  $request
     * @param  Label $label
     * @return RedirectResponse
     */
    public function update(UpdateLabelRequest $request, Label $label): RedirectResponse
    {
        $label->fill($request->validated());
        $label->save();

        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return RedirectResponse
     */
    public function destroy(Label $label): RedirectResponse
    {
        $label->delete();

        return redirect()->route('labels.index');
    }


    /**
     *  Restore Label
     * 
     * Label $label
     * 
     * @return RedirectResponse
     */
    public function restore(Label $label): RedirectResponse
    {
        $label->restore();
        return redirect()->route('labels.index');
    }
}