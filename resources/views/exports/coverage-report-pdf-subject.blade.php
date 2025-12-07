<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Rapport de Couverture Pédagogique - Par Matière</title>
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

        h2 {
            color: #34495e;
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 2px solid #34495e;
            padding-bottom: 5px;
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

        .subject-summary {
            background-color: #ecf0f1;
            padding: 10px;
            margin-bottom: 10px;
            border-left: 4px solid #34495e;
        }

        .subject-name {
            font-weight: bold;
            font-size: 12px;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <h1>Rapport de Couverture Pédagogique - Par Matière</h1>

    <div class="meta">
        <p>Généré le: <strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
    </div>

    @forelse($data as $subject)
        <div class="subject-summary">
            <div class="subject-name">Matière: {{ $subject->name ?? 'N/A' }}</div>
            <small>Couverture globale: <strong>{{ $subject->coverage_percentage ?? 0 }}%</strong> |
                {{ $subject->programs_count ?? 0 }} programme(s) |
                {{ $subject->classes_count ?? 0 }} classe(s)</small>
        </div>

        <table>
            <thead>
                <tr style="background-color: #34495e; color: white;">
                    <th rowspan="2" style="vertical-align: middle;">CLASSE/<br>NIVEAU</th>

                    <!-- COUVERTURE DES HEURES -->
                    <th colspan="3" style="text-align: center; background-color: #2c3e50;">COUVERTURE DES HEURES</th>

                    <!-- COUVERTURE DES PROGRAMMES - LEÇONS -->
                    <th colspan="3" style="text-align: center; background-color: #2c3e50;">LEÇONS</th>

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
                @forelse($subject->classes_coverage as $classData)
                    <tr>
                        <td><strong>{{ $classData->class_name ?? 'N/A' }} ({{ $classData->level ?? 'N/A' }})</strong>
                        </td>

                        <!-- Heures -->
                        <td style="text-align: center;">{{ $classData->total_planned['hours'] ?? 0 }}</td>
                        <td style="text-align: center;">{{ $classData->total_done['hours'] ?? 0 }}</td>
                        <td
                            class="percentage 
                            @php
$pct = ($classData->total_planned['hours'] ?? 0) > 0 
                                    ? (($classData->total_done['hours'] ?? 0) / $classData->total_planned['hours']) * 100 
                                    : 0; @endphp
                            @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif">
                            {{ number_format($pct, 2) }}%
                        </td>

                        <!-- Leçons -->
                        <td style="text-align: center;">{{ $classData->total_planned['lesson'] ?? 0 }}</td>
                        <td style="text-align: center;">{{ $classData->total_done['lesson'] ?? 0 }}</td>
                        <td
                            class="percentage 
                            @php
$pct = ($classData->total_planned['lesson'] ?? 0) > 0 
                                    ? (($classData->total_done['lesson'] ?? 0) / $classData->total_planned['lesson']) * 100 
                                    : 0; @endphp
                            @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif">
                            {{ number_format($pct, 2) }}%
                        </td>

                        <!-- Leçons Digitalisées -->
                        <td style="text-align: center;">{{ $classData->total_planned['lesson_dig'] ?? 0 }}</td>
                        <td style="text-align: center;">{{ $classData->total_done['lesson_dig'] ?? 0 }}</td>
                        <td
                            class="percentage 
                            @php
$pct = ($classData->total_planned['lesson_dig'] ?? 0) > 0 
                                    ? (($classData->total_done['lesson_dig'] ?? 0) / $classData->total_planned['lesson_dig']) * 100 
                                    : 0; @endphp
                            @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif">
                            {{ number_format($pct, 2) }}%
                        </td>

                        <!-- TP -->
                        <td style="text-align: center;">{{ $classData->total_planned['tp'] ?? 0 }}</td>
                        <td style="text-align: center;">{{ $classData->total_done['tp'] ?? 0 }}</td>
                        <td
                            class="percentage 
                            @php
$pct = ($classData->total_planned['tp'] ?? 0) > 0 
                                    ? (($classData->total_done['tp'] ?? 0) / $classData->total_planned['tp']) * 100 
                                    : 0; @endphp
                            @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif">
                            {{ number_format($pct, 2) }}%
                        </td>

                        <!-- TP Digitalisés -->
                        <td style="text-align: center;">{{ $classData->total_planned['tp_dig'] ?? 0 }}</td>
                        <td style="text-align: center;">{{ $classData->total_done['tp_dig'] ?? 0 }}</td>
                        <td
                            class="percentage 
                            @php
$pct = ($classData->total_planned['tp_dig'] ?? 0) > 0 
                                    ? (($classData->total_done['tp_dig'] ?? 0) / $classData->total_planned['tp_dig']) * 100 
                                    : 0; @endphp
                            @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif">
                            {{ number_format($pct, 2) }}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="16" style="text-align: center; padding: 20px;">Aucune donnée pour cette matière
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Totaux pour la matière -->
        <table style="width: 50%; margin-left: auto; margin-right: 0; margin-bottom: 30px;">
            <thead>
                <tr style="background-color: #34495e; color: white;">
                    <th colspan="2" style="text-align: center;">TOTAL - {{ $subject->name ?? 'N/A' }}</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: #d5dbdb;">
                    <td><strong>Heures</strong></td>
                    <td>{{ $subject->total_planned['hours'] ?? 0 }} prévues / {{ $subject->total_done['hours'] ?? 0 }}
                        faites
                        <span
                            class="percentage 
                            @php
$pct = ($subject->total_planned['hours'] ?? 0) > 0 
                                    ? (($subject->total_done['hours'] ?? 0) / $subject->total_planned['hours']) * 100 
                                    : 0; @endphp
                            @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif">
                            ({{ number_format($pct, 2) }}%)
                        </span>
                    </td>
                </tr>
                <tr style="background-color: #ecf0f1;">
                    <td><strong>Leçons</strong></td>
                    <td>{{ $subject->total_planned['lesson'] ?? 0 }} prévues /
                        {{ $subject->total_done['lesson'] ?? 0 }} faites
                        <span
                            class="percentage 
                            @php
$pct = ($subject->total_planned['lesson'] ?? 0) > 0 
                                    ? (($subject->total_done['lesson'] ?? 0) / $subject->total_planned['lesson']) * 100 
                                    : 0; @endphp
                            @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif">
                            ({{ number_format($pct, 2) }}%)
                        </span>
                    </td>
                </tr>
                <tr style="background-color: #d5dbdb;">
                    <td><strong>TP</strong></td>
                    <td>{{ $subject->total_planned['tp'] ?? 0 }} prévus / {{ $subject->total_done['tp'] ?? 0 }}
                        réalisés
                        <span
                            class="percentage 
                            @php
$pct = ($subject->total_planned['tp'] ?? 0) > 0 
                                    ? (($subject->total_done['tp'] ?? 0) / $subject->total_planned['tp']) * 100 
                                    : 0; @endphp
                            @if ($pct >= 80) high @elseif($pct >= 50) medium @else low @endif">
                            ({{ number_format($pct, 2) }}%)
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    @empty
        <div style="text-align: center; padding: 40px;">
            <p>Aucune donnée disponible pour les matières sélectionnées.</p>
        </div>
    @endforelse

    <div class="footer">
        <p>Ce rapport a été généré automatiquement par le système de gestion pédagogique.</p>
    </div>
</body>

</html>
