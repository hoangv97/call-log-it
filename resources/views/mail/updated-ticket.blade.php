<!DOCTYPE html>
<html>
<head>
    <title>[Call Log IT] Thông báo</title>
</head>
<body>
    <h3>Chào {{ $ticket->assignee->name }},</h3>
    <p>
        Nhân viên: {{ $ticket->creator->name }} đã thay đổi thông tin của yêu cầu: <a href="{{ route('request.edit', ['id' => $ticket->id]) }}" target="_blank">{{ $ticket->subject }}</a>.
    </p>
</body>
</html>