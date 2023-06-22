@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="mb-5">@lang('views.label.edit.form_header')</h1>

        {{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH', 'class' => 'w-50']) }}
        <div class="flex flex-col">
            <div>
                {{ Form::label('name', __('views.label.edit.labels.name')) }}
            </div>
            <div class="mt-2">
                {{ Form::text('name', $label->name, ['class' => 'rounded border-gray-300 w-1/3']) }}
            </div>
            @error('name')
            <div class="text-rose-600">{{ $message }}</div>
            @enderror
            <div class="mt-2">
                {{ Form::label('description', __('views.label.edit.labels.description')) }}
            </div>
            <div class="mt-2">
                {{ Form::textarea('description', null, ['class' => 'rounded border-gray-300 w-1/3 h-32']) }}
            </div>
            @error('description')
            <div class="text-rose-600">{{ $message }}</div>
            @enderror
            <div class="mt-2">
                {{ Form::submit(__('views.label.edit.buttons.update'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection
