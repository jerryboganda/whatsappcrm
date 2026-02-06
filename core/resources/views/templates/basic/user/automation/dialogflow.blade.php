@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <form action="{{ route('user.dialogflow.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4">
                            <div class="form-group">
                                <label>@lang('Service Account Credentials (JSON)')</label>
                                <input type="file" name="credentials_file" class="form-control" accept=".json" required>
                                <small
                                    class="text-muted">@lang('Upload the JSON key file from your Google Cloud Service Account.')</small>
                            </div>

                            <div class="form-group">
                                <label>@lang('Status')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')"
                                    name="status" @if(@$config->status) checked @endif value="1">
                            </div>

                            @if(@$config)
                                <div class="alert alert-info">
                                    <strong>@lang('Current Project ID'):</strong> {{ $config->project_id }}
                                </div>
                            @endif

                        </div>
                        <div class="card-footer">
                            <button type="submit"
                                class="btn btn--primary btn-block w-100">@lang('Save Configuration')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    @if(@$config)
        <a href="{{ route('user.dialogflow.delete') }}" class="btn btn-sm btn--danger">
            <i class="las la-trash"></i> @lang('Remove Configuration')
        </a>
    @endif
@endpush