<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Export Classes</title>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Niveau</th>
                <th>Département</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $class)
                <tr>
                    <td>{{ $class->id }}</td>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->level }}</td>
                    <td>{{ $class->department->name ?? 'N/A' }}</td>
                    <td>{{ $class->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
