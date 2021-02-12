@if($page == 'announcements')
<?php $posts = App\Models\Post::where('type', '=', $page)
    ->orderBy('created_at', 'desc')
    ->paginate(3); ?>

@if(sizeof($posts) > 0)
    @foreach($posts as $post)           
        <div class="callout callout-default">
            <div class="attachment-block clearfix">
                <img class="attachment-img" src="{{ asset('storage/images/logo.png') }}" alt="Site Logo">
                <div class="attachment-pushed">
                    <h4 class="attachment-heading pt-2 pb-2">
                        {{ $post->title }}</h4>

                    <div class="attachment-text">
                        <p>
                            {{ substr(Strip_tags($post->content), 0, 200) }}
                            <a data-toggle="collapse" href="#more{{ $post->id }}" 
                                role="button" aria-expanded="true" 
                                aria-controls="collapseExample" class="text-primary">more</a> 
                        </p>
                        <div class="collapse" id="more{{ $post->id }}">
                            <p><?php echo $post->content ?></p>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
@endforeach
@else
    <div class="alert alert-danger">
        No announcement found.
    </div>
@endif
<span class="float-right">{{ $posts->links() }}</span>

@elseif($page == 'vacancies')
<div class="card">
    <div class="card-body">
        <div class="alert alert-info">Click the position name to collapse its details and click the Apply button 
            if interested to apply for the said position. To successfully apply though, you 
            need to have a confirmed account. Click the register option on the navigator bar 
            to create an account.</div>
        <div id="accordion">
            <?php $vacancies = App\Models\Vacancy::where('status', '=', 1)
                ->orderBy('vacancylevel', 'desc')
                ->orderBy('salarygrade', 'desc')
                ->orderBy('name', 'asc')
                ->get(); ?>

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
                                        <p>{{ $vacancy->name ?? '' }}<br>(SG {{ $vacancy->salarygrade ?? '' }})</p>
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
<?php $posts = App\Models\Post::where('type', '=', $page)
    ->orderBy('created_at', 'desc')
    ->paginate(3); ?>

@if(sizeof($posts) > 0)
    @foreach($posts as $post)           
        <div class="callout callout-default">
            <div class="attachment-block clearfix">
                <img class="attachment-img" src="{{ asset('storage/images/logo.png') }}" alt="Site Logo">
                <div class="attachment-pushed">
                    <h4 class="attachment-heading pt-2 pb-2">
                        {{ $post->title }}</h4>

                    <div class="attachment-text">
                        <p>
                            {{ substr(Strip_tags($post->content), 0, 200) }}
                            <a data-toggle="collapse" href="#more{{ $post->id }}" 
                                role="button" aria-expanded="true" 
                                aria-controls="collapseExample" class="text-primary">more</a> 
                        </p>
                        <div class="collapse" id="more{{ $post->id }}">
                            <p><?php echo $post->content ?></p>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
@endforeach
@else
    <div class="alert alert-danger">
        No announcement found.
    </div>
@endif
<span class="float-right">{{ $posts->links() }}</span>

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