@php(Carbon::setLocale('vi'))

@if(isset($ticket))
    <div class="mt-comment">
        <div class="mt-comment-img">
            <img src="{{ is_null($ticket->creator->avatar_url) ? '../'.Constant::DEFAULT_AVATAR_URL : route('home').'/'.$ticket->creator->avatar_url }}" />
        </div>
        <div class="mt-comment-body">
            <div class="mt-comment-info">
                <span class="mt-comment-author">{{ $ticket->creator->name }}</span>
                <span class="mt-comment-date">
                    <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $ticket->created_at->diffForHumans() }}
                </span>
            </div>
            <div class="mt-comment-text">
                {!! is_null($ticket->image_url) ? '' : "<img src='".route('home').'/'."$ticket->image_url' class='img-thumbnail'><br/><br/>" !!}
                {!! $ticket->content !!}
            </div>
        </div>
    </div>
@elseif(isset($comment))
    <div class="mt-comment">
        <div class="mt-comment-img">
            <img src="{{ is_null($comment->employee->avatar_url) ? '../'.Constant::DEFAULT_AVATAR_URL : route('home').'/'.$comment->employee->avatar_url }}" />
        </div>
        <div class="mt-comment-body">
            <div class="mt-comment-info">
                <span class="mt-comment-author">{{ $comment->employee->name }}</span>
                <span class="mt-comment-date">
                    <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at->diffForHumans() }}
                </span>
            </div>
            <div class="mt-comment-text">
                {!! is_null($comment->note) ? $comment->content : $comment->note !!}
            </div>
        </div>
    </div>
@endif