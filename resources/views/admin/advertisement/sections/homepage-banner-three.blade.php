<div class="tab-pane fade" id="homepage-banner-three" role="tabpanel" aria-labelledby="homepage-banner-three">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.homepage-banner-section-three') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method ( 'PUT' )
                <h4>Homepage Banner Section 3</h4><hr>
                <h5>Banner 1</h5>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <img src="{{ asset(@$homepage_section_banner_three->banner_one->banner_image) }}"
                                 alt="" width="150px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="banner_one_status" class="custom-switch-input"
                                    {{ @$homepage_section_banner_three->banner_one->status == 1 ? 'checked':'' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Status</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Banner Image</label>
                    <input type="file" class="form-control" name="banner_one_image" value="">
                    <input type="hidden" class="form-control" name="banner_one_old_image"
                           value="{{ @$homepage_section_banner_three->banner_one->banner_image }}">
                </div>
                <div class="form-group">
                    <label for="homepage_three_banner_one_url">Banner URL</label>
                    <input type="text" class="form-control" name="banner_one_url" id="homepage_three_banner_one_url"
                           value="{{ @$homepage_section_banner_three->banner_one->banner_url }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_one_hook_text">Hook Text</label>
                            <input type="text" class="form-control"
                                   name="banner_one_hook_text" id="homepage_banner_three_banner_one_hook_text"
                                   value="{{ @$homepage_section_banner_three->banner_one->hook_text }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_one_highlight_text">Highlight Text</label>
                            <input type="text" class="form-control" name="banner_one_highlight_text"
                                   id="homepage_banner_three_banner_one_highlight_text"
                                   value="{{ @$homepage_section_banner_three->banner_one->highlight_text }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_one_followup_text">Followup Text</label>
                            <input type="text" class="form-control" name="banner_one_followup_text"
                                   id="homepage_banner_three_banner_one_followup_text"
                                   value="{{ @$homepage_section_banner_three->banner_one->followup_text }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_one_button_text">Button Text</label>
                            <input type="text" class="form-control" name="banner_one_button_text"
                                   id="homepage_banner_three_banner_one_button_text"
                                   value="{{ @$homepage_section_banner_three->banner_one->button_text }}">
                        </div>
                    </div>
                </div>
                <hr>
                <h5>Banner 2</h5>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <img src="{{ asset(@$homepage_section_banner_three->banner_two->banner_image) }}"
                                 alt="" width="150px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="banner_two_status" class="custom-switch-input"
                                    {{ @$homepage_section_banner_three->banner_two->status == 1 ? 'checked':'' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Status</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Banner Image</label>
                    <input type="file" class="form-control" name="banner_two_image" value="">
                    <input type="hidden" class="form-control" name="banner_two_old_image"
                           value="{{ @$homepage_section_banner_three->banner_two->banner_image }}">
                </div>
                <div class="form-group">
                    <label for="homepage_three_banner_two_url">Banner url</label>
                    <input type="text" class="form-control" name="banner_two_url" id="homepage_three_banner_two_url"
                           value="{{ @$homepage_section_banner_three->banner_two->banner_url }}">
                </div>
                <div class="form-group">
                    <label for="homepage_banner_three_banner_two_leading_text">Leading Text</label>
                    <input type="text" class="form-control" name="banner_two_leading_text"
                           id="homepage_banner_three_banner_two_leading_text"
                           value="{{ @$homepage_section_banner_three->banner_two->leading_text }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_two_followup_text">Followup Text</label>
                            <input type="text" class="form-control" name="banner_two_followup_text"
                                   id="homepage_banner_three_banner_two_followup_text"
                                   value="{{ @$homepage_section_banner_three->banner_two->followup_text }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_two_button_text">Button Text</label>
                            <input type="text" class="form-control" name="banner_two_button_text"
                                   id="homepage_banner_three_banner_two_button_text"
                                   value="{{ @$homepage_section_banner_three->banner_two->button_text }}">
                        </div>
                    </div>
                </div>
                <hr>
                <h5>Banner 3</h5>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <img src="{{ asset(@$homepage_section_banner_three->banner_three->banner_image) }}"
                                 alt="" width="150px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="banner_three_status" class="custom-switch-input"
                                    {{ @$homepage_section_banner_three->banner_three->status == 1 ? 'checked':'' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Status</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Banner Image</label>
                    <input type="file" class="form-control" name="banner_three_image" value="">
                    <input type="hidden" class="form-control" name="banner_three_old_image"
                           value="{{ @$homepage_section_banner_three->banner_three->banner_image }}">
                </div>
                <div class="form-group">
                    <label for="homepage_three_banner_three_url">Banner URL</label>
                    <input type="text" class="form-control" name="banner_three_url" id="homepage_three_banner_three_url"
                           value="{{ @$homepage_section_banner_three->banner_three->banner_url }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_three_hook_text">Hook Text</label>
                            <input type="text" class="form-control"
                                   name="banner_three_hook_text" id="homepage_banner_three_banner_three_hook_text"
                                   value="{{ @$homepage_section_banner_three->banner_three->hook_text }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_three_highlight_text">Highlight Text</label>
                            <input type="text" class="form-control" name="banner_three_highlight_text"
                                   id="homepage_banner_three_banner_three_highlight_text"
                                   value="{{ @$homepage_section_banner_three->banner_three->highlight_text }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_three_followup_text">Followup Text</label>
                            <input type="text" class="form-control" name="banner_three_followup_text"
                                   id="homepage_banner_three_banner_three_followup_text"
                                   value="{{ @$homepage_section_banner_three->banner_three->followup_text }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homepage_banner_three_banner_three_button_text">Button Text</label>
                            <input type="text" class="form-control" name="banner_three_button_text"
                                   id="homepage_banner_three_banner_three_button_text"
                                   value="{{ @$homepage_section_banner_three->banner_three->button_text }}">
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
