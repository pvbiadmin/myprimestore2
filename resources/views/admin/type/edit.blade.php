@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Product Type</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.type.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Type</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.type.update', $type->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method( 'PUT' )
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name"
                                                   class="form-control" value="{{ old('name') ?? $type->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="is_package">Is Package</label>
                                            <select name="is_package" id="is_package" class="form-control">
                                                <option value="0" {{ (string) (old('is_package')
                                                    ?? $type->is_package) === '0' ? 'selected' : '' }}>No
                                                </option>
                                                @if ( !empty($degrees_available) )
                                                    <option value="1" {{ (string) (old('is_package')
                                                        ?? $type->is_package) === '1' ? 'selected' : '' }}>Yes
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-none" id="field_degree">
                                        <div class="form-group">
                                            <label for="degree">Degree</label>
                                            <select name="degree" id="degree" class="form-control">
                                                @foreach ( $degrees_available as $k => $v )
                                                    <option value="{{ $v }}" {{ (old('degree') ?? $type->degree) === $v
                                                        ? 'selected' : '' }}>{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ (string) (old('status')
                                                    ?? $type->status) === '1' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ (string) (old('status')
                                                    ?? $type->status) === '0' ? 'selected' : '' }}>Inactive
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

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                const idDegree = $("#field_degree");
                const idIsPackage = $("#is_package");

                let isPackage = idIsPackage.val();

                if (isPackage === "1") {
                    idDegree.removeClass("d-none");
                } else {
                    idDegree.addClass("d-none");
                }

                @if ( (string) old('is_package') === '1' )
                idDegree.removeClass("d-none");
                @endif

                $("body").on("change", "#is_package", e => {
                    const $this = $(e.currentTarget);
                    let type = $this.val();

                    if (type !== "1") {
                        idDegree.addClass("d-none");
                    } else {
                        idDegree.removeClass("d-none");
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
