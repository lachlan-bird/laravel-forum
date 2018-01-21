@component('profiles.activities.activity')
    @slot('heading')
    <a href="{{ route('profile', $profileUser) }}">{{ $profileUser->name }}</a> replied to 
    <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
    @endslot

    @slot('date')
        {{ $activity->subject->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent