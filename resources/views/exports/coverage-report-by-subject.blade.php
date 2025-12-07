<table>
    <thead>
        <tr style="background:#34495E; color:#fff; padding:6px;">
            <th colspan="16" style="text-align:left; padding:8px;">
                RAPPORT DE COUVERTURE PAR MATIÈRE
            </th>
        </tr>
        <tr>
            <th rowspan="2" style="vertical-align: middle; background:#34495E; color:#fff; padding:6px;">
                MATIÈRE/<br>CLASSE</th>

            <!-- COUVERTURE DES HEURES -->
            <th colspan="3" style="background:#2C3E50; color:#fff; padding:6px;">COUVERTURE DES HEURES</th>

            <!-- COUVERTURE DES PROGRAMMES - LEÇONS -->
            <th colspan="3" style="background:#2C3E50; color:#fff; padding:6px;">LEÇONS</th>

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
        @forelse($data as $subject)
            <!-- Subject header row -->
            <tr style="background:#ECF0F1; font-weight:bold;">
                <td colspan="16" style="padding:8px;">
                    <strong>Matière: {{ $subject->name ?? 'N/A' }}</strong>
                    - Couverture: {{ $subject->coverage_percentage ?? 0 }}%
                    | {{ $subject->programs_count ?? 0 }} programme(s)
                    | {{ $subject->classes_count ?? 0 }} classe(s)
                </td>
            </tr>

            <!-- Classes for this subject -->
            @forelse($subject->classes_coverage as $classData)
                <tr>
                    <td><strong>{{ $classData->class_name ?? 'N/A' }} ({{ $classData->level ?? 'N/A' }})</strong></td>

                    <!-- Heures -->
                    <td>{{ $classData->total_planned['hours'] ?? 0 }}</td>
                    <td>{{ $classData->total_done['hours'] ?? 0 }}</td>
                    <td>
                        @php
                            $percentage =
                                ($classData->total_planned['hours'] ?? 0) > 0
                                    ? (($classData->total_done['hours'] ?? 0) / $classData->total_planned['hours']) *
                                        100
                                    : 0;
                        @endphp
                        {{ number_format($percentage, 2) }}%
                    </td>

                    <!-- Leçons -->
                    <td>{{ $classData->total_planned['lesson'] ?? 0 }}</td>
                    <td>{{ $classData->total_done['lesson'] ?? 0 }}</td>
                    <td>
                        @php
                            $percentage =
                                ($classData->total_planned['lesson'] ?? 0) > 0
                                    ? (($classData->total_done['lesson'] ?? 0) / $classData->total_planned['lesson']) *
                                        100
                                    : 0;
                        @endphp
                        {{ number_format($percentage, 2) }}%
                    </td>

                    <!-- Leçons Digitalisées -->
                    <td>{{ $classData->total_planned['lesson_dig'] ?? 0 }}</td>
                    <td>{{ $classData->total_done['lesson_dig'] ?? 0 }}</td>
                    <td>
                        @php
                            $percentage =
                                ($classData->total_planned['lesson_dig'] ?? 0) > 0
                                    ? (($classData->total_done['lesson_dig'] ?? 0) /
                                            $classData->total_planned['lesson_dig']) *
                                        100
                                    : 0;
                        @endphp
                        {{ number_format($percentage, 2) }}%
                    </td>

                    <!-- TP -->
                    <td>{{ $classData->total_planned['tp'] ?? 0 }}</td>
                    <td>{{ $classData->total_done['tp'] ?? 0 }}</td>
                    <td>
                        @php
                            $percentage =
                                ($classData->total_planned['tp'] ?? 0) > 0
                                    ? (($classData->total_done['tp'] ?? 0) / $classData->total_planned['tp']) * 100
                                    : 0;
                        @endphp
                        {{ number_format($percentage, 2) }}%
                    </td>

                    <!-- TP Digitalisés -->
                    <td>{{ $classData->total_planned['tp_dig'] ?? 0 }}</td>
                    <td>{{ $classData->total_done['tp_dig'] ?? 0 }}</td>
                    <td>
                        @php
                            $percentage =
                                ($classData->total_planned['tp_dig'] ?? 0) > 0
                                    ? (($classData->total_done['tp_dig'] ?? 0) / $classData->total_planned['tp_dig']) *
                                        100
                                    : 0;
                        @endphp
                        {{ number_format($percentage, 2) }}%
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" style="text-align:center; padding:10px;">
                        Aucune donnée pour cette matière
                    </td>
                </tr>
            @endforelse

            <!-- Total row for this subject -->
            <tr style="background:#D5DBDB; font-weight:bold;">
                <td><strong>TOTAL {{ $subject->name ?? 'N/A' }}</strong></td>

                <!-- Heures -->
                <td>{{ $subject->total_planned['hours'] ?? 0 }}</td>
                <td>{{ $subject->total_done['hours'] ?? 0 }}</td>
                <td>
                    @php
                        $percentage =
                            ($subject->total_planned['hours'] ?? 0) > 0
                                ? (($subject->total_done['hours'] ?? 0) / $subject->total_planned['hours']) * 100
                                : 0;
                    @endphp
                    {{ number_format($percentage, 2) }}%
                </td>

                <!-- Leçons -->
                <td>{{ $subject->total_planned['lesson'] ?? 0 }}</td>
                <td>{{ $subject->total_done['lesson'] ?? 0 }}</td>
                <td>
                    @php
                        $percentage =
                            ($subject->total_planned['lesson'] ?? 0) > 0
                                ? (($subject->total_done['lesson'] ?? 0) / $subject->total_planned['lesson']) * 100
                                : 0;
                    @endphp
                    {{ number_format($percentage, 2) }}%
                </td>

                <!-- Leçons Digitalisées -->
                <td>{{ $subject->total_planned['lesson_dig'] ?? 0 }}</td>
                <td>{{ $subject->total_done['lesson_dig'] ?? 0 }}</td>
                <td>
                    @php
                        $percentage =
                            ($subject->total_planned['lesson_dig'] ?? 0) > 0
                                ? (($subject->total_done['lesson_dig'] ?? 0) / $subject->total_planned['lesson_dig']) *
                                    100
                                : 0;
                    @endphp
                    {{ number_format($percentage, 2) }}%
                </td>

                <!-- TP -->
                <td>{{ $subject->total_planned['tp'] ?? 0 }}</td>
                <td>{{ $subject->total_done['tp'] ?? 0 }}</td>
                <td>
                    @php
                        $percentage =
                            ($subject->total_planned['tp'] ?? 0) > 0
                                ? (($subject->total_done['tp'] ?? 0) / $subject->total_planned['tp']) * 100
                                : 0;
                    @endphp
                    {{ number_format($percentage, 2) }}%
                </td>

                <!-- TP Digitalisés -->
                <td>{{ $subject->total_planned['tp_dig'] ?? 0 }}</td>
                <td>{{ $subject->total_done['tp_dig'] ?? 0 }}</td>
                <td>
                    @php
                        $percentage =
                            ($subject->total_planned['tp_dig'] ?? 0) > 0
                                ? (($subject->total_done['tp_dig'] ?? 0) / $subject->total_planned['tp_dig']) * 100
                                : 0;
                    @endphp
                    {{ number_format($percentage, 2) }}%
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="16" style="text-align:center; padding:20px;">
                    Aucune donnée disponible
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
