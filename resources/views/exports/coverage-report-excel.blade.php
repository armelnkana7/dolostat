<table>
    <thead>
        <tr>
            <th rowspan="2" style="vertical-align: middle; background:#34495E; color:#fff; padding:6px;">
                CLASSES/<br>NIVEAU</th>

            <!-- COUVERTURE DES HEURES -->
            <th colspan="3" style="background:#2C3E50; color:#fff; padding:6px;">COUVERTURE DES HEURES</th>

            <!-- COUVERTURE DES PROGRAMMES - LEÇONS -->
            <th colspan="3" style="background:#2C3E50; color:#fff; padding:6px;">COUVERTURE DES PROGRAMMES</th>

            <!-- COUVERTURE DES PROGRAMMES - LEÇONS DIGITALISÉES -->
            <th colspan="3" style="background:#2C3E50; color:#fff; padding:6px;">LEÇONS DIGITALISÉES</th>

            <!-- RÉALISATION DES TRAVAUX PRATIQUES -->
            <th colspan="3" style="background:#2C3E50; color:#fff; padding:6px;">TP</th>

            <!-- TP DIGITALISÉS -->
            <th colspan="3" style="background:#2C3E50; color:#fff; padding:6px;">TP DIGITALISÉS</th>
        </tr>
        <tr>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">PRÉVUES</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">FAITES</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">%</th>

            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">PRÉVUS</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">FAITS</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">%</th>

            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">PRÉVUES</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">FAITES</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">%</th>

            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">PRÉVUS</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">RÉALISÉS</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">%</th>

            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">PRÉVUS</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">RÉALISÉS</th>
            <th style="background:#34495E; color:#fff; padding:4px; font-size:10px">%</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
            <tr>
                <td><strong>{{ $item['name'] ?? 'N/A' }}</strong></td>

                <!-- Heures -->
                <td>{{ $item['total_planned']['hours'] ?? 0 }}</td>
                <td>{{ $item['total_done']['hours'] ?? 0 }}</td>
                <td
                    class="percentage 
                        @if ((($item['total_done']['hours'] ?? 0) / max($item['total_planned']['hours'] ?? 1, 1)) * 100 >= 80) high
                        @elseif((($item['total_done']['hours'] ?? 0) / max($item['total_planned']['hours'] ?? 1, 1)) * 100 >= 50) medium
                        @else low @endif">
                    {{ number_format(($item['total_planned']['hours'] ?? 0) > 0 ? (($item['total_done']['hours'] ?? 0) / $item['total_planned']['hours']) * 100 : 0, 2) }}%
                </td>

                <!-- Leçons -->
                <td>{{ $item['total_planned']['lesson'] ?? 0 }}</td>
                <td>{{ $item['total_done']['lesson'] ?? 0 }}</td>
                <td
                    class="percentage 
                        @if ((($item['total_done']['lesson'] ?? 0) / max($item['total_planned']['lesson'] ?? 1, 1)) * 100 >= 80) high
                        @elseif((($item['total_done']['lesson'] ?? 0) / max($item['total_planned']['lesson'] ?? 1, 1)) * 100 >= 50) medium
                        @else low @endif">
                    {{ number_format(($item['total_planned']['lesson'] ?? 0) > 0 ? (($item['total_done']['lesson'] ?? 0) / $item['total_planned']['lesson']) * 100 : 0, 2) }}%
                </td>

                <!-- Leçons Digitalisées -->
                <td>{{ $item['total_planned']['lesson_dig'] ?? 0 }}</td>
                <td>{{ $item['total_done']['lesson_dig'] ?? 0 }}</td>
                <td
                    class="percentage 
                        @if ((($item['total_done']['lesson_dig'] ?? 0) / max($item['total_planned']['lesson_dig'] ?? 1, 1)) * 100 >= 80) high
                        @elseif((($item['total_done']['lesson_dig'] ?? 0) / max($item['total_planned']['lesson_dig'] ?? 1, 1)) * 100 >= 50) medium
                        @else low @endif">
                    {{ number_format(($item['total_planned']['lesson_dig'] ?? 0) > 0 ? (($item['total_done']['lesson_dig'] ?? 0) / $item['total_planned']['lesson_dig']) * 100 : 0, 2) }}%
                </td>

                <!-- TP -->
                <td>{{ $item['total_planned']['tp'] ?? 0 }}</td>
                <td>{{ $item['total_done']['tp'] ?? 0 }}</td>
                <td
                    class="percentage 
                        @if ((($item['total_done']['tp'] ?? 0) / max($item['total_planned']['tp'] ?? 1, 1)) * 100 >= 80) high
                        @elseif((($item['total_done']['tp'] ?? 0) / max($item['total_planned']['tp'] ?? 1, 1)) * 100 >= 50) medium
                        @else low @endif">
                    {{ number_format(($item['total_planned']['tp'] ?? 0) > 0 ? (($item['total_done']['tp'] ?? 0) / $item['total_planned']['tp']) * 100 : 0, 2) }}%
                </td>

                <!-- TP Digitalisés -->
                <td>{{ $item['total_planned']['tp_dig'] ?? 0 }}</td>
                <td>{{ $item['total_done']['tp_dig'] ?? 0 }}</td>
                <td
                    class="percentage 
                        @if ((($item['total_done']['tp_dig'] ?? 0) / max($item['total_planned']['tp_dig'] ?? 1, 1)) * 100 >= 80) high
                        @elseif((($item['total_done']['tp_dig'] ?? 0) / max($item['total_planned']['tp_dig'] ?? 1, 1)) * 100 >= 50) medium
                        @else low @endif">
                    {{ number_format(($item['total_planned']['tp_dig'] ?? 0) > 0 ? (($item['total_done']['tp_dig'] ?? 0) / $item['total_planned']['tp_dig']) * 100 : 0, 2) }}%
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

                foreach ($data as $item) {
                    $totalPlanned['hours'] += $item['total_planned']['hours'] ?? 0;
                    $totalPlanned['lesson'] += $item['total_planned']['lesson'] ?? 0;
                    $totalPlanned['lesson_dig'] += $item['total_planned']['lesson_dig'] ?? 0;
                    $totalPlanned['tp'] += $item['total_planned']['tp'] ?? 0;
                    $totalPlanned['tp_dig'] += $item['total_planned']['tp_dig'] ?? 0;

                    $totalDone['hours'] += $item['total_done']['hours'] ?? 0;
                    $totalDone['lesson'] += $item['total_done']['lesson'] ?? 0;
                    $totalDone['lesson_dig'] += $item['total_done']['lesson_dig'] ?? 0;
                    $totalDone['tp'] += $item['total_done']['tp'] ?? 0;
                    $totalDone['tp_dig'] += $item['total_done']['tp_dig'] ?? 0;
                }
            @endphp

            <tr class="total-row">
                <td>TOTAL GÉNÉRAL</td>

                <!-- Heures Total -->
                <td>{{ $totalPlanned['hours'] }}</td>
                <td>{{ $totalDone['hours'] }}</td>
                <td>
                    {{ number_format($totalPlanned['hours'] > 0 ? ($totalDone['hours'] / $totalPlanned['hours']) * 100 : 0, 2) }}%
                </td>

                <!-- Leçons Total -->
                <td>{{ $totalPlanned['lesson'] }}</td>
                <td>{{ $totalDone['lesson'] }}</td>
                <td>
                    {{ number_format($totalPlanned['lesson'] > 0 ? ($totalDone['lesson'] / $totalPlanned['lesson']) * 100 : 0, 2) }}%
                </td>

                <!-- Leçons Digitalisées Total -->
                <td>{{ $totalPlanned['lesson_dig'] }}</td>
                <td>{{ $totalDone['lesson_dig'] }}</td>
                <td>
                    {{ number_format($totalPlanned['lesson_dig'] > 0 ? ($totalDone['lesson_dig'] / $totalPlanned['lesson_dig']) * 100 : 0, 2) }}%
                </td>

                <!-- TP Total -->
                <td>{{ $totalPlanned['tp'] }}</td>
                <td>{{ $totalDone['tp'] }}</td>
                <td>
                    {{ number_format($totalPlanned['tp'] > 0 ? ($totalDone['tp'] / $totalPlanned['tp']) * 100 : 0, 2) }}%
                </td>

                <!-- TP Digitalisés Total -->
                <td>{{ $totalPlanned['tp_dig'] }}</td>
                <td>{{ $totalDone['tp_dig'] }}</td>
                <td>
                    {{ number_format($totalPlanned['tp_dig'] > 0 ? ($totalDone['tp_dig'] / $totalPlanned['tp_dig']) * 100 : 0, 2) }}%
                </td>
            </tr>
        @endif
    </tbody>
</table>
