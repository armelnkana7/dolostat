<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Rapport de Couverture Pédagogique - Par Classe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .meta {
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }

        thead {
            background-color: #34495e;
            color: white;
        }

        th {
            padding: 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #bdc3c7;
            font-size: 9px;
        }

        td {
            padding: 8px;
            border: 1px solid #bdc3c7;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #ecf0f1;
        }

        tbody tr:hover {
            background-color: #d5dbdb;
        }

        .percentage {
            text-align: center;
            font-weight: bold;
        }

        .percentage.high {
            color: #27ae60;
        }

        .percentage.medium {
            color: #f39c12;
        }

        .percentage.low {
            color: #e74c3c;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #95a5a6;
            border-top: 1px solid #bdc3c7;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Rapport de Couverture Pédagogique - Par Classe</h1>

    <div class="meta">
        <p>Généré le: <strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
    </div>

    <table>
        <thead>
            <tr style="background-color: #34495e; color: white;">
                <th rowspan="2" style="vertical-align: middle;">CLASSES/NIV<br>EAU</th>

                <!-- COUVERTURE DES HEURES -->
                <th colspan="3" style="text-align: center; background-color: #2c3e50;">COUVERTURE DES HEURES</th>

                <!-- COUVERTURE DES PROGRAMMES - LEÇONS -->
                <th colspan="3" style="text-align: center; background-color: #2c3e50;">COUVERTURE DES PROGRAMMES</th>

                <!-- COUVERTURE DES PROGRAMMES - LEÇONS DIGITALISÉES -->
                <th colspan="3" style="text-align: center; background-color: #2c3e50;">LEÇONS DIGITALISÉES</th>

                <!-- RÉALISATION DES TRAVAUX PRATIQUES -->
                <th colspan="3" style="text-align: center; background-color: #2c3e50;">TP</th>

                <!-- TP DIGITALISÉS -->
                <th colspan="3" style="text-align: center; background-color: #2c3e50;">TP DIGITALISÉS</th>
            </tr>
            <tr style="background-color: #34495e; color: white;">
                <th style="text-align: center; font-size: 11px;">PRÉVUES</th>
                <th style="text-align: center; font-size: 11px;">FAITES</th>
                <th style="text-align: center; font-size: 11px;">%</th>

                <th style="text-align: center; font-size: 11px;">PRÉVUS</th>
                <th style="text-align: center; font-size: 11px;">FAITS</th>
                <th style="text-align: center; font-size: 11px;">%</th>

                <th style="text-align: center; font-size: 11px;">PRÉVUES</th>
                <th style="text-align: center; font-size: 11px;">FAITES</th>
                <th style="text-align: center; font-size: 11px;">%</th>

                <th style="text-align: center; font-size: 11px;">PRÉVUS</th>
                <th style="text-align: center; font-size: 11px;">RÉALISÉS</th>
                <th style="text-align: center; font-size: 11px;">%</th>

                <th style="text-align: center; font-size: 11px;">PRÉVUS</th>
                <th style="text-align: center; font-size: 11px;">RÉALISÉS</th>
                <th style="text-align: center; font-size: 11px;">%</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $schoolClass)
                <tr>
                    <td><strong>{{ $schoolClass->name ?? 'N/A' }}</strong></td>

                    <!-- Heures -->
                    <td style="text-align: center;">{{ $schoolClass->total_planned['hours'] ?? 0 }}</td>
                    <td style="text-align: center;">{{ $schoolClass->total_done['hours'] ?? 0 }}</td>
                    <td class="percentage 
                        @php
$pct = ($schoolClass->total_planned['hours'] ?? 0) > 0 
                                ? (($schoolClass->total_done['hours'] ?? 0) / $schoolClass->total_planned['hours']) * 100 
                                : 0; @endphp
                        @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif"
                        style="text-align: center;">
                        {{ number_format($pct, 2) }}%
                    </td>

                    <!-- Leçons -->
                    <td style="text-align: center;">{{ $schoolClass->total_planned['lesson'] ?? 0 }}</td>
                    <td style="text-align: center;">{{ $schoolClass->total_done['lesson'] ?? 0 }}</td>
                    <td class="percentage 
                        @php
$pct = ($schoolClass->total_planned['lesson'] ?? 0) > 0 
                                ? (($schoolClass->total_done['lesson'] ?? 0) / $schoolClass->total_planned['lesson']) * 100 
                                : 0; @endphp
                        @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif"
                        style="text-align: center;">
                        {{ number_format($pct, 2) }}%
                    </td>

                    <!-- Leçons Digitalisées -->
                    <td style="text-align: center;">{{ $schoolClass->total_planned['lesson_dig'] ?? 0 }}</td>
                    <td style="text-align: center;">{{ $schoolClass->total_done['lesson_dig'] ?? 0 }}</td>
                    <td class="percentage 
                        @php
$pct = ($schoolClass->total_planned['lesson_dig'] ?? 0) > 0 
                                ? (($schoolClass->total_done['lesson_dig'] ?? 0) / $schoolClass->total_planned['lesson_dig']) * 100 
                                : 0; @endphp
                        @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif"
                        style="text-align: center;">
                        {{ number_format($pct, 2) }}%
                    </td>

                    <!-- TP -->
                    <td style="text-align: center;">{{ $schoolClass->total_planned['tp'] ?? 0 }}</td>
                    <td style="text-align: center;">{{ $schoolClass->total_done['tp'] ?? 0 }}</td>
                    <td class="percentage 
                        @php
$pct = ($schoolClass->total_planned['tp'] ?? 0) > 0 
                                ? (($schoolClass->total_done['tp'] ?? 0) / $schoolClass->total_planned['tp']) * 100 
                                : 0; @endphp
                        @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif"
                        style="text-align: center;">
                        {{ number_format($pct, 2) }}%
                    </td>

                    <!-- TP Digitalisés -->
                    <td style="text-align: center;">{{ $schoolClass->total_planned['tp_dig'] ?? 0 }}</td>
                    <td style="text-align: center;">{{ $schoolClass->total_done['tp_dig'] ?? 0 }}</td>
                    <td class="percentage 
                        @php
$pct = ($schoolClass->total_planned['tp_dig'] ?? 0) > 0 
                                ? (($schoolClass->total_done['tp_dig'] ?? 0) / $schoolClass->total_planned['tp_dig']) * 100 
                                : 0; @endphp
                        @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif"
                        style="text-align: center;">
                        {{ number_format($pct, 2) }}%
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" style="text-align: center; color: #7f8c8d;">Aucune donnée disponible</td>
                </tr>
            @endforelse

            @if ($data && count($data) > 0)
                @php
                    $totalPlanned = ['hours' => 0, 'lesson' => 0, 'lesson_dig' => 0, 'tp' => 0, 'tp_dig' => 0];
                    $totalDone = ['hours' => 0, 'lesson' => 0, 'lesson_dig' => 0, 'tp' => 0, 'tp_dig' => 0];

                    foreach ($data as $schoolClass) {
                        $totalPlanned['hours'] += $schoolClass->total_planned['hours'] ?? 0;
                        $totalPlanned['lesson'] += $schoolClass->total_planned['lesson'] ?? 0;
                        $totalPlanned['lesson_dig'] += $schoolClass->total_planned['lesson_dig'] ?? 0;
                        $totalPlanned['tp'] += $schoolClass->total_planned['tp'] ?? 0;
                        $totalPlanned['tp_dig'] += $schoolClass->total_planned['tp_dig'] ?? 0;

                        $totalDone['hours'] += $schoolClass->total_done['hours'] ?? 0;
                        $totalDone['lesson'] += $schoolClass->total_done['lesson'] ?? 0;
                        $totalDone['lesson_dig'] += $schoolClass->total_done['lesson_dig'] ?? 0;
                        $totalDone['tp'] += $schoolClass->total_done['tp'] ?? 0;
                        $totalDone['tp_dig'] += $schoolClass->total_done['tp_dig'] ?? 0;
                    }
                @endphp

                <tr style="background-color: #34495e; color: white; font-weight: bold;">
                    <td>TOTAL GÉNÉRAL</td>

                    <!-- Heures Total -->
                    <td style="text-align: center;">{{ $totalPlanned['hours'] }}</td>
                    <td style="text-align: center;">{{ $totalDone['hours'] }}</td>
                    <td style="text-align: center;">
                        {{ number_format($totalPlanned['hours'] > 0 ? ($totalDone['hours'] / $totalPlanned['hours']) * 100 : 0, 2) }}%
                    </td>

                    <!-- Leçons Total -->
                    <td style="text-align: center;">{{ $totalPlanned['lesson'] }}</td>
                    <td style="text-align: center;">{{ $totalDone['lesson'] }}</td>
                    <td style="text-align: center;">
                        {{ number_format($totalPlanned['lesson'] > 0 ? ($totalDone['lesson'] / $totalPlanned['lesson']) * 100 : 0, 2) }}%
                    </td>

                    <!-- Leçons Digitalisées Total -->
                    <td style="text-align: center;">{{ $totalPlanned['lesson_dig'] }}</td>
                    <td style="text-align: center;">{{ $totalDone['lesson_dig'] }}</td>
                    <td style="text-align: center;">
                        {{ number_format($totalPlanned['lesson_dig'] > 0 ? ($totalDone['lesson_dig'] / $totalPlanned['lesson_dig']) * 100 : 0, 2) }}%
                    </td>

                    <!-- TP Total -->
                    <td style="text-align: center;">{{ $totalPlanned['tp'] }}</td>
                    <td style="text-align: center;">{{ $totalDone['tp'] }}</td>
                    <td style="text-align: center;">
                        {{ number_format($totalPlanned['tp'] > 0 ? ($totalDone['tp'] / $totalPlanned['tp']) * 100 : 0, 2) }}%
                    </td>

                    <!-- TP Digitalisés Total -->
                    <td style="text-align: center;">{{ $totalPlanned['tp_dig'] }}</td>
                    <td style="text-align: center;">{{ $totalDone['tp_dig'] }}</td>
                    <td style="text-align: center;">
                        {{ number_format($totalPlanned['tp_dig'] > 0 ? ($totalDone['tp_dig'] / $totalPlanned['tp_dig']) * 100 : 0, 2) }}%
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Ce rapport a été généré automatiquement par le système de gestion académique.</p>
    </div>
</body>

</html>
