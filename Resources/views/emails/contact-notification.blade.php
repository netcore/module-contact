<h3>
    New message in contact form
</h3>
@foreach($data as $key => $value)
    <b>{{ $key }}: </b> {{ $value }}<br>
@endforeach