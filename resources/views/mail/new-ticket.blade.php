<!DOCTYPE html>
<html>
<head>
    <title>[Call Log IT] Thông báo</title>
</head>
<body>
    <h3>Chào {{ $ticket->assignee->name }},</h3>
    <p>
        Bạn có một yêu cầu mới: <a href="{{ route('request.edit', ['id' => $ticket->id]) }}" target="_blank">{{ $ticket->subject }}</a>, được gửi từ nhân viên: {{ $ticket->creator->name }}.
    </p>
</body>
</html>