<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <!-- Add any necessary CSS or styles here -->
</head>
<body>
<h1>{{ $title }}</h1>

@isset($projects)
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nazwa </th>
            <th>Początek</th>
            <th>Koniec</th>
            <th>Opis</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($projects as $project)
            <tr>
                <td>{{ $project['projectName'] }}</td>
                <td>{{ \Carbon\Carbon::parse($project['projectStart'])->format('d/m/Y')  }}</td>
                <td>{{ \Carbon\Carbon::parse($project['projectEnd'])->format('d/m/Y')  }}</td>
                <td>{{ $project['projectDescription'] }}</td>
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
    <!-- Add the content you want in the PDF here -->
</body>
</html>
