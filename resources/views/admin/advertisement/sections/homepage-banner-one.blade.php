<div class="tab-pane fade show active" id="homepage-banner-one"
     role="tabpanel" aria-labelledby="homepage-banner-one">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.homepage-banner-section-one') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method ( 'PUT' )
                <h5>Homepage Banner Section 1</h5><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <img src="{{ asset(@$homepage_section_banner_one->banner_one->banner_image) }}"
                                 alt="" width="150px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="status" class="custom-switch-input"
                                    {{ @$homepage_section_banner_one->banner_one->status == 1 ? 'checked':'' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Status</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Banner Image</label>
                    <input type="file" class="form-control" name="banner_image" value="">
                    <input type="hidden" class="form-control" name="banner_old_image"
                           value="{{ @$homepage_section_banner_one->banner_one->banner_image }}">
                </div>
                <div class="form-group">
                    <label for="homepage_one_banner_url">Banner URL</label>
                    <input type="text" class="form-control" name="banner_url" id="homepage_one_banner_url"
                           value="{{ @$homepage_section_banner_one->banner_one->banner_url }}">
                </div>
                <div class="form-group">
                    <label for="homepage_one_leading_text">Leading Text</label>
                    <input type="text" class="form-control" name="leading_text" id="homepage_one_leading_text"
                           value="{{ @$homepage_section_banner_one->banner_one->leading_text }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_one_hook_text">Hook Text</label>
                            <input type="text" class="form-control" name="hook_text" id="homepage_one_hook_text"
                                   value="{{ @$homepage_section_banner_one->banner_one->hook_text }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_one_highlight_text">Highlight Text</label>
                            <input type="text" class="form-control" name="highlight_text" id="homepage_one_highlight_text"
                                   value="{{ @$homepage_section_banner_one->banner_one->highlight_text }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_one_followup_text">Followup Text</label>
                            <input type="text" class="form-control" name="followup_text" id="homepage_one_followup_text"
                                   value="{{ @$homepage_section_banner_one->banner_one->followup_text }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_one_button_text">Button Text</label>
                            <input type="text" class="form-control" name="button_text" id="homepage_one_button_text"
                                   value="{{ @$homepage_section_banner_one->banner_one->button_text }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
