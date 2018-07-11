    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form name="form" method="POST" action="{{url('api/resetpassword')}}">
	Password:<input type="password" class="form-control" name="password"><br>
	PasswordConfirmation<input type="password" class="form-control" name="password_confirmation"><br>
	<input type="hidden" name="token" value="{{ $token }}">
	<input type="hidden"  name="email" value="{{ $email }}">
	<button type="submit" >submit</button>
</form>