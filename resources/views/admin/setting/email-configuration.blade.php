<div class="tab-pane fade" id="email-config" role="tabpanel" aria-labelledby="email-config">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.settings.email.update') }}" method="POST">
                @csrf
                @method ( 'PUT' )
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email"
                           id="email" value="{{ $email_settings?->email ?? old('email') }}">
                </div>

                <div class="form-group">
                    <label for="host">Mail Host</label>
                    <input type="text" class="form-control" name="host"
                           id="host" value="{{ $email_settings?->host ?? old('host') }}">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">SMTP Username</label>
                            <input type="text" class="form-control" name="username"
                                   id="username" value="{{ $email_settings?->username ?? old('username') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">SMTP Password</label>
                            <input type="text" class="form-control" name="password"
                                   id="password" value="{{ $email_settings?->password ?? old('password') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="port">Mail Port</label>
                            <input type="text" class="form-control" name="port"
                                   id="port" value="{{ $email_settings?->port ?? old('port') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="encryption">Mail Encryption</label>
                            <select name="encryption" id="encryption" class="form-control">
                                <option value="tls" @selected(
                                    ($email_settings?->encryption ?? old('encryption')) == 'ssl' )>TLS
                                </option>
                                <option value="ssl" @selected(
                                    ($email_settings?->encryption ?? old('encryption')) == 'ssl' )>SSL
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
