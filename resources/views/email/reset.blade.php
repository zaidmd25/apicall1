<form name="form" method="POST" action="{{ url('/reset/form') }}">
	<input type="password" class="form-control" name="password">
	<input type="password" class="form-control" name="password_confirmation">
	<input type="hidden" name="token" value="{{ $token }}">
	<input type="hidden"  name="email" value="{{ $email }}">
</form>