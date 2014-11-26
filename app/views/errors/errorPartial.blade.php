@if ($errors->has('success'))
    <div class="notification success">
        <h2>Success!</h2>
        <ul>
            @foreach ($errors->get('success') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($errors->has('warn'))
    <div class="notification warn">
        <h2>Warning:</h2>
        <ul>
            @foreach ($errors->get('warn') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($errors->has('errors'))
    <div class="notification error">
        <h2>Errors Occurred!</h2>
        <ul>
            @foreach ($errors->get('errors') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

