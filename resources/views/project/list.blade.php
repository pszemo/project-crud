@extends('layouts/mbt')

@section('content')

    <form id="filterForm" action="{{ route('project.filter') }}" method="GET">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="projectName">Nazwa Projektu:</label>
                    <input type="text" id="projectName" name="projectName" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="startDateFrom">Początek projektu OD:</label>
                    <input type="date" id="startDateFrom" name="startDateFrom" class="form-control">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="startDateTo">Początek projektu DO:</label>
                    <input type="date" id="startDateTo" name="startDateTo" class="form-control">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label for="endDateFrom">Koniec projektu OD:</label>
                    <input type="date" id="endDateFrom" name="endDateFrom" class="form-control">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="endDateTo">Koniec projektu DO:</label>
                    <input type="date" id="endDateTo" name="endDateTo" class="form-control">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Filtruj:</button>
    </form>
    @isset($projects)
        <table class="table">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Project Start</th>
                    <th>Project End</th>
                    <th>Project Description</th>
                    <th colspan="3" class="text-center">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project['projectName'] }}</td>
                        <td>{{ $project['projectStart'] }}</td>
                        <td>{{ $project['projectEnd'] }}</td>
                        <td>{{ $project['projectDescription'] }}</td>
                        <td><a href="/project/edit/{{ $project['id'] }}">Edytuj</a></td>
                        <td>
                            <a href="#formodal" data-id="{{ $project['id'] }}" class="openSendModal" data-toggle="modal"
                                data-target="#mailModal">Wyślij</a>
                        </td>
                        <td><a href="/project/delete/{{ $project['id'] }}">Usuń</a></td>
                    </tr>
                @endforeach
            @endisset
            @empty($projects)
                <tr>
                    <td>brak danych</td>
                </tr>
            @endempty
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="labelModalSendProject"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="sendEmailForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="labelModalSendProject">Wyślij szczegóły</h5>


                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="projectId" id="projectId" value="">
                        <input type="email" name="projectEmail" id="projectEmail">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                        <button type="button" class="btn btn-primary" id="sendEmailProject">Wyślij</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
