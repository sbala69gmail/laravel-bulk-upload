<html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>
    body{
        margin: 20% auto;
    }
</style>

<body>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (Session::has('alert-success'))
    <div class="alert alert-success">
    {{ Session::get("alert-success") }}
    </div>
@endif

{!! Form::open(['route' => 'upload', 'files' => true]) !!}


    <div class="container">

        <div class="row">
            <div class="col-lg-6">
                {{ Form::file('upload', null, ['class' => "form-control", "id" => "upload"]) }}
                @error('upload')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-lg-6">
                <input type="submit" class="form-control btn btn-primary">
            </div>
        </div>
    </div>
{!! Form::close() !!}

</body>
</html>

