@extends( 'admin.layouts.master' )

@section( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Withdraw Methods</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Method</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.withdraw-method.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name"
                                           name="name" value="{{ old('name') }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="minimum_amount">Minimum Amount ({{
                                                $settings->currency_icon }})</label>
                                            <input type="number" step="0.01" class="form-control decimal-input"
                                                   id="minimum_amount" name="minimum_amount"
                                                   value="{{ old('minimum_amount') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="maximum_amount">Maximum Amount ({{
                                                $settings->currency_icon }})</label>
                                            <input type="number" step="0.01" class="form-control decimal-input"
                                                   id="maximum_amount" name="maximum_amount"
                                                   value="{{ old('maximum_amount') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="withdraw_charge">Withdraw charge (%)</label>
                                            <input type="number" step="0.01" class="form-control decimal-input"
                                                   id="withdraw_charge" name="withdraw_charge"
                                                   value="{{ old('withdraw_charge') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description"
                                              class="summernote">{!! old('description') !!}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Create</button>
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
                $('.decimal-input').on('change', function (e) {
                    const $this = $(e.currentTarget);
                    // Round the input value to two decimal places
                    $this.val(parseFloat($this.val()).toFixed(2));
                });
            });
        })(jQuery);
    </script>
@endpush
