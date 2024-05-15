@extends( 'admin.layouts.master' )

@section( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Subscribers</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Send Email to all subscribers</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.subscribers-send-mail') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="message" id="message" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="section">

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Subscribers</h4>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@push( 'scripts' )
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
