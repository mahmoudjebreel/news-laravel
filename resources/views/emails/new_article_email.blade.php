@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => route('home')])
Read Now
@endcomponent

@component('mail::panel')
    Read the new Article! - {{$article->title}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
