<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stores</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h1>Stores</h1>
        <table class="table">
            <tr>
                <th>Store URL</th>
                <th></th>
            </tr>
            @foreach($stores as $store)
            <tr>
                <td>{{ $store->url }}</td>
                <td><a href='{{ $store->webhooksUrl }}'>Webhooks</a></td>
            </tr>
            @endforeach
        </table>

        <h1>Add a store</h1>
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
                Store successfully authed and added.
            </div>
        @endif

        {!! Form::open() !!}
            <div class="row">
                <div class="col-xs-12">
                    {!! Form::label('url', 'Store URL') !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-10">
                    {!! Form::text('url', null, array('class' => 'form-control col-xs-10')) !!}
                </div>
                <div class="col-xs-2">
                    {!! Form::submit('Add', array('class' => 'btn btn-primary btn-block col-xs-2')) !!}
                </div>
            </div>
        {!! Form::close() !!}

    </div>

</body>
</html>
