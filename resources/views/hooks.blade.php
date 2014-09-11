<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Webhooks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h1>Webhooks</h1>
        <table class="table">
            <tr>
                <th>Topic</th>
                <th>Address</th>
                <th>Format</th>
            </tr>
            @foreach($hooks as $hook)
            <tr>
                <td>{{ $hook->topic }}</td>
                <td>{{ $hook->address }}</td>
                <td>{{ $hook->format }}</td>
            </tr>
            @endforeach
        </table>

        <h1>Add a webhook</h1>
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        @if (\Session::has('success'))
            <div class="alert alert-success" role="alert">
                The webhook was successfully added.
            </div>
        @endif

        {!! Form::open(array('class' => 'form-horizontal')) !!}

            <div class="form-group">
                {!! Form::label('topic', 'Topic', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('topic', null, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('address', 'Address', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::text('address', null, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('format', 'Format', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::select('format', array('json' => 'json', 'xml' => 'xml'), null, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-sm-offset-8 col-sm-2">
                    {!! Form::submit('Add', array('class' => 'btn btn-primary btn-block col-xs-2')) !!}
                </div>
            </div>
        {!! Form::close() !!}

    </div>

</body>
</html>
