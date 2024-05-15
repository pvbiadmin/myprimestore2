@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Shipping Rule</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.shipping-rules.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Shipping Rule</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.shipping-rules.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name"
                                                   class="form-control" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ old('status') == 1
                                                    ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ old('status') == 0
                                                    ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type" id="type" class="form-control">
                                                <option value="1" {{ old('type') == 1
                                                    ? 'selected' : '' }}>Flat Cost
                                                </option>
                                                <option value="2" {{ old('type') == 2
                                                    ? 'selected' : '' }}>Min. Order Amount
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-none" id="field_min_cost">
                                        <div class="form-group">
                                            <label for="min_cost">Minimum Cost</label>
                                            <input type=number step=0.01 min="0" name="min_cost" id="min_cost"
                                                   class="form-control" value="{{ old('min_cost') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cost">Cost</label>
                                            <input type=number step=0.01 min="0" name="cost" id="cost"
                                                   class="form-control" value="{{ old('cost') }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                const id_field = $("#field_min_cost");

                @if ( old('type') == 2 )
                id_field.removeClass("d-none");
                @endif

                $("body").on("change", "#type", e => {
                    const $this = $(e.currentTarget);
                    let type = $this.val();

                    if (type !== "2") {
                        id_field.addClass("d-none");
                    } else {
                        id_field.removeClass("d-none");
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
