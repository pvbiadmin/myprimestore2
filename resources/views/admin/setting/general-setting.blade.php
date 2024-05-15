<div class="tab-pane fade show active" id="list-home" role="tabpanel"
     aria-labelledby="list-home-list">
    <div class="card border">
        <div class="card-body">
            <form method="post" action="{{ route('admin.settings.general.update') }}">
                @csrf
                @method ( 'PUT' )
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name_site">Site Name</label>
                            <input type="text" name="name_site" id="name_site" class="form-control"
                                   value="{{ $general_settings?->site_name ?? old('name_site') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email_contact">Contact Email</label>
                            <input type="text" name="email_contact" id="email_contact" class="form-control"
                                   value="{{ $general_settings?->contact_email ?? old('email_contact') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_phone">Contact Phone</label>
                            <input type="text" name="contact_phone" id="contact_phone" class="form-control"
                                   value="{{ $general_settings?->contact_phone ?? old('contact_phone') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact_address">Contact Address</label>
                    <input type="text" name="contact_address" id="contact_address" class="form-control"
                           value="{{ $general_settings?->contact_address ?? old('contact_address') }}">
                </div>
                <div class="form-group">
                    <label for="map">Google Map Url</label>
                    <input type="text" class="form-control" name="map" id="map"
                           value="{{ $general_settings?->map ?? old('map') }}">
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name_currency">Default Currency</label>
                            <select name="name_currency" id="name_currency" class="form-control select2">
                                <option value="">Select</option>
                                @foreach( config('settings.currency_list') as $currency )
                                    <option value="{{ $currency['code'] }}" data-symbol="{{ $currency['symbol'] }}"
                                        @selected( ($general_settings?->currency_name
                                            ?? old('name_currency')) == $currency['code'] )>
                                        {{ $currency['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="icon_currency">Currency Icon</label>
                            <input type="text" name="icon_currency" id="icon_currency" class="form-control"
                                   value="{{ $general_settings?->currency_icon ?? old('icon_currency') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="timezone">Timezone</label>
                            <select name="timezone" id="timezone" class="form-control select2">
                                <option value="">Select</option>
                                @foreach( config('settings.timezone_list') as $key => $val )
                                    <option value="{{ $key }}" @selected( ($general_settings?->timezone
                                        ?? old('timezone')) == $key )>{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="layout_site">Site Layout</label>
                            <select name="layout_site" id="layout_site" class="form-control">
                                <option value="LTR" @selected( ($general_settings?->site_layout
                                    ?? old('layout_site')) == 'LTR' )>LTR
                                </option>
                                <option value="RTL" @selected( ($general_settings?->site_layout
                                    ?? old('layout_site')) == 'RTL' )>RTL
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

@push( 'scripts' )
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
