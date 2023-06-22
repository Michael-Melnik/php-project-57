@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="mb-5">@lang('views.label.index.header')</h1>

        <div>
            @can('create', App\Models\Label::class)
                <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    @lang('views.label.index.create_button')
                </a>
            @endcan
        </div>

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>@lang('views.label.index.id')</th>
                <th>@lang('views.label.index.name')</th>
                <th>@lang('views.label.index.description')</th>
                <th>@lang('views.label.index.created_at')</th>
                @can('seeActions', App\Models\Label::class)
                    <th>@lang('views.label.index.actions')</th>
                @endcan
            </tr>
            </thead>
            @foreach($labels as $label)
                <tr class="border-b border-dashed text-left">
                    <td>{{ $label->id }}</td>
                    <td>{{ $label->name }}</td>
                    <td>{{ $label->description }}</td>
                    <td>{{ $label->created_at->format('d.m.Y') }}</td>
                    <td>
                        @canany(['delete', 'update'], $label)
                            <a
                                data-confirm="@lang('views.label.index.delete_confirmation')"
                                data-method="delete"
                                class="text-red-600 hover:text-red-900"
                                href="{{ route('labels.destroy', $label) }}"
                            >
                                @lang('views.label.index.delete')
                            </a>
                            <a class="text-blue-600 hover:text-blue-900" href="{{ route('labels.edit', $label) }}">
                                @lang('views.label.index.edit')
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $labels->links() }}
    </div>
@endsection


{{--<x-app-layout>--}}
{{--    <h1 class="mb-5">Метки</h1>--}}
{{--    @auth()--}}
{{--        <div>--}}
{{--            <a href="{{ route('labels.create') }}"--}}
{{--               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">--}}
{{--                Создать метку </a>--}}
{{--        </div>--}}
{{--    @endauth--}}
{{--    <table class="mt-4">--}}
{{--        <thead class="border-b-2 border-solid border-black text-left">--}}
{{--        <tr>--}}
{{--            <th>ID</th>--}}
{{--            <th>Имя</th>--}}
{{--            <th>Описание</th>--}}
{{--            <th>Дата создания</th>--}}
{{--            @auth()--}}
{{--                <th>Действия</th>--}}
{{--            @endauth--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @if(!empty($labels))--}}
{{--            @foreach($labels as $index => $label)--}}
{{--                <tr class="border-b border-dashed text-left">--}}
{{--                    <td>{{ $index + 1 }}</td>--}}
{{--                    <td>{{ $label->name }}</td>--}}
{{--                    <td>{{ $label->description }}</td>--}}
{{--                    <td>{{ date('d.m.Y', strtotime($label->created_at)) }}</td>--}}
{{--                    @auth()--}}
{{--                        <td>--}}
{{--                            <a class="text-red-600 hover:text-red-900"--}}
{{--                               rel="nofollow" data-method="delete"--}}
{{--                               data-confirm="Вы уверены?"--}}
{{--                               href="{{ route('labels.destroy', $label->id) }}">--}}
{{--                                Удалить--}}
{{--                            </a>--}}
{{--                            <a href="{{ route('labels.edit', $label->id) }}" class="text-blue-600 hover:text-blue-900">--}}
{{--                                Изменить--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                    @endauth--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--</x-app-layout>--}}
