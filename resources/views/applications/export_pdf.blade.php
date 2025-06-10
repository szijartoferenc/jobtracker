<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Álláspályázati jelentkezések</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead {
            background-color: #f0f0f0;
        }
        th, td {
            border: 1px solid #666;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .redflag {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Álláspályázati jelentkezések</h2>

    <table>
        <thead>
            <tr>
                <th>Cég</th>
                <th>Pozíció</th>
                <th>Dátum</th>
                <th>Státusz</th>
                <th>Redflag</th>
                <th>Jegyzet</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $app)
            <tr>
                <td>{{ $app->company }}</td>
                <td>{{ $app->position }}</td>
                <td>{{ $app->applied_at ? \Carbon\Carbon::parse($app->applied_at)->format('Y.m.d') : '' }}</td>
                <td>{{ $app->status }}</td>
                <td class="{{ $app->redflag ? 'redflag' : '' }}">
                    {{ $app->redflag ? '⚠️ Igen' : 'Nem' }}
                </td>
                <td>{{ $app->notes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
