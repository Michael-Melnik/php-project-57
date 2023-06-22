<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::paginate(10);
        return view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('label.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate(
            $request,
            [
                'name' => 'required|unique:labels|max:255',
                'description' => 'max:300'
            ],
            [
                'name.unique' => __('validation.label.unique')
            ]
        );
        $label = new Label();
        $label->fill($validated);
        $label->save();
        flash(__('flashes.labels.store.success'))->success();

        return redirect()->route('labels.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        return view('label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $validated = $this->validate(
            $request,
            [
                'name' => 'required|unique:labels|max:255' . $label->id,
                'description' => 'max:300'
            ],
            [
                'name.unique' => __('validation.labels.unique')
            ]
        );

        $label->fill($validated);
        $label->save();
        flash(__('flashes.labels.updated'))->success();

        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash(__('flashes.labels.delete.error'))->error();
            return back();
        }
        $label->delete();
        flash(__('flashes.labels.deleted'))->success();
        return redirect()->route('labels.index');
    }
}
