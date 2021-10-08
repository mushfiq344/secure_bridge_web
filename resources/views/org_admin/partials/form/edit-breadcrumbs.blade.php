<div class="columns is-vcentered">
    <div class="column is-8 is-offset-2">
        <div class="inline-list has-text-centered">
            <div>Edit {{ ucfirst($featureName) }}</div>
            <i class="inline-bullet fa fa-circle"></i>
            <div><a href="/org-admin/home">Dashboard</a></div>
            <i class="inline-bullet fa fa-circle"></i>
            <div><a href="/org-admin/{{ \Str::plural($featureName) }}">{{ ucfirst(\Str::plural($featureName)) }}</a>
            </div>
            <i class="inline-bullet fa fa-circle"></i>
            <div>Edit {{ ucfirst($featureName) }}</div>

        </div>
    </div>
</div>