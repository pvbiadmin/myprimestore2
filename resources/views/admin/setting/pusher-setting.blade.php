<div class="tab-pane fade" id="list-pusher" role="tabpanel" aria-labelledby="pusher-setting">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.pusher-setting-update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method( 'PUT' )
                <div class="form-group">
                    <label for="pusher_app_id">Pusher App ID</label>
                    <input type="text" class="form-control" id="pusher_app_id" name="pusher_app_id"
                           value="{{ $pusher_setting?->pusher_app_id ?? old('pusher_app_id') }}">
                </div>

                <div class="form-group">
                    <label for="pusher_key">Pusher Key</label>
                    <input type="text" class="form-control" id="pusher_key"
                           name="pusher_key" value="{{ $pusher_setting?->pusher_key ?? old('pusher_key') }}">
                </div>

                <div class="form-group">
                    <label for="pusher_secret">Pusher Key</label>
                    <input type="text" class="form-control" id="pusher_secret" name="pusher_secret"
                           value="{{ $pusher_setting?->pusher_secret ?? old('pusher_secret') }}">
                </div>

                <div class="form-group">
                    <label for="pusher_cluster">Pusher Cluster</label>
                    <input type="text" class="form-control" id="pusher_cluster" name="pusher_cluster"
                           value="{{ $pusher_setting?->pusher_cluster ?? old('pusher_cluster') }}">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
