@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Referral Settings</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.referral.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Referral Setting</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.referral.update', $referralSetting->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method( 'PUT' )
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="package">Package</label>
                                            <select name="package" id="package" class="form-control">
                                                <option value="">Select</option>
                                                @foreach( $packages as $package )
                                                    <option value="{{ $package->id }}" {{ (string) (old('package')
                                                        ?? $referralSetting->package) === (string) $package->id
                                                            ? 'selected' : '' }}>{{ $package->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bonus">Bonus (%)</label>
                                            <input type="text" name="bonus" id="bonus" class="form-control"
                                                   value="{{ old('bonus') ?? $referralSetting->bonus }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="points">Points (%)</label>
                                            <input type="text" name="points" id="points" class="form-control"
                                                   value="{{ old('points') ?? $referralSetting->points }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Select</option>
                                                <option value="1" {{ (hasVal(old('status')) ? old('status')
                                                    : $referralSetting->status) === 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ (hasVal(old('status')) ? old('status')
                                                    : $referralSetting->status) === 0 ? 'selected' : '' }}>Inactive
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
            </div>
        </div>
    </section>
@endsection
