@if (Auth::check())
    
    <?php $userranking = App\Models\UserRanking::where('user_id', '=', Auth::id())->get(); ?>

    
@endif

