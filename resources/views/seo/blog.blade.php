<div class="seo-prerender" style="position:absolute; left:-99999px; top:auto; width:1px; height:1px; overflow:hidden;">
    <h1>{{ $blog->title }}</h1>
    
    @if($detail && $detail->description)
    <div>{!! $detail->description !!}</div>
    @elseif($blog->description)
    <div>{!! $blog->description !!}</div>
    @endif
</div>
