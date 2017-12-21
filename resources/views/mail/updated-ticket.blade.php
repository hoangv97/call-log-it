<!DOCTYPE html>
<html>
<head>
    <title>[Call Log IT] Thông báo</title>
</head>
<body>
<p>
    Chào {{ $receiver->name }},
    <br><br>
    Nhân viên: {{ $changer->name }} đã thay đổi thông tin của yêu cầu: <a href="{{ route('request.edit', ['id' => $ticket->id]) }}" target="_blank">{{ $ticket->subject }}</a>.
    {!! $signature !!}
</p>
</body>
</html>