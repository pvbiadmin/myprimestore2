<div class="tab-pane fade" id="homepage-banner-four" role="tabpanel" aria-labelledby="homepage-banner-four">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.homepage-banner-section-four') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method ( 'PUT' )
                <h5>Homepage Banner Section 4</h5>
                <hr>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <img src="{{ asset(@$homepage_section_banner_four->banner_one->banner_image) }}"
                                 alt="" width="150px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="status" class="custom-switch-input"
                                    {{ @$homepage_section_banner_four->banner_one->status == 1 ? 'checked':'' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Status</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Banner Image</label>
                            <input type="file" class="form-control" name="banner_image" value="">
                            <input type="hidden" class="form-control" name="banner_old_image"
                                   value="{{ @$homepage_section_banner_four->banner_one->banner_image }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="homepage_four_banner_header">Banner Header</label>
                            <input type="text" class="form-control" name="banner_header"
                                   id="homepage_four_banner_header"
                                   value="{{ @$homepage_section_banner_four->banner_one->banner_header }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="homepage_four_banner_description">Banner Description</label>
                    <input type="text" class="form-control" name="banner_description"
                           id="homepage_four_banner_description"
                           value="{{ @$homepage_section_banner_four->banner_one->banner_description }}">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="homepage_four_button1_text">Button1 Text</label>
                            <input type="text" class="form-control" name="button1_text" id="homepage_four_button1_text"
                                   value="{{ @$homepage_section_banner_four->banner_one->button1_text }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="homepage_four_button1_url">Button1 URL</label>
                            <input type="text" class="form-control" name="button1_url" id="homepage_four_button1_url"
                                   value="{{ @$homepage_section_banner_four->banner_one->button1_url }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="default_url1" class="custom-switch-input"
                                    {{ @$homepage_section_banner_four->banner_one
                                            ->default_url == @$homepage_section_banner_four->banner_one
                                            ->button1_url ? 'checked':'' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Default URL</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="homepage_four_button2_text">Button2 Text</label>
                            <input type="text" class="form-control" name="button2_text" id="homepage_four_button2_text"
                                   value="{{ @$homepage_section_banner_four->banner_one->button2_text }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="homepage_four_button2_url">Button2 URL</label>
                            <input type="text" class="form-control" name="button2_url" id="homepage_four_button2_url"
                                   value="{{ @$homepage_section_banner_four->banner_one->button2_url }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="default_url2" class="custom-switch-input"
                                    {{ @$homepage_section_banner_four->banner_one
                                            ->default_url == @$homepage_section_banner_four->banner_one
                                            ->button2_url ? 'checked':'' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Default URL</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="homepage_four_leading_text">Leading Text</label>
                            <input type="text" class="form-control" name="leading_text" id="homepage_four_leading_text"
                                   value="{{ @$homepage_section_banner_four->banner_one->leading_text }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="homepage_four_highlight_text">Highlight Text</label>
                            <input type="text" class="form-control" name="highlight_text"
                                   id="homepage_four_highlight_text"
                                   value="{{ @$homepage_section_banner_four->banner_one->highlight_text }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="homepage_four_followup_text">Followup Text</label>
                            <input type="text" class="form-control" name="followup_text"
                                   id="homepage_four_followup_text"
                                   value="{{ @$homepage_section_banner_four->banner_one->followup_text }}">
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
                // Add change event listener to default_url1 checkbox
                $('[name="default_url1"]').change(e => {
                    if ($(e.currentTarget).prop('checked')) {
                        // If default_url1 is checked, uncheck default_url2
                        $('[name="default_url2"]').prop('checked', false);
                    }
                });

                // Add change event listener to default_url2 checkbox
                $('[name="default_url2"]').change(e => {
                    if ($(e.currentTarget).prop('checked')) {
                        // If default_url2 is checked, uncheck default_url1
                        $('[name="default_url1"]').prop('checked', false);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
