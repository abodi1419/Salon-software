@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit employee') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('employees.update',$employee) }}">
                            @csrf
                            @method('PUT')
                            <h6>{{__('Personal Information')}}</h6>
                            <hr>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $employee['name'] }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="SSN" class="col-md-4 col-form-label text-md-right">{{ __('SSN') }}</label>

                                <div class="col-md-6">
                                    <input id="SSN" type="text" class="form-control @error('SSN') is-invalid @enderror" name="SSN" value="{{ $employee['SSN'] }}" required>

                                    @error('SSN')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $employee['phone'] }}" required autocomplete="phone">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of birth') }}</label>

                                <div class="col-md-6">
                                    <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ $employee['dob'] }}" required>

                                    @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <h6>{{__('Job Details')}}</h6>
                            <div class="form-group row">
                                <label for="job_title" class="col-md-4 col-form-label text-md-right">{{ __('Job title') }}</label>

                                <div class="col-md-6">
                                    <select name="job_title" class="form-control @error('job_title') is-invalid @enderror" id="job_title">
                                        @foreach($jobTitles as $jobTitle)
                                            <option value="{{$jobTitle['id']}}" @if($employee['job_title']==$jobTitle['id']) selected @endif>{{$jobTitle['name']}}</option>
                                        @endforeach
                                    </select>

                                    @error('job_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="salary" class="col-md-4 col-form-label text-md-right">{{ __('Salary') }}</label>

                                <div class="col-md-6">
                                    <input id="salary" type="number" class="form-control @error('salary') is-invalid @enderror" name="salary" value="{{ $employee['salary'] }}" required>

                                    @error('salary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="commission" class="col-md-4 col-form-label text-md-right">{{ __('Commission') }}</label>

                                <div class="col-md-6">
                                    <input id="commission" type="number" class="form-control @error('commission') is-invalid @enderror" min="0" max="100" name="commission" value="{{ $employee['commission'] }}" required>

                                    @error('commission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="doh" class="col-md-4 col-form-label text-md-right">{{ __('Date of hired') }}</label>

                                <div class="col-md-6">
                                    <input id="doh" type="date" class="form-control @error('doh') is-invalid @enderror" name="doh" value="{{ $employee['doh'] }}" required>

                                    @error('doh')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="setPassword"  onclick="setPasswordClick(this)">
                                <label for="setPassword">{{__('Set password')}}</label>
                            </div>
                            <div class="form-group row" id="password-div" hidden>
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" disabled>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row" id="confirm-div" hidden>
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setPasswordClick(event){
            if(event.checked){
                document.getElementById('password-div').hidden=false;
                document.getElementById('confirm-div').hidden=false;
                document.getElementById('password').required=true;
                document.getElementById('password').disabled=false;
                document.getElementById('password-confirm').required=true;
            }else{
                document.getElementById('password-div').hidden=true;
                document.getElementById('confirm-div').hidden=true;
                document.getElementById('password').required=false;
                document.getElementById('password').disabled=true;
                document.getElementById('password-confirm').required=false;
            }
        }
    </script>
@endsection
