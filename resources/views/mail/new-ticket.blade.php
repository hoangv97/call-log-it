<!DOCTYPE html>
<html>
<head>
    <title>[Call Log IT] Thông báo</title>
</head>
<body>
    <p>
        Chào {{ $receiver->name }},
        <br><br>
        Bạn có liên quan đến một yêu cầu mới: <a href="{{ route('request.edit', ['id' => $ticket->id]) }}" target="_blank">{{ $ticket->subject }}</a>, được gửi từ nhân viên: {{ $ticket->creator->name }}.
        {!! $signature !!}
    </p>
</body>
</html>