<div class="tab-pane fade" id="logo-setting" role="tabpanel" aria-labelledby="logo-setting">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method( 'PUT' )
                <div class="row">
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-group">
                            <p><img src="{{ asset(@$logo_settings->logo) }}" width="150px"
                                    alt="site-logo" style="background-color: #999;"></p>
                            <label>Logo</label>
                            <input type="file" class="form-control" name="logo">
                            <input type="hidden" class="form-control" name="old_logo"
                                   value="{{ @$logo_settings->logo }}">
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-group">
                            <p><img src="{{ asset(@$logo_settings->favicon) }}" width="150px"
                                    alt="favicon-logo" style="background-color: #999;"></p>
                            <label>Favicon</label>
                            <input type="file" class="form-control" name="favicon">
                            <input type="hidden" class="form-control" name="old_favicon"
                                   value="{{ @$logo_settings->favicon }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
