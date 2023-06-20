@component('mail::message')
# Welcome In News Website
We hope you will be enjoyed with our articles, Let's start!.

@component('mail::button', ['url' => route('home')])
Go To Website
@endcomponent

@component('mail::panel')
Read the title: {{$article->title}}
@endcomponent

@component('mail::table')
    | Laravel       | Table         | Example  |
    |: ------------- |:-------------:| --------:|
    | Col 2 is      | Centered      | $10      |
    | Col 3 is      | Right-Aligned | $20      |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
