@extends('layouts.app', ['page' => 'Edit Client', 'pageSlug' => 'clients', 'section' => 'clients'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Client Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('clients.index') }}" class="btn btn-sm btn-primary">{{ __('Back to List') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('clients.update', $client) }}" autocomplete="off" id="the_form">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Client information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', $client->name) }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="form-group{{ $errors->has('document_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-document_id">{{ __('Document Number') }}</label>
                                    <input type="text" name="document_id" id="input-document_id" class="form-control form-control-alternative{{ $errors->has('document_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Document Number') }}" value="{{ old('document_id', $client->document_id) }}" required>
                                    @include('alerts.feedback', ['field' => 'document_id'])
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', $client->email) }}" required>
                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>
                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                    <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone', $client->phone) }}" required>
                                    @include('alerts.feedback', ['field' => 'phone'])
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4" data-toggle="tooltip" onclick="return clicked()">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function clicked() {
            var name = document.getElementById("input-name").value;
            var doc_id = document.getElementById("input-document_id").value;
            var email = document.getElementById("input-email").value;
            var phone = document.getElementById("input-phone").value;
            if (confirm('Do you want to edit this client?\nPlease check the details\n\nName: {{$client->name}} -> ' + name + '\nDocument Number: {{$client->document_id}} -> ' + doc_id + '\nEmail: {{$client->email}} -> ' + email + '\nPhone: {{$client->phone}} -> ' + phone)) {
                document.getElementById("the_form").submit();
            } else {
                return false;
            }
        }
    </script>
@endsection
