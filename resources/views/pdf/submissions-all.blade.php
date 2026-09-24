<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1a1a1a; padding: 28px; }

        .header { text-align: center; margin-bottom: 24px; border-bottom: 2px solid #B1CF6F; padding-bottom: 14px; }
        .header h1 { font-size: 18px; font-weight: bold; color: #13432D; }
        .header p { font-size: 10px; color: #666; margin-top: 4px; }

        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .meta-table td { padding: 5px 8px; font-size: 10px; }
        .meta-table td:first-child { font-weight: bold; color: #555; width: 120px; }
        .meta-table tr:nth-child(even) td { background: #f8f8f8; }

        .section-title { font-size: 12px; font-weight: bold; color: #13432D; margin-bottom: 8px; border-left: 4px solid #B1CF6F; padding-left: 8px; }

        table.submissions { width: 100%; border-collapse: collapse; }
        table.submissions th { background: #B1CF6F; color: #13432D; padding: 7px 10px; text-align: left; font-size: 10px; }
        table.submissions td { padding: 7px 10px; font-size: 10px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        table.submissions tr:nth-child(even) td { background: #f9fafb; }

        .footer { margin-top: 24px; border-top: 1px solid #ddd; padding-top: 8px; font-size: 9px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $form->title }} &mdash; All Submissions</h1>
        <p>Generated {{ now()->format('d M Y, H:i') }} &bull; {{ $submissions->count() }} total responses</p>
    </div>

    <table class="meta-table">
        <tr>
            <td>School</td>
            <td>{{ $form->school->name }}</td>
        </tr>
        <tr>
            <td>Tour Date</td>
            <td>{{ $form->tour_date?->format('d M Y') ?? '-' }}</td>
        </tr>
        <tr>
            <td>Form ID</td>
            <td>{{ $form->nanoid }}</td>
        </tr>
    </table>

    <div class="section-title">Responses</div>

    <table class="submissions">
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Submitted At</th>
                @foreach($questions as $q)
                    <th>{{ $q->question }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $i => $submission)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $submission->user->name }}</td>
                    <td>{{ $submission->submitted_at?->format('d M Y') ?? '-' }}</td>
                    @foreach($questions as $q)
                        @php
                            $ans = $submission->answers->firstWhere('question_id', $q->id);
                            $value = $ans?->answer;
                            if (is_array($value)) {
                                $display = implode(', ', array_map(fn($i) => is_array($i) ? ($i['name'] ?? json_encode($i)) : $i, $value));
                            } else {
                                $display = $value ?? '-';
                            }
                        @endphp
                        <td>{{ $display }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ $form->title }} &bull; {{ $form->school->name }} &bull; Form ID: {{ $form->nanoid }}
    </div>
</body>
</html>
