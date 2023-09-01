@extends('layouts/mbt')

@section('content')
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
            @foreach($projects as $project)
                <tr>
                    <td>{{$project['projectName']}}</td>
                    <td>{{$project['projectStart']}}</td>
                    <td>{{$project['projectEnd']}}</td>
                    <td>{{$project['projectDescription']}}</td>
                    <td><a href="/project/edit/{{$project['id']}}">Edytuj</a></td>
                    <td>
                        <a href="#formodal" data-id="{{$project['id']}}" class="openSendModal" data-toggle="modal"
                           data-target="#mailmodal">Wyślij</a>
                    </td>
                    <td><a href="/project/delete/{{$project['id']}}">Usuń</a></td>
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
        <div class="modal fade" id="mailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/project/send" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>


                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="projectId" id="projectId" value="">
                            <input type="email" name="projectEmail" id="projectEmail" >
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            <input type="submit" class="btn btn-primary" id="sendEmailProject">Wyślij</input>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endsection
