@if($page == 'dashboard')
<div class="card">
    <div class="card-body">
        <div class="attachment-block clearfix">
            <img class="attachment-img" src="{{ asset('storage/images/logo.png') }}" alt="Attachment Image">
            <div class="attachment-pushed">
                <h4 class="attachment-heading pt-2 pb-2"><a href="#">Recruitment for SY 2021-2020 is already open</a></h4>

                <div class="attachment-text">
                    <p>
                        You may now submit your intent to apply for a teaching
                        position at your desired school for SY 2021-2022. Please 
                        refer to the Hiring Guidelines found at 
                        <a href="http://depedbohol.org">http://depedbohol.org</a>...
                        <a data-toggle="collapse" href="#more" 
                            role="button" aria-expanded="false" 
                            aria-controls="collapseExample">more</a> 
                    </p>

                    <div class="collapse" id="more">
                        <p>
                            Due to the pandemic and with the SDO's initiative to
                            streamline the application process, all application
                            intents should be recorded in this system, thus, it is 
                            imperative that new applicants should register to the RMS.
                            Moreover, those applying to retain their points also 
                            need to get theirselves registered in the system 
                            for them to be included in this year's recruitment
                            process. 
                        </p>
                        <p>
                            Follow the folowing steps:
                            <ol>
                                <li>Create an RMS account through the Register link
                                    found on the navigator bar.</li>
                                <li>Read all the fine prints including the data privacy
                                    terms and conditions.</li>
                                <li>A working email is required to successfully create
                                    an account as the account verification link
                                    will be sent to you to confirm the creation of 
                                    your account. Use and input the correct email.</li>
                                <li>Once your account is already confirmed, head 
                                    to the My Applications link found on the left side-bar
                                    and click the Apply button.</li>
                                <li>It is important that you take note of the auto-generated
                                    application number as you need to print and/or make this 
                                    visible to the application documents you will be submitting 
                                    to the school applied for.</li>
                                <li>Frequently visit your applications for updated status.</li>
                            </ol>
                        </p>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

@elseif($page == 'vacancies')
<div class="card">
    <div class="card-body">
        <div class="alert alert-info">Click the position name to collapse its details and click the Apply button 
            if interested to apply for the said position. To successfully apply though, you 
            need to have a confirmed account. Click the register option on the navigator bar 
            to create an account.</div>
        <div id="accordion">
            @if(sizeof($vacancies) > 0)
                @foreach($vacancies as $vacancy)
                    <div class="card">
                        <div class="card-header">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $vacancy->id ?? ''}}">
                                {{ $vacancy->name ?? ''}}
                            </a>
                        </div>
                        <div id="collapse-{{ $vacancy->id ?? ''}}" class="panel-collapse collapse in">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Position (SG)</strong>
                                        <p>{{ $vacancy->name ?? '' }}</p>
                                    </div>
                                    <div class="col-md-5">
                                        <strong>Qualifications</strong>
                                        <p>{!! $vacancy->qualifications ?? '' !!}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <strong>Vacancy</strong>
                                        <p>{{ $vacancy->vacancy ?? '' }} slot(s)</p>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ route('rms.application.apply', $vacancy->id) }}" class="btn btn-success btn-lg">Apply</a>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger">
                    No vacancy found.
                </div>
            @endif
        </div>
    </div>
</div>

@elseif($page == 'faqs')
<div class="card">
    <div class="card-body">
        <p>Content in progress. This page will be updated soon.</p>
    </div>
</div> 

@elseif($page == 'about')
<div class="card">
    <div class="card-body">
        <p>
            “RMS” stands for Recruitment Management System. 
            A Recruitment Management System (RMS) automates 
            and manages an organization’s recruiting and 
            staffing operations, streamlining the process 
            from start to finish. The core functions of an 
            RMS are the applicant tracking system (ATS), 
            which provides a central repository for candidate 
            data, and the customer relationship management (CRM) 
            software, which helps to organize and manage 
            interactions with candidates and clients.

            These critical systems provide companies with 
            the tools needed to win new business, increase 
            client retention, and provide better customer 
            service to existing clients.
            <blockquote>
                https://www.bullhorn.com/topics/recruitment-management-system/
            </blockquote>                      
        </p>
    </div>
</div>

@else
<div class="card">
    <div class="card-body">
        <p>
            We could not find the page you were looking for.<br>
            Meanwhile, you may <a href="{{ route('rms') }} ">return to dashboard</a>
        </p>
    </div>
</div> 
@endif