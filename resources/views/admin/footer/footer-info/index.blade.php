@extends ( 'admin.layouts.master' )

@section ( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Footer</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Footer Info</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.footer-info.update', 1) }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                @method ( 'PUT' )
                                <div class="form-group">
                                    <div class="logo-footer-admin">
                                        <img src="{{ asset(@$footerInfo->logo) }}" width="150px" alt="">
                                    </div>
                                    <br>
                                    <label for="logo">Footer Logo</label>
                                    <input type="file" class="form-control" name="logo" id="logo">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">phone</label>
                                            <input type="text" class="form-control" name="phone"
                                                   id="phone" value="{{ @$footerInfo->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">email</label>
                                            <input type="text" class="form-control" name="email"
                                                   id="email" value="{{ @$footerInfo->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">address</label>
                                    <input type="text" class="form-control" name="address"
                                           id="address" value="{{ @$footerInfo->address }}">
                                </div>

                                <div class="form-group">
                                    <label for="copyright">copyright</label>
                                    <input type="text" class="form-control" name="copyright"
                                           id="copyright" value="{{ @$footerInfo->copyright }}">
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
