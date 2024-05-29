<div class="tab-pane fade show active" id="list-settings" role="tabpanel"
     aria-labelledby="list-settings-list">
    <div class="card border">
        <div class="card-body">
            <form method="post" action="{{ route('admin.unilevel.settings.update', 1) }}">
                @csrf
                @method ( 'PUT' )
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bonus">Bonus (%)</label>
                            <input type="text" name="bonus" id="bonus" class="form-control"
                                   value="{{ @$unilevelSettings?->bonus ?? old('bonus') }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
