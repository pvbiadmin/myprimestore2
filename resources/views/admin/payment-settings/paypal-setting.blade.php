<div class="tab-pane fade show active" id="list-paypal" role="tabpanel"
     aria-labelledby="list-paypal-list">
    <div class="card border">
        <div class="card-body">
            <form method="post" action="{{ route('admin.paypal-setting.update', 1) }}">
                @csrf
                @method( 'PUT' )
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ @$paypal->status === 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ @$paypal->status === 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mode">Mode</label>
                            <select name="mode" id="mode" class="form-control">
                                <option value="0" {{ @$paypal->mode === 0 ? 'selected' : '' }}>Sandbox</option>
                                <option value="1" {{ @$paypal->mode === 1 ? 'selected' : '' }}>Live</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select class="form-control select2" name="country" id="country">
                                <option value="">Select</option>
                                @foreach( config('settings.country_list') as $code => $name )
                                    <option value="{{ $code }}" {{
                                        $paypal->country === $code ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name_currency">Default Currency</label>
                            <select name="name_currency" id="name_currency" class="form-control select2">
                                <option value="">Select</option>
                                @foreach( config('settings.currency_list') as $currency )
                                    <option value="{{ $currency['code'] }}"
                                            data-symbol="{{ $currency['symbol'] }}" {{
                                            $paypal->currency_name === $currency['code'] ? 'selected' : '' }}>
                                        {{ $currency['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="icon_currency">Currency Icon</label>
                            <input type="text" name="icon_currency" id="icon_currency" class="form-control"
                                   value="{{ $paypal->currency_icon }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rate_currency">Currency Rate (per {{ $settings->currency_name }})</label>
                            <input type=number step=0.01 min="0" name="rate_currency" id="rate_currency"
                                   class="form-control" value="{{ $paypal->currency_rate }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="client_id">Paypal Client ID</label>
                            <input type="text" name="client_id" id="client_id" class="form-control"
                                   value="{!! $paypal->client_id !!}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="secret_key">Paypal Secret Key</label>
                            <input type="text" name="secret_key" id="secret_key" class="form-control"
                                   value="{!! $paypal->secret_key !!}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        ($ => {
            $(() => {
                // Listen for changes in the select element
                $("#name_currency").change(e => {
                    // Get the selected option
                    const $this = $(e.currentTarget);
                    const selectedOption = $this.find(":selected");

                    // Get the value of the data-symbol attribute from the selected option
                    const currencySymbol = selectedOption.data("symbol");

                    // Update the value of the input field with the currency symbol
                    $("#icon_currency").val(currencySymbol);
                });
            });
        })(jQuery);
    </script>
@endpush
