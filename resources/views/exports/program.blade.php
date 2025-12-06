<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Programmes d'études</h1>
        @if ($establishment)
            <p><strong>Établissement:</strong> {{ $establishment->name }}</p>
            <p><strong>Code:</strong> {{ $establishment->code }}</p>
        @endif
        @if ($class)
            <p><strong>Classe:</strong> {{ $class->name }}</p>
            <p><strong>Niveau:</strong> {{ $class->level }}</p>
        @endif
        <p><strong>Date:</strong> {{ now()->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Matière</th>
                <th>Code</th>
                <th>Heures/Semaine</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programs as $key => $program)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $program->subject?->name }}</td>
                    <td>{{ $program->subject?->code }}</td>
                    <td>{{ $program->hours_per_week }}</td>
                    <td>{{ $program->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">Aucun programme trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
