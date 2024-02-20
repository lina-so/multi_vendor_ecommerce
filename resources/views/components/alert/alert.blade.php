
@if (session()->has($type))
<div class="alert alert-{{$type}}  text-center" role="alert">
    {{ session($type) }}
</div>
@endif

