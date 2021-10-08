<div class="column is-12">

    <div class="blog-sidebar">

        <div class="blog-sidebar-categories">
            <h4>Total results ({{$opportunities->total()}})</h4>
        </div>
    </div>
</div>




@foreach($opportunities as $opportunity)


<!-- Blog post -->

<div class="column is-6">
    <div class="card blog-grid-item">
        <div class="card-image" style="position:relative;">
            <div style="position:absolute; right:1.5rem; top:1.5rem;">
                @if(\App\Models\OpportunityUser::hasUserEnrolledOpportunity($opportunity->id))
                <i class="fa fa-heart mr-2 enrolled" opportunity-id="{{$opportunity->id}}" task="un-enroll"></i>
                @else
                <i class="fa fa-heart mr-2 un-enrolled" opportunity-id="{{$opportunity->id}}" task="enroll"></i>
                @endif

                @if(\App\Models\WishList::hasListedOpportunity($opportunity->id))
                <i class="fa fa-shopping-cart added-in-wishlist" opportunity-id="{{$opportunity->id}}"
                    task="remove"></i>
                @else
                <i class="fa fa-shopping-cart not-added-in-wishlist" opportunity-id="{{$opportunity->id}}"
                    task="add"></i>
                @endif

            </div>
            <a href="/opportunities/{{$opportunity->slug}}">
                @if(!empty($opportunity->cover_image))
                <img class="item-featured-image" src="{{url($uploadPath.$opportunity->cover_image)}}"
                    data-demo-src="assets/img/demo/posts/post-1.jpg" alt="">
                @else
                <img class="item-featured-image" src="{{url('images/static_images/default_logo.png')}}"
                    data-demo-src="assets/img/demo/posts/post-1.jpg" alt="">
                @endif
            </a>

        </div>
        <div class="card-content">
            <div class="featured-post-title">
                <div class="title-avatar">
                    @if(!empty($opportunity->icon_image))
                    <img src="{{url($uploadPath.$opportunity->icon_image)}}" alt=""
                        data-demo-src="assets/img/avatars/alan.jpg">
                    @else
                    <img src="{{url('images/static_images/default_logo.png')}}" alt=""
                        data-demo-src="assets/img/avatars/alan.jpg">
                    @endif
                </div>
                <div class="title-meta">
                    <h2 class="post-title"> <a href="/opportunities/{{$opportunity->slug}}">{{$opportunity->title}}</a>
                    </h2>
                    <h4 class="post-subtitle">
                        <span>by <a class="author-name"
                                href="/opportunities/{{$opportunity->slug}}">{{\App\Models\User::getUserName($opportunity->created_by)}}</a></span>
                        <i class="fa fa-circle"></i>
                        <span>Posted in <a href="/opportunities/{{$opportunity->slug}}"></a></span>
                    </h4>
                </div>
            </div>
            <p>{{\App\SecureBridges\Helpers\CustomHelper::limit_text($opportunity->description,15)}}</p>
            <a href="/opportunities/{{$opportunity->slug}}" class="read-more-link">
                Read More <span>&#10230;</span>
            </a>
        </div>
    </div>
</div>
@endforeach

<div class="columns pt-60">

    <div class="column is-12">
        {{ $opportunities->links('theme.frontend.partials.paginator') }}
    </div>

</div>