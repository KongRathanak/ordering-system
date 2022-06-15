@extends(backpack_view('layouts.top_left'))



@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('backpackmodule.name') !!}
    </p>
    
@endsection
