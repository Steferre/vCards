<h1>ciao dalla pagina index</h1>
@foreach($promoters as $promoter)
<span>{{ $promoter->name }}</span>
<a href="{{ route('showcase.show', $promoter->code) }}">vai al singolo promoter</a>
<br>

@endforeach