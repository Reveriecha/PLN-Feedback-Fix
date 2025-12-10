<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Feedback Inovasi PLN</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; color: #0891b2; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #0891b2; color: white; }
    </style>
</head>
<body>
    <h1>Laporan Feedback Inovasi PLN</h1>
    <p>Tanggal: {{ date('d-m-Y') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Unit</th>
                <th>Inovasi</th>
                <th>Rating</th>
                <th>Feedback</th>
                <th>Saran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $index => $feedback)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $feedback->nama }}</td>
                <td>{{ $feedback->nip }}</td>
                <td>{{ $feedback->unit->nama_unit }}</td>
                <td>{{ $feedback->inovasi->nama_inovasi }}</td>
                <td>{{ $feedback->average_rating }}/5</td>
                <td>{{ $feedback->feedback ?? '-' }}</td>
                <td>{{ $feedback->saran ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>