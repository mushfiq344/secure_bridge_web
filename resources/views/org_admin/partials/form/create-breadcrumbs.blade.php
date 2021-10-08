<div class="columns is-vcentered">
    <div class="column is-8 is-offset-2">
        <div class="inline-list has-text-centered">
            <div>Create {{ ucfirst($featureName) }}</div>
            <i class="inline-bullet fa fa-circle"></i>
            <div><a href="/org-admin/home">Home</a></div>
            <i class="inline-bullet fa fa-circle"></i>
            <div><a href="/org-admin/{{ \Str::plural($featureName) }}">{{ ucfirst(\Str::plural($featureName)) }}</a>
            </div>
            <i class="inline-bullet fa fa-circle"></i>
            <div>Create {{ ucfirst($featureName) }}</div>

        </div>
    </div>
</div>