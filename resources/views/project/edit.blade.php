@extends('layouts/mbt')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/project/update" method="post" id="project-form" name="project-form" enctype="multipart/form-data">

        @csrf
        @foreach($project as $item)
            @if (!empty($item->id))
                <input type="hidden" name="id" value="{{$item->id}}">
            @endif
            <div class="pt-3">
                <label for="projectName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nazwa
                    projektu</label>
                <input type="text" id="projectName" name="projectName" value="{{$item->projectName}}"
                       class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="pt-3">
                <label for="projectStart" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Początek
                    projektu</label>
                <input type="date" id="projectStart" name="projectStart"
                       value="{{\Carbon\Carbon::parse($item->projectStart)->format('Y-m-d')}}"
                       class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="pt-3">
                <label for="projectEnd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Koniec
                    projektu</label>
                <input type="date" id="projectEnd" name="projectEnd"
                       value="{{\Carbon\Carbon::parse($item->projectEnd)->format('Y-m-d')}}"
                       class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="pt-3 ">
                <label for="projectDescription" class="block mb-2  text-sm font-medium text-gray-900 dark:text-white">Opis
                    projektu</label>
                <textarea id="projectDescription" name="projectDescription"
                          class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{$item->projectDescription}}
            </textarea>
            </div>
            <div class="pt-3">
                <label for="projectFile" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nazwa
                    projektu</label>
                <input type="file" id="projectFile" name="projectFile"
                       class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        @endforeach
        <div class="pt-3 text-center">
            <input type="submit" value="Zapisz"/>

        </div>

    </form>
@endsection
