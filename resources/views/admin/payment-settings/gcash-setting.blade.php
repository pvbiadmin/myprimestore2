<div class="tab-pane fade show active" id="list-gcash" role="tabpanel" aria-labelledby="list-gcash-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.gcash-setting.update', 1) }}" method="POST">
                @csrf
                @method( 'PUT' )
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option {{ @$gcashSetting->status === 1 ? 'selected' : '' }} value="1">Enable</option>
                        <option {{ @$gcashSetting->status === 0 ? 'selected' : '' }} value="0">Disable</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{!! @$gcashSetting->name !!}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="number">Number</label>
                            <input type="text" name="number" id="number" class="form-control"
                                   value="{!! @$gcashSetting->number !!}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
