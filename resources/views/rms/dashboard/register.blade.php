@extends('layouts.app')  

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Registration</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item active">Registration</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content load-register-modal">
    <div class="container-fluid">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="col-md-9">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form method="POST" action="{{ route('rms.account.store') }}">
                                    @csrf

                                    <h5>Personal Information</h5>
                                    <div class="form-group row">
                                        <label for="firstname" class="col-md-3 col-form-label text-md-right">{{ __('Firstname') }}</label>

                                        <div class="col-md-8">
                                            <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" autocomplete="firstname">

                                            @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="middlename" class="col-md-3 col-form-label text-md-right">{{ __('Middlename') }}</label>

                                        <div class="col-md-8">
                                            <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}" autocomplete="middlename">

                                            @error('middlename')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="lastname" class="col-md-3 col-form-label text-md-right">{{ __('Lastname') }}</label>

                                        <div class="col-md-8">
                                            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" autocomplete="lastname">

                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="extname" class="col-md-3 col-form-label text-md-right">{{ __('Ext. Name') }}</label>

                                        <div class="col-md-8">
                                            <select id="extname" type="text" class="form-control @error('extname') is-invalid @enderror" name="extname" value="{{ old('extname') }}" autocomplete="extname">
                                                <option value="">Select</option>
                                                @foreach($extensions as $extension)
                                                    <option value="{{ $extension->details }}" @if (old('extname') == $extension->details) {{ 'selected' }} @endif>{{ $extension->details }}</option>
                                                @endforeach
                                            </select>
                                            @error('extname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="sex" class="col-md-3 col-form-label text-md-right">{{ __('Sex') }}</label>

                                        <div class="col-md-8">
                                            <select id="sex" type="text" class="form-control @error('sex') is-invalid @enderror" name="sex" value="{{ old('sex') }}" autocomplete="sex">
                                                <option value="">Select</option>
                                                @foreach($sexes as $sex)
                                                    <option value="{{ $sex->details }}" @if (old('sex') == $sex->details) {{ 'selected' }} @endif>{{ $sex->details }}</option>
                                                @endforeach
                                            </select>
                                            @error('sex')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="dob" class="col-md-3 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

                                        <div class="col-md-8">
                                            <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" autocomplete="dob">
                                            <input id="image" type="hidden" class="form-control-file" name="image" value="{{ __('no-avatar.jpg') }}" autocomplete="image">

                                            @error('dob')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="civilstatus" class="col-md-3 col-form-label text-md-right">{{ __('Civil Status') }}</label>

                                        <div class="col-md-8">
                                            <select id="civilstatus" type="text" class="form-control @error('civilstatus') is-invalid @enderror" name="civilstatus" value="{{ old('civilstatus') }}" autocomplete="civilstatus">
                                            <option value="">Select</option>
                                                @foreach($civilstatuses as $civilstatus)
                                                    <option value="{{ $civilstatus->details }}" @if (old('civilstatus') == $civilstatus->details) {{ 'selected' }} @endif>{{ $civilstatus->details }}</option>
                                                @endforeach
                                            </select>

                                            @error('civilstatus')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="primaryno" class="col-md-3 col-form-label text-md-right">{{ __('Primary Contact #') }}</label>

                                        <div class="col-md-8">
                                            <input id="primaryno" type="text" class="form-control @error('primaryno') is-invalid @enderror" name="primaryno" value="{{ old('primaryno') }}" autocomplete="primaryno">
                                            <small><em>{{ __('09xxxxxxxxx') }}</em></small>

                                            @error('primaryno')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <h5>Account Information</h5>
                                    <div class="form-group row">
                                        <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                                        <div class="col-md-8">
                                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <small><em class="d-flex p-2 text-danger">{{ __('A verification link will be sent to this address. Make sure this is correct.') }}</em></small>

                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="username" class="col-md-3 col-form-label text-md-right">{{ __('Username') }}</label>

                                        <div class="col-md-8">
                                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username">
                                            
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-8">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-8">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-8">
                                            <input type="checkbox" id="confirmdataprivacy" @error('confirmdataprivacy') is-invalid @enderror" name="confirmdataprivacy" value="{{ old('confirmdataprivacy') }}" @if(old('confirmdataprivacy') != null) {{ 'checked=checked' }} @endif autocomplete="password"> 
                                            <small>I agree to the data privacy terms of SDO Bohol HRMS-RMS.</small>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-8">
                                                <button type="submit" id="rms-reg-submit" class="btn btn-primary float-right" disabled>
                                                    {{ __('Register') }}
                                                </button>
                                                <a href="{{ route('rms') }}" class="btn btn-default">
                                                    {{ __('Cancel') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> 
                            <div class="col-md-4">
                                <div class="card bg-warning">
                                    <div class="card-body">
                                        <h5 class="text-danger">Important Note</h5>
                                        <small>
                                        <p>
                                            The personal data you provide in your application 
                                            and as part of the recruitment process will only 
                                            be held and processed for the purpose of the selection 
                                            processes of the SDO Bohol and in connection 
                                            with any subsequent employment or placement, unless 
                                            otherwise indicated. Your data will be retained only 
                                            for as long as is permitted by Philippine legislation and 
                                            then destroyed. Please read the fine print 
                                            <a href="#" data-toggle="modal" data-target="#modal-md">here</a>.
                                        </p>
                                        <p>
                                            Before moving on, please make sure to read the following
                                            terms:
                                            <ul>
                                                <li>
                                                    Please fill out the form correctly. Once submitted,
                                                    you may no longer be able to make further modifications.
                                                </li>
                                                <li>
                                                    Only those who have met the minimum requirements
                                                    of the applied position are allowed to register. 
                                                    Moreover, registration is just the first step of the 
                                                    recruitment process and you still are required
                                                    to apply for the specific position you are 
                                                    interested in applying once your account is confirmed.
                                                </li>
                                                <li>
                                                    An applicant can only have one account, making multiple
                                                    accounts is a violation of the hiring guidelines and
                                                    may negatively affect your application status.
                                                </li>
                                            </ul>                                       
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>                    
                </div>
            </div>

            <div class="col-md-3">
                @include('rms.dashboard._tools')
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-md">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                Recruitment Data Privacy Statement
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <small>
                    <p>In order to operate the SDO Bohol (“DepEd Bohol”) recruitment system, we will collect
                    and store personal information you submit to it via this recruitment website. Please read the
                    following privacy policy to understand how the DepEd Bohol uses and protects the information
                    you provide.
                    </p>
                    <p>
                    The online recruitment system is provided and hosted by the DepEd Bhool and its third party
                    supplier. By submitting your personal information, you are consenting to the DepEd Bohol
                    holding and using it in accordance with this policy. The policy is subject to change and any
                    changes to it in the future will be notified on this page. By continuing to use this recruitment
                    site you are agreeing to such changes. We recommend that you check the privacy policy each
                    time you visit this site.
                    </p>
                    Contents:
                    <ol>
                    <li>1. Information that we collect from you and your use of this website</li>
                    <li>2. How we handle the data that is submitted by you</li>
                    <li>3. How to contact us</li>
                    </ol>
                    <strong>1.0 Information that we collect from you and your use of this website</strong>
                    <br>
                    <p>
                    1.1 Information you give us<br>
                    When you visit hrms.depedbohol.net/rms you may be asked to provide certain information
                    yourself, including your name, contact details, date of birth and job history.
                    Some of the information is mandatory in order for the DepEd Bohol to consider an application
                    for a vacancy or meet its statutory monitoring and reporting responsibilities. However, where
                    indicated, some of the information is optional and you can choose not to complete.
                    </p>
                    <p>
                    1.2 Automatic Information<br>
                    We automatically receive and save certain types of information whenever you interact with this website. We
                    use the information to monitor website traffic and to assist with the navigation and user experience of the
                    website.
                    </p>
                    Information that we will automatically receive includes:
                    <ul>
                    <li>Requested URL (Uniform Resource Locator)</li>
                    <li>IP (Internet Protocol) address (this may or may not identify a specific computer)</li>
                    <li>Domain name from which you access the internet</li>
                    <li>Referring URL</li>
                    <li>Software (browser/operating system) used to access the page</li>
                    <li>Date and time pages were visited</li>
                    </ul>
                    <p>
                    1.3 Cookies<br>
                    Please see the DepEd Bohol ‘Use of cookies’ page.
                    Please note, when you apply for a job, login to your candidate homepage or register for email alerts you are
                    entering the web site of a third party supplier (see 2.0 below). The SDO Bohol is not responsible for
                    the cookies set on these pages by the third party supplier. However, you can check how the third party
                    supplier uses cookies. 
                    </p>

                    <strong>2.0 How we handle the data that is submitted by you</strong>
                    <br>
                    <p>Personal data is collected to facilitate the recruitment process and used for anonymised reporting purposes.
                    Data entered as part of an application is stored in the system and will be made available to an applicant to ‘reuse’ as part of a future application.
                    Please be aware that the DepEd Bohol uses a third party supplier to hold the information you submit. The third
                    party company complies with the DepEd Bohol security policy and therefore will not share your data with anyone
                    other than the DepEd Bohol.
                    </p>
                    <p>
                    In the event of your application resulting in the offer and your acceptance of a position at the DepEd Bohol, your
                    personal information will be sent to and held in the DepEd Bohol's staff database.
                    </p>
                    <p>
                    2.1 Data Protection Legislation<br>
                    The DepEd Bohol is your data controller. As your data controller the DepEd Bohol has notified its activities to the
                    Office of the Data Privacy Commissioner as required under the Data Privacy Act 2012 (the “Act”) and is
                    listed in the Public Register of Data Controllers. Personal information will only be collected and/or processed
                    by the DepEd Bohol in accordance with the Act.
                    </p>
                    <p>
                    2.2 Disclosure of your information<br>
                    The information you provide to us will be held on third party supplier computers in the Philippines who act for us for
                    the purposes set out in this policy. They may provide support services to the DepEd Bohol or on the DepEd Bohol's
                    behalf.
                    </p>
                    <p>
                    Except as set out in this policy or as required by law, your personal data will not be provided to any third party
                    without your prior written consent.
                    </p>
                    <p>
                    2.3 Data Protection Statement:<br>
                    The personal data you provide in your application and as part of the recruitment process will only be held and
                    processed for the purpose of the selection processes of the SDO Bohol and in connection with any
                    subsequent employment or placement, unless otherwise indicated. Your data will be retained only for as long
                    as is permitted by Philippine legislation and then destroyed.
                    </p>
                    <p>
                    By submitting your personal data and application, you:
                    <ol>
                    <li>declare that you have read, understood and accepted the statements set out in this data protection clause;</li>
                    <li>are declaring that the information given in the application is complete and true to the best of your
                    knowledge, and understand that deliberate omissions and incorrect statements could lead to your application
                    being rejected or to your dismissal;</li>
                    <li>are giving your consent to the processing of the information contained in this application and any other
                    personal data you may provide separately in the manner and to the extent described; and</li>
                    <li>are authorising the DepEd Bohol to verify or have verified on their behalf all
                    statements contained in this application and to make any necessary reference checks.</li>
                    </ol>
                    <p>
                    2.4 Data Retention<br>
                    Unsuccessful applicant data will be held within the recruitment system for a period of five years
                    before being deleted in order that you can access and re-use data in future applications and we can
                    respond to statutory reporting requests. Successful applicant data will be deleted after a period of
                    seven years
                    </p>

                    <strong>3.0 How to contact us</strong>
                    <p>
                    For any queries you may have in connection with this privacy statement, please contact:<br>
                    Legal Unit<br>
                    SDO Bohol<br>
                    Tagbilaran City<br>
                    Email: deped.bohol@deped.gov.ph<br>
                    </p>
                </small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="register-modal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content bg-default">
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Disclaimer</strong>
                    <p>
                        By proceeding with accomplishing this Form, you
                        give consent to the processing of your personal
                        information by the SDO Bohol pursuant to 
                        recruitment.
                    </p>
                    <p>
                        <u>PLEASE REMEMBER</u> that accomplishing this online 
                        form DOES NOT mean that you are already an 
                        applicant. You have to apply first to the 
                        position after registering.
                    </p>
                </div>

                <div class="alert alert-warning">
                    <strong>Notices</strong>
                    <p>
                        Current employees of SDO Bohol may have had accounts already. 
                        Please try <a href="{{ route('login') }}" class="text-info">logging in instead</a> 
                        using your DepEd Email username (without the @deped.gov.ph) and 
                        use the default password "password" (without quote).
                    </p>
                </div>

                <div class="alert alert-danger">
                    <strong>Warning</strong>
                    <p>
                        Please verify information being filled out. Further modications, once 
                        submitted will no longer be allowed.
                    </p>
                </div>
            </div>
            <div class="modal-footer p-1">
                <button type="button" class="btn btn-primary btn-sm float-right" data-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>
@endsection