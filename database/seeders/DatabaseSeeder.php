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
        \App\Models\ReportDetail::truncate(); // Clear existing report details
        \App\Models\ReportList::truncate();   // Clear existing report lists
        \App\Models\ReportCategory::truncate(); // Clear existing report categories
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
                        'answer' => 'You can submit custom requests via this form or email us directly at sales@epignosisinsights.com. We schedule direct consultation briefings with industry lead analysts within 1-2 business days.'
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

        // Seed Report Categories, Report Lists, and Report Details
        $categoriesData = [
            [
                'name' => 'Technology & Media',
                'main_heading' => 'Technology & Media Market Research Reports',
                'main_subheading' => 'Explore comprehensive intelligence on enterprise software, artificial intelligence, cloud infrastructure, network systems, and digital media channels.',
                'reports' => [
                    [
                        'name' => 'Global Enterprise Generative AI Market',
                        'slug' => 'global-enterprise-generative-ai-market',
                        'sku' => 'REP-TECH-001',
                        'single_price' => '1999',
                        'team_price' => '3999',
                        'enterprise_price' => '5999',
                    ],
                    [
                        'name' => 'Cybersecurity Insurance Market Size',
                        'slug' => 'cybersecurity-insurance-market-size',
                        'sku' => 'REP-TECH-002',
                        'single_price' => '2199',
                        'team_price' => '4199',
                        'enterprise_price' => '6199',
                    ],
                    [
                        'name' => 'Cloud Native Application Protection Platforms (CNAPP) Market',
                        'slug' => 'cloud-native-cnapp-market',
                        'sku' => 'REP-TECH-003',
                        'single_price' => '2499',
                        'team_price' => '4499',
                        'enterprise_price' => '6499',
                    ],
                    [
                        'name' => 'EdTech and Smart Classroom Market',
                        'slug' => 'edtech-smart-classroom-market',
                        'sku' => 'REP-TECH-004',
                        'single_price' => '1899',
                        'team_price' => '3899',
                        'enterprise_price' => '5899',
                    ],
                ]
            ],
            [
                'name' => 'Energy & Power',
                'main_heading' => 'Energy & Power Market Research Reports',
                'main_subheading' => 'Access in-depth studies on renewable energy, smart utility grids, hydrogen fuels, energy storage solutions, and petroleum/coal processing.',
                'reports' => [
                    [
                        'name' => 'Global Solid State Battery Market',
                        'slug' => 'global-solid-state-battery-market',
                        'sku' => 'REP-ENG-001',
                        'single_price' => '1999',
                        'team_price' => '3999',
                        'enterprise_price' => '5999',
                    ],
                    [
                        'name' => 'Offshore Wind Energy Market Growth',
                        'slug' => 'offshore-wind-energy-market-growth',
                        'sku' => 'REP-ENG-002',
                        'single_price' => '2299',
                        'team_price' => '4299',
                        'enterprise_price' => '6299',
                    ],
                    [
                        'name' => 'Hydrogen Fueling Station Market',
                        'slug' => 'hydrogen-fueling-station-market',
                        'sku' => 'REP-ENG-003',
                        'single_price' => '2499',
                        'team_price' => '4499',
                        'enterprise_price' => '6499',
                    ],
                    [
                        'name' => 'Smart Grid Tech Market',
                        'slug' => 'smart-grid-tech-market',
                        'sku' => 'REP-ENG-004',
                        'single_price' => '1999',
                        'team_price' => '3999',
                        'enterprise_price' => '5999',
                    ],
                ]
            ],
            [
                'name' => 'Healthcare & Medical Devices',
                'main_heading' => 'Healthcare & Medical Devices Research Reports',
                'main_subheading' => 'Keep pace with innovations in biotechnology, surgical robotics, point-of-care diagnostics, digital therapeutics, and pharmaceutical compounds.',
                'reports' => [
                    [
                        'name' => 'Global Surgical Robotics Market',
                        'slug' => 'global-surgical-robotics-market',
                        'sku' => 'REP-MED-001',
                        'single_price' => '2499',
                        'team_price' => '4499',
                        'enterprise_price' => '6499',
                    ],
                    [
                        'name' => 'Digital Therapeutics Market Size',
                        'slug' => 'digital-therapeutics-market-size',
                        'sku' => 'REP-MED-002',
                        'single_price' => '1999',
                        'team_price' => '3999',
                        'enterprise_price' => '5999',
                    ],
                    [
                        'name' => 'Point-of-Care Diagnostics Market',
                        'slug' => 'point-of-care-diagnostics-market',
                        'sku' => 'REP-MED-003',
                        'single_price' => '2199',
                        'team_price' => '4199',
                        'enterprise_price' => '6199',
                    ],
                    [
                        'name' => 'Telehealth and Telemedicine Market',
                        'slug' => 'telehealth-telemedicine-market',
                        'sku' => 'REP-MED-004',
                        'single_price' => '1899',
                        'team_price' => '3899',
                        'enterprise_price' => '5899',
                    ],
                ]
            ],
            [
                'name' => 'Semiconductor & Electronics',
                'main_heading' => 'Semiconductor & Electronics Research Reports',
                'main_subheading' => 'Discover market forecasts on microelectronics, autonomous vehicle sensors, GaN devices, flexible circuit layouts, and display panels.',
                'reports' => [
                    [
                        'name' => 'Global GaN Semiconductor Devices Market',
                        'slug' => 'global-gan-semiconductor-market',
                        'sku' => 'REP-SEMI-001',
                        'single_price' => '1999',
                        'team_price' => '3999',
                        'enterprise_price' => '5999',
                    ],
                    [
                        'name' => 'Flexible Electronics Market Growth',
                        'slug' => 'flexible-electronics-market-growth',
                        'sku' => 'REP-SEMI-002',
                        'single_price' => '2199',
                        'team_price' => '4199',
                        'enterprise_price' => '6199',
                    ],
                    [
                        'name' => 'Automotive LiDAR Sensors Market',
                        'slug' => 'automotive-lidar-sensors-market',
                        'sku' => 'REP-SEMI-003',
                        'single_price' => '2499',
                        'team_price' => '4499',
                        'enterprise_price' => '6499',
                    ],
                    [
                        'name' => 'MicroLED Display Market Size',
                        'slug' => 'microled-display-market-size',
                        'sku' => 'REP-SEMI-004',
                        'single_price' => '2299',
                        'team_price' => '4299',
                        'enterprise_price' => '6299',
                    ],
                ]
            ],
            [
                'name' => 'Chemicals & Materials',
                'main_heading' => 'Chemicals & Materials Research Reports',
                'main_subheading' => 'Track structural shifts in biodegradable plastics, high-strength carbon fibers, graphene configurations, and industrial smart coatings.',
                'reports' => [
                    [
                        'name' => 'Global Biodegradable Plastics Market',
                        'slug' => 'global-biodegradable-plastics-market',
                        'sku' => 'REP-CHEM-001',
                        'single_price' => '1999',
                        'team_price' => '3999',
                        'enterprise_price' => '5999',
                    ],
                    [
                        'name' => 'Carbon Fiber Reinforced Polymer Market',
                        'slug' => 'carbon-fiber-reinforced-polymer-market',
                        'sku' => 'REP-CHEM-002',
                        'single_price' => '2199',
                        'team_price' => '4199',
                        'enterprise_price' => '6199',
                    ],
                    [
                        'name' => 'Graphene Nanoplatelets Market',
                        'slug' => 'graphene-nanoplatelets-market',
                        'sku' => 'REP-CHEM-003',
                        'single_price' => '2499',
                        'team_price' => '4499',
                        'enterprise_price' => '6499',
                    ],
                    [
                        'name' => 'Smart Coatings Market Size',
                        'slug' => 'smart-coatings-market-size',
                        'sku' => 'REP-CHEM-004',
                        'single_price' => '1999',
                        'team_price' => '3999',
                        'enterprise_price' => '5999',
                    ],
                ]
            ]
        ];

        foreach ($categoriesData as $catData) {
            $category = \App\Models\ReportCategory::create([
                'name' => $catData['name'],
                'status' => 'Active',
                'main_heading' => $catData['main_heading'],
                'main_subheading' => $catData['main_subheading'],
                'category_image' => null,
                'category_icon' => null,
            ]);

            foreach ($catData['reports'] as $rep) {
                $reportList = \App\Models\ReportList::create([
                    'report_category_id' => $category->id,
                    'name' => $rep['name'],
                    'status' => 'Active',
                ]);

                \App\Models\ReportDetail::create([
                    'report_list_id' => $reportList->id,
                    'title' => $rep['name'] . " - Market Analysis, Size, Share, Growth, Trends and Forecast (2025 - 2030)",
                    'slug_url' => $rep['slug'],
                    'breadcrumb_title' => $rep['name'],
                    'page_main_title' => $rep['name'] . " Market Growth Opportunities",
                    'report_sku' => $rep['sku'],
                    'description' => '<p>The global ' . strtolower($rep['name']) . ' study offers a detailed analysis of key market dynamics, including current drivers, limiting constraints, high-potential opportunities, and ongoing industrial trends shaping the overall product landscape. The research incorporates extensive primary and secondary intelligence gathered from leading key executives, manufacturing experts, supply chain consultants, and corporate partners globally.</p><h3>Competitive Landscape Analysis</h3><p>The report provides a thorough analysis of the leading vendor profiles operating in this industry. Companies are analyzed based on their product portfolio, business overview, geographical presence, key developments, strategic partnerships, and financial performance metrics.</p><p>Key manufacturers are focusing heavily on technical research & development, product customization, and mergers & acquisitions to capture a larger share of the market and expand into emerging regional economies.</p><h3>Key Market Segmentation</h3><p>The market is segmented based on product configurations, terminal applications, distribution channels, and regional locations:</p><ul><li>By Product: Standard, Advanced, High-performance</li><li>By Application: Industrial, Commercial, Healthcare, Aerospace, Consumer Electronics</li><li>By Region: North America, Europe, Asia-Pacific, LAMEA</li></ul><p>Each segmentation group is thoroughly evaluated to determine historic valuation, current share, growth parameters, and future demand forecast.</p><h3>Regional Insights</h3><p>Geographically, North America currently holds the dominant share in global consumption due to advanced automation hubs and rapid tech deployments. However, the Asia-Pacific region is projected to emerge as the fastest growing geographic market over the forecast timeline, driven by rapid industrialization, increasing investments, and supportive government initiatives.</p>',
                    'table_of_contents' => '<ul><li><strong>1. Executive Summary</strong><ul><li>1.1 Market Snapshot</li><li>1.2 Global Market Trends & Drivers</li></ul></li><li><strong>2. Research Methodology</strong><ul><li>2.1 Research Design & Framework</li><li>2.2 Primary & Secondary Data Sources</li></ul></li><li><strong>3. Market Outlook & Dynamics</strong><ul><li>3.1 Market Forces & Indicators</li><li>3.2 Drivers, Constraints & Opportunities</li></ul></li><li><strong>4. Competitive Positioning Analysis</strong><ul><li>4.1 Major Vendor Profiling</li><li>4.2 Core Market Strategy</li></ul></li></ul>',
                    'single_user_license_cost' => $rep['single_price'],
                    'team_user_license_cost' => $rep['team_price'],
                    'enterprise_user_license_cost' => $rep['enterprise_price'],
                    'download_text' => 'Download Sample Report PDF',
                    'image' => '/assets/images/default-report.png',
                    'status' => 'Active',
                    'meta_title' => $rep['name'] . ' Share & Forecast 2030',
                    'meta_description' => 'Detailed research report on the ' . strtolower($rep['name']) . ' including size, trends, key drivers, restraints, competitive analysis, and regional forecast.',
                    'meta_keywords' => strtolower($rep['name']) . ', market report, industry outlook',
                    'faqs' => [
                        [
                            'question' => 'What is the projected growth rate (CAGR) of this market?',
                            'answer' => 'The market is projected to grow at a compound annual growth rate (CAGR) of 14.5% during the forecast period from 2025 to 2030, driven by rapid technological advancements and increasing commercial adoption.'
                        ],
                        [
                            'question' => 'Who are the key players operating in this industry?',
                            'answer' => 'The leading global companies covered in this report include key industry conglomerates, specialist innovators, and technology pioneers who dominate the competitive market space.'
                        ],
                        [
                            'question' => 'Which region currently leads the market share?',
                            'answer' => 'North America currently holds the largest market share due to mature infrastructure and early adoption, while the Asia-Pacific region is expected to register the fastest growth rate during the forecast period.'
                        ],
                        [
                            'question' => 'Does this report include data on the impact of regulatory guidelines?',
                            'answer' => 'Yes, a comprehensive regulatory analysis chapter is included, detailing regional policies, environmental compliances, and trade standards affecting product supply chain and manufacturing operations.'
                        ]
                    ]
                ]);
            }
        }
        $this->command->info('20 dummy reports, categories, and details seeded successfully!');
    }
}
