<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrNew(['email' => 'admin@example.com']);
        $user->name = 'Admin';
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->role = 'admin';
        $user->save();

        $this->command->info('Admin email: admin@example.com');
        $this->command->info('Admin password: admin123');

        // Seed 15 Dummy Blogs
        $dummyImages = [
            'blogs/E6Bj5OeHGA95ZKJFbKzF9jTQkhWpnFqKGp5yqy0U.png',
            'blogs/oRTfYNJrUnWa61AA3uHBfnfjuzjkr1aga7iLDjhu.png',
            'blogs/PK8cvOrXNFZSpXFRAKVa19QUkznau5yfxeamvwvM.jpg',
            null
        ];

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\BlogDetail::truncate();
        \App\Models\Blog::truncate(); // Clear existing blogs to keep it clean
        \App\Models\PressReleaseDetail::truncate();
        \App\Models\PressRelease::truncate(); // Clear existing press releases
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        for ($i = 1; $i <= 15; $i++) {
            $blog = \App\Models\Blog::create([
                'title' => "Top Emerging Technologies Transforming Global Industries in " . (2025 + $i),
                'description' => "This is a dummy blog description for article number {$i}. Exploring the key technologies, trends, and framework shaping growth opportunities worldwide. From AI and automation to clean energy, we look at what's next for businesses.",
                'url' => "blog-post-{$i}",
                'author_name' => "Expert Analyst " . ($i % 3 + 1),
                'image' => $dummyImages[($i - 1) % count($dummyImages)],
            ]);

            \App\Models\BlogDetail::create([
                'blog_id' => $blog->id,
                'title' => $blog->title,
                'description' => '<p>Artificial intelligence is rapidly transforming the way businesses operate, helping organizations improve efficiency, automate processes, and make smarter data-driven decisions. From predictive analytics to intelligent automation, AI technologies are reshaping industries and creating new opportunities for innovation and growth.</p><h3>The Growing Adoption of AI Across Industries</h3><p>Businesses across healthcare, finance, retail, manufacturing, and logistics are increasingly integrating artificial intelligence into their operations. AI-powered systems help organizations streamline workflows, reduce operational costs, and enhance customer experiences through automation and predictive intelligence.</p><p>The growing demand for data-driven decision-making and real-time analytics is further driving enterprise AI adoption. Companies are investing heavily in machine learning, natural language processing, and computer vision technologies to remain competitive in rapidly evolving markets.</p><h3>AI-Powered Automation & Operational Efficiency</h3><p>Automation remains one of the biggest advantages of artificial intelligence in enterprise environments. AI-driven tools can automate repetitive tasks, improve workflow efficiency, and minimize human-error across departments such as customer service, finance, human resources, and supply chain management.</p><p>Intelligent automation technologies also help organizations optimize resource allocation and improve overall productivity, enabling businesses to focus on strategic growth initiatives.</p><h3>Emerging Trends Shaping the AI Market</h3><p>Several emerging trends are influencing the future of artificial intelligence, including:</p><ul><li>Generative AI applications</li><li>AI-powered cybersecurity solutions</li><li>Cloud-based AI platforms</li><li>Edge AI technologies</li><li>Predictive business intelligence</li></ul><p>These innovations are expected to create significant growth opportunities across global industries during the forecast period.</p><h3>Challenges & Opportunities</h3><p>Despite rapid growth, businesses still face challenges related to data privacy, ethical AI implementation, and integration complexity. However, advancements in cloud infrastructure, increasing AI investments, and supportive government initiatives continue to create strong market opportunities.</p><p>Organizations that successfully adopt AI-driven strategies are likely to gain a competitive advantage through improved operational agility and smarter decision-making capabilities.</p><h3>Conclusion</h3><p>Artificial intelligence is becoming a key driver of digital transformation across industries. As AI technologies continue to evolve, businesses that embrace innovation, automation, and data-driven strategies will be better positioned for long-term growth and market leadership.</p>',
                'meta_title' => $blog->title,
                'meta_description' => "Read details about {$blog->title}. Learn about artificial intelligence, automated processes, and data-driven decision making.",
                'meta_keywords' => 'artificial intelligence, technology transformation, enterprise automation',
                'faqs' => [
                    [
                        'question' => 'Can I request customized market research?',
                        'answer' => 'Yes, we provide fully customized research reports designed to address your organization\'s unique objectives, key indicators, and data points. Share your specific scope with our team to get a project quote.'
                    ],
                    [
                        'question' => 'How quickly can I receive a sample report?',
                        'answer' => 'Sample reports are typically generated and emailed to your business address within 24 hours of form submission, following brief validation of coordinates by our client service team.'
                    ],
                    [
                        'question' => 'Which industries do you specialize in?',
                        'answer' => 'We cover several core verticals globally, including technology, consumer goods, healthcare, electronics, energy & power, finance, chemical & materials, and food & beverages.'
                    ],
                    [
                        'question' => 'How can I connect with an analyst?',
                        'answer' => 'You can submit custom requests via this form or email us directly at info@epignosisinsights.com. We schedule direct consultation briefings with industry lead analysts within 1-2 business days.'
                    ]
                ]
            ]);
        }
        $this->command->info('15 dummy blogs seeded successfully!');

        // Seed 15 Dummy Press Releases
        $dummyPrImages = [
            'press_releases/thumbnails/3oPRxJ85hjddJN1B1Go3WeQ9TPHIZHG07mywgVGJ.jpg',
            'press_releases/thumbnails/5a7c2qVhmMk3fuapGTuk4Dmv3tekKH491prVwUef.png',
            'press_releases/thumbnails/z35Rqob1yoJk0zx5aXkFDWiSpajlxW5s2yVkb6dg.png',
            'press_releases/k9YeGo5kQe8fYVZ6tK3BlNrDnfNXkpobWw6Uxtq4.jpg'
        ];

        for ($i = 1; $i <= 15; $i++) {
            $pr = \App\Models\PressRelease::create([
                'title' => ($i % 3 === 0) ? "Renewable Energy Sector Set for Significant Expansion Over the Next Decade" : (($i % 2 === 0) ? "Electric Vehicle Market Sees Surge as Global Adoption Accelerates" : "AI Market Expected to Reach $1.5 Trillion by 2030, Driven by Rapid Enterprise Adoption"),
                'description' => "Our latest research highlights the accelerating demand for key technologies driving global growth opportunities. From artificial intelligence and data networks to sustainable energy solutions, this release details market valuations, forecast timelines, and competitive strategies.",
                'url' => "press-release-{$i}",
                'status' => 'Active',
                'thumbnail_image' => $dummyPrImages[($i - 1) % count($dummyPrImages)],
            ]);

            \App\Models\PressReleaseDetail::create([
                'press_release_id' => $pr->id,
                'content' => '<p>Epignosis Insights has announced the expansion of its market research portfolio with new industry reports covering artificial intelligence, renewable energy, healthcare analytics, semiconductor technologies, and digital transformation trends. The initiative aims to provide businesses with deeper market intelligence and strategic insights across rapidly evolving global industries.</p><h3>Expanding Research Coverage Across High-Growth Industries</h3><p>Epignosis Insights continues to strengthen its position in the global market research industry by expanding its coverage across high-growth and innovation-driven sectors. The company\'s latest research initiatives focus on emerging technologies, sustainability trends, and evolving consumer and enterprise demands shaping modern industries.</p><p>The newly launched reports provide in-depth analysis of market size, growth opportunities, competitive landscape, investment trends, and future industry outlook across multiple sectors.</p><h3>Focus on Data-Driven Market Intelligence</h3><p>With increasing demand for reliable market insights, businesses are actively seeking accurate research and strategic guidance to navigate changing market conditions. Epignosis Insights combines advanced analytics, industry expertise, and comprehensive research methodologies to deliver actionable intelligence for organizations worldwide.</p><p>The expanded research portfolio aims to support enterprises, investors, consultants, and decision-makers with data-driven insights that enable informed business strategies and long-term growth planning.</p><h3>Emerging Industries Driving Market Growth</h3><p>The company\'s latest research publications focus on several rapidly growing industries, including:</p><ul><li>Artificial Intelligence & Machine Learning</li><li>Renewable Energy & Sustainability</li><li>Semiconductor & Electronics</li><li>Healthcare Analytics</li><li>Cloud Computing</li><li>Enterprise Automation</li></ul><p>These sectors are expected to witness significant market expansion driven by technological innovation, digital transformation, and increasing global investments.</p><h3>Commitment to Research Excellence</h3><p>Epignosis Insights remains committed to delivering high-quality market research solutions tailored to evolving business requirements. The company continues to invest in advanced research capabilities, data validation processes, and analyst expertise to ensure reliable and accurate market intelligence.</p>',
                'meta_title' => $pr->title,
                'meta_description' => "Read details of press release: {$pr->title}.",
                'meta_keywords' => 'press release, epignosis insights, market research',
                'slug_url' => $pr->url,
                'page_main_title' => $pr->title,
                'breadcrumb_title' => $pr->title,
            ]);
        }
        $this->command->info('15 dummy press releases seeded successfully!');
    }
}
