<div class="seo-prerender" style="position:absolute; left:-99999px; top:auto; width:1px; height:1px; overflow:hidden;">
    <h1>{{ $report->title ?: optional($report->reportList)->name }}</h1>
    
    @if($report->detail_description)
    <div>{!! $report->detail_description !!}</div>
    @endif
    
    @if($report->table_of_content)
    <h2>Table of Contents</h2>
    <div>{!! $report->table_of_content !!}</div>
    @endif

    @if($report->market_segmentation)
    <h2>Market Segmentation</h2>
    <div>{!! $report->market_segmentation !!}</div>
    @endif

    @if($report->research_methodology)
    <h2>Research Methodology</h2>
    <div>{!! $report->research_methodology !!}</div>
    @endif
</div>
