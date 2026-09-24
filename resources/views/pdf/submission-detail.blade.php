<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1a1a; padding: 32px; }

        .header { text-align: center; margin-bottom: 28px; border-bottom: 2px solid #B1CF6F; padding-bottom: 16px; }
        .header h1 { font-size: 20px; font-weight: bold; color: #13432D; }
        .header p { font-size: 11px; color: #666; margin-top: 4px; }

        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .meta-table td { padding: 6px 10px; font-size: 11px; }
        .meta-table td:first-child { font-weight: bold; color: #555; width: 140px; }
        .meta-table tr:nth-child(even) td { background: #f8f8f8; }

        .section-title { font-size: 13px; font-weight: bold; color: #13432D; margin-bottom: 10px; border-left: 4px solid #B1CF6F; padding-left: 8px; }

        .answer-row { margin-bottom: 12px; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 4px; }
        .answer-row .question { font-weight: bold; font-size: 11px; color: #374151; margin-bottom: 4px; }
        .answer-row .answer { font-size: 12px; color: #1a1a1a; }

        .footer { margin-top: 32px; border-top: 1px solid #ddd; padding-top: 10px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $form->title }}</h1>
        <p>Form Submission Detail &mdash; Generated {{ now()->format('d M Y, H:i') }}</p>
    </div>

    <table class="meta-table">
        <tr>
            <td>Student</td>
            <td>{{ $submission->user->name }}</td>
        </tr>
        <tr>
            <td>Username</td>
            <td>{{ $submission->user->username }}</td>
        </tr>
        <tr>
            <td>School</td>
            <td>{{ $form->school->name }}</td>
        </tr>
        <tr>
            <td>Tour Date</td>
            <td>{{ $form->tour_date?->format('d F Y') ?? '-' }}</td>
        </tr>
        <tr>
            <td>Submitted At</td>
            <td>{{ $submission->submitted_at?->format('d M Y, H:i') ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Answers</div>

    @foreach($submission->answers as $answer)
        <div class="answer-row">
            <div class="question">{{ $loop->iteration }}. {{ $answer->question->question }}</div>
            <div class="answer">
                @php
                    $value = $answer->answer;
                    if (is_array($value)) {
                        echo implode(', ', array_map(fn($i) => is_array($i) ? ($i['name'] ?? json_encode($i)) : $i, $value));
                    } else {
                        echo e($value);
                    }
                @endphp
            </div>
        </div>
    @endforeach

    <div class="footer">
        {{ $form->title }} &bull; {{ $form->school->name }} &bull; Form ID: {{ $form->nanoid }}
    </div>
</body>
</html>
