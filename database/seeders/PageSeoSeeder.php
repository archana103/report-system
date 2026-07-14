<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSeo;

class PageSeoSeeder extends Seeder
{
    public function run()
    {
        PageSeo::truncate();

        $data = [
            '/' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<title>Epignosis Insights - Market Research Reports and Industry Analysis</title>
<meta name="title" content="Epignosis Insights - Market Research Reports and Industry Analysis">
<meta name="description" content="Explore market research reports, industry analysis, trends, forecasts, blogs, and press releases from Epignosis Insights.">
<link rel="canonical" href="https://epignosisinsights.com/">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index, follow">
<meta name="author" content="Epignosis Insights">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:title" content="Epignosis Insights - Market Research Reports and Industry Analysis">
<meta property="og:description" content="Explore market research reports, industry analysis, trends, forecasts, blogs, and press releases from Epignosis Insights.">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
<meta property="og:locale" content="en_US">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/">
<meta name="twitter:title" content="Epignosis Insights - Market Research Reports and Industry Analysis">
<meta name="twitter:description" content="Explore market research reports, industry analysis, trends, forecasts, blogs, and press releases from Epignosis Insights.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Epignosis Insights",
  "url": "https://epignosisinsights.com/",
  "logo": "https://epignosisinsights.com/logo.png",
  "description": "Epignosis Insights provides market research reports, industry analysis, trends, forecasts, blogs, and press releases across various industries."
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Epignosis Insights",
  "url": "https://epignosisinsights.com/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://epignosisinsights.com/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
EOT
            ],
            'blogs' => [
                'raw_tags' => <<<EOT
<title>Blog - Market Research Insights & Industry Trends | Epignosis Insights</title>
<meta name="description" content="Read the latest blog articles from Epignosis Insights covering market trends, industry analysis, forecasts, and expert commentary across sectors.">
<link rel="canonical" href="https://epignosisinsights.com/blogs">
<meta name="robots" content="index, follow">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/blogs">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:title" content="Blog - Market Research Insights & Industry Trends | Epignosis Insights">
<meta property="og:description" content="Read the latest blog articles from Epignosis Insights covering market trends, industry analysis, forecasts, and expert commentary across sectors.">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
<meta property="og:locale" content="en_US">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/blogs">
<meta name="twitter:title" content="Blog - Market Research Insights & Industry Trends | Epignosis Insights">
<meta name="twitter:description" content="Read the latest blog articles from Epignosis Insights covering market trends, industry analysis, forecasts, and expert commentary across sectors.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Blog",
  "@id": "https://epignosisinsights.com/blogs",
  "name": "Epignosis Insights Blog",
  "url": "https://epignosisinsights.com/blogs",
  "description": "Blog articles covering market trends, industry analysis, forecasts, and expert commentary from Epignosis Insights.",
  "publisher": {
    "@type": "Organization",
    "name": "Epignosis Insights",
    "url": "https://epignosisinsights.com/",
    "logo": {
      "@type": "ImageObject",
      "url": "https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png"
    }
  }
}
</script>
EOT
            ],
            'about-us' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<title>About Us | Epignosis Insights - Market Research Reports & Industry Analysis</title>
<meta name="description" content="Learn about Epignosis Insights, a trusted source for market research reports, industry analysis, trends, and forecasts. Discover our mission and expertise.">
<meta name="keywords" content="Epignosis Insights, about us, market research company, industry analysis, market reports, business insights">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/about-us">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/about-us">
<meta property="og:title" content="About Us | Epignosis Insights">
<meta property="og:description" content="Learn about Epignosis Insights, a trusted source for market research reports, industry analysis, trends, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/about-us">
<meta name="twitter:title" content="About Us | Epignosis Insights">
<meta name="twitter:description" content="Learn about Epignosis Insights, a trusted source for market research reports, industry analysis, trends, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => null,
            ],
            'services' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<title>Epignosis Insights - Market Research Reports and Industry Analysis</title>
<meta name="description" content="Explore market research reports, industry analysis, trends, forecasts, blogs, and press releases from Epignosis Insights.">
<meta name="keywords" content="market research services, industry analysis, market research reports, custom research, syndicated reports, industry forecasts">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/services">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/services">
<meta property="og:title" content="Services | Epignosis Insights - Market Research Reports and Industry Analysis">
<meta property="og:description" content="Explore market research reports, industry analysis, trends, forecasts, blogs, and press releases from Epignosis Insights.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/services">
<meta name="twitter:title" content="Services | Epignosis Insights - Market Research Reports and Industry Analysis">
<meta name="twitter:description" content="Explore market research reports, industry analysis, trends, forecasts, blogs, and press releases from Epignosis Insights.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => null,
            ],
            'contact-us' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<title>Contact Us | Epignosis Insights - Market Research Reports and Industry Analysis</title>
<meta name="description" content="Get in touch with Epignosis Insights for market research reports, custom research, and industry analysis. Reach our team for inquiries, support, or partnerships.">
<meta name="keywords" content="contact Epignosis Insights, market research inquiries, get in touch, customer support, request a report">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/contact-us">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/contact-us">
<meta property="og:title" content="Contact Us | Epignosis Insights">
<meta property="og:description" content="Get in touch with Epignosis Insights for market research reports, custom research, and industry analysis.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/contact-us">
<meta name="twitter:title" content="Contact Us | Epignosis Insights">
<meta name="twitter:description" content="Get in touch with Epignosis Insights for market research reports, custom research, and industry analysis.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => null,
            ],
            'press-releases' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<title>Press Releases | Epignosis Insights - Market Research Reports and Industry Analysis</title>
<meta name="description" content="Read the latest press releases from Epignosis Insights covering new market research reports, industry analysis, trends, and forecasts.">
<meta name="keywords" content="Epignosis Insights press releases, market research news, industry analysis news, latest reports, press announcements">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/press-releases">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/press-releases">
<meta property="og:title" content="Press Releases | Epignosis Insights">
<meta property="og:description" content="Read the latest press releases from Epignosis Insights covering new market research reports, industry analysis, trends, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/press-releases">
<meta name="twitter:title" content="Press Releases | Epignosis Insights">
<meta name="twitter:description" content="Read the latest press releases from Epignosis Insights covering new market research reports, industry analysis, trends, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => null,
            ],
            'reports' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<title>Reports | Epignosis Insights - Market Research Reports and Industry Analysis</title>
<meta name="description" content="Browse market research reports from Epignosis Insights, covering industry analysis, market size, trends, and forecasts across sectors worldwide.">
<meta name="keywords" content="market research reports, industry reports, market analysis, market forecasts, syndicated reports, custom research reports">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/reports">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/reports">
<meta property="og:title" content="Reports | Epignosis Insights">
<meta property="og:description" content="Browse market research reports from Epignosis Insights, covering industry analysis, market size, trends, and forecasts across sectors worldwide.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/reports">
<meta name="twitter:title" content="Reports | Epignosis Insights">
<meta name="twitter:description" content="Browse market research reports from Epignosis Insights, covering industry analysis, market size, trends, and forecasts across sectors worldwide.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => null,
            ],
            'industry/aerospace-defense' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<title>Aerospace & Defense Market Research Reports | Epignosis Insights</title>
<meta name="description" content="Explore aerospace and defense market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="aerospace market research, defense industry reports, aerospace and defense market size, defense market forecast, military technology market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/aerospace-defense">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/aerospace-defense">
<meta property="og:title" content="Aerospace & Defense Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore aerospace and defense market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/aerospace-defense">
<meta name="twitter:title" content="Aerospace & Defense Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore aerospace and defense market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industries",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Aerospace & Defense",
      "item": "https://epignosisinsights.com/industry/aerospace-defense"
    }
  ]
}
</script>
EOT
            ],
            'industry/agriculture' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<title>Agriculture Market Research Reports | Epignosis Insights</title>
<meta name="description" content="Explore agriculture market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts for the agriculture sector.">
<meta name="keywords" content="agriculture market research, agriculture industry reports, agriculture market size, agritech market forecast, farming industry analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/agriculture">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/agriculture">
<meta property="og:title" content="Agriculture Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore agriculture market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts for the agriculture sector.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/agriculture">
<meta name="twitter:title" content="Agriculture Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore agriculture market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts for the agriculture sector.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industries",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Agriculture",
      "item": "https://epignosisinsights.com/industry/agriculture"
    }
  ]
}
</script>
EOT
            ],
            'industry/automotive-transportation' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<meta name="title" content="Automotive & Transportation Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore automotive and transportation market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="automotive market research, transportation industry reports, automotive market size, EV market forecast, transportation industry analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/automotive-transportation">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/automotive-transportation">
<meta property="og:title" content="Automotive & Transportation Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore automotive and transportation market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/automotive-transportation">
<meta name="twitter:title" content="Automotive & Transportation Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore automotive and transportation market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industries",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Automotive & Transportation",
      "item": "https://epignosisinsights.com/industry/automotive-transportation"
    }
  ]
}
</script>
EOT
            ],
            'industry/chemicals-materials' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<meta name="title" content="Chemicals & Materials Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore chemicals and materials market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="chemicals market research, materials industry reports, specialty chemicals market size, chemical industry forecast, materials science market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/chemicals-materials">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/chemicals-materials">
<meta property="og:title" content="Chemicals & Materials Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore chemicals and materials market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/chemicals-materials">
<meta name="twitter:title" content="Chemicals & Materials Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore chemicals and materials market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industries",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Chemicals & Materials",
      "item": "https://epignosisinsights.com/industry/chemicals-materials"
    }
  ]
}
</script>
EOT
            ],
            'industry/construction-manufacturing' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<meta name="title" content="Construction & Manufacturing Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore construction and manufacturing market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="construction market research, manufacturing industry reports, construction market size, industrial manufacturing forecast, building materials market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/construction-manufacturing">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/construction-manufacturing">
<meta property="og:title" content="Construction & Manufacturing Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore construction and manufacturing market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/construction-manufacturing">
<meta name="twitter:title" content="Construction & Manufacturing Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore construction and manufacturing market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industries",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Construction & Manufacturing",
      "item": "https://epignosisinsights.com/industry/construction-manufacturing"
    }
  ]
}
</script>
EOT
            ],
            'industry/consumer-goods' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<meta name="title" content="Consumer Goods Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore consumer goods market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="consumer goods market research, FMCG industry reports, consumer goods market size, packaged goods forecast, retail consumer market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/consumer-goods">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/consumer-goods">
<meta property="og:title" content="Consumer Goods Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore consumer goods market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/consumer-goods">
<meta name="twitter:title" content="Consumer Goods Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore consumer goods market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industries",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Consumer Goods",
      "item": "https://epignosisinsights.com/industry/consumer-goods"
    }
  ]
}
</script>
EOT
            ],
            'industry/energy-power' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<meta name="title" content="Energy & Power Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore energy and power market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="energy market research, power industry reports, renewable energy market size, oil and gas market forecast, electricity market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/energy-power">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/energy-power">
<meta property="og:title" content="Energy & Power Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore energy and power market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/energy-power">
<meta name="twitter:title" content="Energy & Power Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore energy and power market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industries",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Energy & Power",
      "item": "https://epignosisinsights.com/industry/energy-power"
    }
  ]
}
</script>
EOT
            ],
            'industry/food-beverage' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<meta name="title" content="Food & Beverage Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore food and beverage market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="food and beverage market research, F&B industry reports, food market size, beverage industry forecast, packaged food market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/food-beverage">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/food-beverage">
<meta property="og:title" content="Food & Beverage Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore food and beverage market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/food-beverage">
<meta name="twitter:title" content="Food & Beverage Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore food and beverage market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industries",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Food & Beverage",
      "item": "https://epignosisinsights.com/industry/food-beverage"
    }
  ]
}
</script>
EOT
            ],
            'industry/healthcare-pharmaceuticals' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<meta name="title" content="Healthcare & Pharmaceuticals Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore healthcare and pharmaceuticals market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="healthcare market research, pharmaceuticals industry reports, healthcare market size, drug development forecast, medical devices market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/healthcare-pharmaceuticals">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/healthcare-pharmaceuticals">
<meta property="og:title" content="Healthcare & Pharmaceuticals Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore healthcare and pharmaceuticals market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/healthcare-pharmaceuticals">
<meta name="twitter:title" content="Healthcare & Pharmaceuticals Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore healthcare and pharmaceuticals market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industries",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Healthcare & Pharmaceuticals",
      "item": "https://epignosisinsights.com/industry/healthcare-pharmaceuticals"
    }
  ]
}
</script>
EOT
            ],
            'industry/ict' => [
                'raw_tags' => <<<EOT
<!-- Primary Meta Tags -->
<meta name="title" content="ICT Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore ICT market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts for the technology and communications sector.">
<meta name="keywords" content="ICT market research, IT industry reports, telecom market size, software market forecast, technology market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/ict">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/ict">
<meta property="og:title" content="ICT Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore ICT market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/ict">
<meta name="twitter:title" content="ICT Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore ICT market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industry",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "ICT",
      "item": "https://epignosisinsights.com/industry/ict"
    }
  ]
}
</script>
EOT
            ],
            'industry/machinery-equipment' => [
                'raw_tags' => <<<EOT
<meta name="title" content="Machinery & Equipment Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore machinery and equipment market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="machinery market research, industrial equipment reports, heavy machinery market size, equipment industry forecast, capital goods market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/machinery-equipment">

<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/machinery-equipment">
<meta property="og:title" content="Machinery & Equipment Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore machinery and equipment market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/machinery-equipment">
<meta name="twitter:title" content="Machinery & Equipment Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore machinery and equipment market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industry",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Machinery & Equipment",
      "item": "https://epignosisinsights.com/industry/machinery-equipment"
    }
  ]
}
</script>
EOT
            ],
            'industry/medical-devices' => [
                'raw_tags' => <<<EOT
<meta name="title" content="Medical Devices Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore medical devices market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="medical devices market research, medtech industry reports, diagnostic devices market size, surgical instruments forecast, healthcare technology market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/medical-devices">

<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/medical-devices">
<meta property="og:title" content="Medical Devices Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore medical devices market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/medical-devices">
<meta name="twitter:title" content="Medical Devices Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore medical devices market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industry",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Medical Devices",
      "item": "https://epignosisinsights.com/industry/medical-devices"
    }
  ]
}
</script>
EOT
            ],
            'industry/semiconductors-electronics' => [
                'raw_tags' => <<<EOT
<meta name="title" content="Semiconductors & Electronics Market Research Reports | Epignosis Insights">
<meta name="description" content="Explore semiconductors and electronics market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="keywords" content="semiconductor market research, electronics industry reports, chip market size, consumer electronics forecast, semiconductor manufacturing market analysis">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/industry/semiconductors-electronics">

<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/industry/semiconductors-electronics">
<meta property="og:title" content="Semiconductors & Electronics Market Research Reports | Epignosis Insights">
<meta property="og:description" content="Explore semiconductors and electronics market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta property="og:site_name" content="Epignosis Insights">
<meta property="og:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://epignosisinsights.com/industry/semiconductors-electronics">
<meta name="twitter:title" content="Semiconductors & Electronics Market Research Reports | Epignosis Insights">
<meta name="twitter:description" content="Explore semiconductors and electronics market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.">
<meta name="twitter:image" content="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/logo.png">
EOT,
                'schema_tag' => <<<EOT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://epignosisinsights.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Industry",
      "item": "https://epignosisinsights.com/industry"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Semiconductors & Electronics",
      "item": "https://epignosisinsights.com/industry/semiconductors-electronics"
    }
  ]
}
</script>
EOT
            ],
            'terms-and-conditions' => [
                'raw_tags' => <<<EOT
<meta name="title" content="Terms and Conditions | Epignosis Insights">
<meta name="description" content="Read the terms and conditions governing the use of Epignosis Insights' website, reports, and services.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/terms-and-conditions">

<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/terms-and-conditions">
<meta property="og:title" content="Terms and Conditions | Epignosis Insights">
<meta property="og:description" content="Read the terms and conditions governing the use of Epignosis Insights' website, reports, and services.">
<meta property="og:site_name" content="Epignosis Insights">

<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="https://epignosisinsights.com/terms-and-conditions">
<meta name="twitter:title" content="Terms and Conditions | Epignosis Insights">
<meta name="twitter:description" content="Read the terms and conditions governing the use of Epignosis Insights' website, reports, and services.">
EOT,
                'schema_tag' => null,
            ],
            'privacy-policy' => [
                'raw_tags' => <<<EOT
<meta name="title" content="Privacy Policy | Epignosis Insights">
<meta name="description" content="Learn how Epignosis Insights collects, uses, and protects your personal information across our website and services.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://epignosisinsights.com/privacy-policy">

<meta property="og:type" content="website">
<meta property="og:url" content="https://epignosisinsights.com/privacy-policy">
<meta property="og:title" content="Privacy Policy | Epignosis Insights">
<meta property="og:description" content="Learn how Epignosis Insights collects, uses, and protects your personal information across our website and services.">
<meta property="og:site_name" content="Epignosis Insights">

<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="https://epignosisinsights.com/privacy-policy">
<meta name="twitter:title" content="Privacy Policy | Epignosis Insights">
<meta name="twitter:description" content="Learn how Epignosis Insights collects, uses, and protects your personal information across our website and services.">
EOT,
                'schema_tag' => null,
            ],
        ];

        foreach ($data as $urlPath => $record) {
            PageSeo::updateOrCreate(
                ['url_path' => $urlPath],
                [
                    'schema_tag' => $record['schema_tag'] ?? null,
                    'raw_tags' => $record['raw_tags'],
                ]
            );
        }
    }
}
