<div class="seo-prerender" style="position:absolute; left:-99999px; top:auto; width:1px; height:1px; overflow:hidden;">
    <h1>{{ $pressRelease->title }}</h1>
    
    @if($detail && $detail->content)
    <div>{!! $detail->content !!}</div>
    @elseif($pressRelease->description)
    <div>{!! $pressRelease->description !!}</div>
    @endif
</div>
