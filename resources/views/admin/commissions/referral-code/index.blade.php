@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Referral Code</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Admin</a></div>
                <div class="breadcrumb-item"><a href="#">Commissions</a></div>
                <div class="breadcrumb-item">Referral Code</div>
            </div>
        </div>

        <div class="mb-3">
            <a href="{{ route('admin.referral.index') }}" class="btn btn-primary">Back</a>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @include( 'admin.commissions.referral-code.referral-code' )
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
