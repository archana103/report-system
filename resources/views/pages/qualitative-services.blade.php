@extends('layouts.public')

@section('content')

    <div class="qualitative-page">
        

        <main class="qualitative-main">
            <!-- Hero Section -->
            <section class="qual-hero"
                style="background-image: url('{{ env('AWS_URL') }}/assets/images/qualitative/Herosection_image.png')">
                <div class="qual-hero-content section-shell">
                    <h1 class="qual-title">
                        Qualitative <span class="highlight-blue">Research</span>
                    </h1>
                    <p class="qual-subtitle">In-Depth Interviews, Focus Groups & Surveys That Reveal the "Why" Behind
                        the Data</p>
                    <p class="qual-desc">
                        At Epignosis Insights, we go beyond the numbers to uncover the motivations, attitudes, and lived
                        experiences that shape decision-making.
                    </p>
                    <div class="qual-hero-cta">
                        <span class="qual-outline-btn">Focus Group Discussions</span>
                        <span class="qual-outline-btn">In-Depth Interviews</span>
                        <span class="qual-outline-btn">Actionable Insights</span>
                        <span class="qual-outline-btn">Structured Surveys</span>
                        <span class="qual-outline-btn">Global Research Expertise</span>
                    </div>
                </div>
            </section>

            <!-- What Is Qualitative Research -->
            <section class="qual-about-section section-shell">
                <div class="qual-text-content">
                    <h2>What Is Qualitative Research?</h2>
                    <p>
                        Qualitative research is an exploratory approach to understanding people their beliefs,
                        motivations, pain points, and decision triggers through open-ended, conversational methods
                        rather than closed, numerical ones. Where quantitative research tells you what is happening and
                        at what scale, qualitative research tells you why it is happening. It is the method of choice
                        when a business needs to explore a new concept, understand emotional and behavioural drivers, or
                        add depth and context to numbers that raise more questions than they answer.
                    </p>
                    <p>
                        Our qualitative research team blends structured methodology with flexible, real-time
                        exploration. Every engagement is built around your specific research objectives, target
                        audience, and the decisions the findings will inform not a one-size-fits-all discussion guide.
                    </p>
                </div>
                <div class="qual-image-content">
                    <img src="{{ env('AWS_URL') }}/assets/images/qualitative/qualitativeimage1.png"
                        alt="Epignosis Insights Business Overview" class="qual-image" />
                </div>
            </section>

            <!-- Methodologies Section -->
            <section class="qual-methodology-section section-shell">
                <div class="methodology-header">
                    <h2>Our Qualitative Research Methodologies</h2>
                    <p>We design and field three core qualitative methodologies, often in combination, depending on the
                        depth, speed, and reach your research question demands.</p>
                </div>

                <div class="methodology-grid">
                    <!-- Left: GIF Image -->
                    <div class="methodology-image-container">
                        <video autoplay loop muted playsinline class="qual-method-gif">
                            <source src="{{ env('AWS_URL') }}/assets/images/qualitative/qualitative_image2.mp4"
                                type="video/mp4" />
                        </video>
                    </div>

                    <!-- Right: Cards -->
                    <div class="methodology-cards">
                        <!-- Card 1 -->
                        <div class="method-card">
                            <div class="method-card-header">
                                <h3>In-Depth Interviews (IDIs)</h3>
                                <span class="method-number">1</span>
                            </div>
                            <div class="method-card-body">
                                <p><strong>What it is:</strong> One-on-one, semi-structured interviews (30-60 minutes).
                                </p>
                                <p><strong>Best used when:</strong> Exploring sensitive or complex topics like B2B
                                    decisions, patient experiences, and executive perspectives.</p>
                                <p><strong>What you get:</strong> Rich insights, verbatim quotes, decision journeys, and
                                    thematic findings aligned with research objectives.</p>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="method-card">
                            <div class="method-card-header">
                                <h3>Focus Group Discussions (FGDs)</h3>
                                <span class="method-number">2</span>
                            </div>
                            <div class="method-card-body">
                                <p><strong>What it is:</strong> Moderated discussions with 6-9 participants.</p>
                                <p><strong>Best used when:</strong> Testing consumer reactions to concepts, messaging,
                                    or products through group interaction.</p>
                                <p><strong>What you get:</strong> Group insights, concept feedback, annotated
                                    highlights, and comparative segment analysis.</p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="method-card">
                            <div class="method-card-header">
                                <h3>Qualitative &amp; Semi-Structured Surveys</h3>
                                <span class="method-number">3</span>
                            </div>
                            <div class="method-card-body">
                                <p><strong>What it is:</strong> Open-ended surveys collecting written or recorded
                                    responses.</p>
                                <p><strong>Best used when:</strong> Gathering exploratory feedback from a broader
                                    audience or supporting IDIs and FGDs.</p>
                                <p><strong>What you get:</strong> Coded themes, sentiment analysis, key quotes, and data
                                    ready for quantitative validation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Process Section -->
            <section class="qual-process-section section-shell">
                <div class="process-header">
                    <h2>Our Qualitative Research Process</h2>
                    <p>Every qualitative engagement at Epignosis Insights follows a disciplined, transparent process
                        from the first scoping conversation to the final insights report so that findings are credible,
                        traceable, and ready to act on.</p>
                </div>

                <div class="process-grid">
                    <!-- Card 1 -->
                    <div class="process-card">
                        <div class="process-number">
                            <span class="num-text">1</span>
                            <div class="num-circle"></div>
                        </div>
                        <h3>Define Objectives</h3>
                        <p>We work with your team to translate business questions into a clear, answerable research
                            brief defining the audience, the decisions at stake, and the success criteria for the study.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="process-card">
                        <div class="process-number">
                            <span class="num-text">2</span>
                            <div class="num-circle"></div>
                        </div>
                        <h3>Design the Discussion Guide</h3>
                        <p>Our research leads draft moderator guides and questionnaires that balance structure with room
                            for organic exploration, pre-tested for clarity and neutrality.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="process-card">
                        <div class="process-number">
                            <span class="num-text">3</span>
                            <div class="num-circle"></div>
                        </div>
                        <h3>Recruit Participants</h3>
                        <p>Recruit qualified respondents through partner panels, networks, and targeted screening,
                            including hard-to-reach audiences.</p>
                    </div>

                    <!-- Card 4 -->
                    <div class="process-card">
                        <div class="process-number">
                            <span class="num-text">4</span>
                            <div class="num-circle"></div>
                        </div>
                        <h3>Conduct IDIs, Focus Groups &amp; Surveys</h3>
                        <p>Trained, experienced moderators lead every session, in person or via secure virtual
                            platforms, with simultaneous translation available for multi-market studies.</p>
                    </div>

                    <!-- Card 5 -->
                    <div class="process-card">
                        <div class="process-number">
                            <span class="num-text">5</span>
                            <div class="num-circle"></div>
                        </div>
                        <h3>Transcribe &amp; Code Data</h3>
                        <p>Recordings are transcribed and systematically coded against a shared thematic framework,
                            ensuring consistency across moderators, markets, and languages.</p>
                    </div>

                    <!-- Card 6 -->
                    <div class="process-card">
                        <div class="process-number">
                            <span class="num-text">6</span>
                            <div class="num-circle"></div>
                        </div>
                        <h3>Synthesize &amp; Report Insights</h3>
                        <p>Findings are distilled into client-ready reports combining thematic analysis, verbatim
                            evidence, and visual synthesis mapped directly back to your original business objectives.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Decisions Section -->
            <section class="qual-decisions-section section-shell">
                <div class="decisions-header">
                    <h2>Where Qualitative Insights Drive Decisions</h2>
                    <p>Clients turn to our qualitative research practice across a wide range of strategic and
                        operational decisions. The chart below reflects the typical distribution of qualitative
                        engagements we support.</p>
                </div>

                <div class="decisions-video-container">
                    <video autoplay loop muted playsinline class="qual-decision-video">
                        <source src="{{ env('AWS_URL') }}/assets/images/qualitative/qualitative_image1.mp4"
                            type="video/mp4" />
                    </video>
                </div>
            </section>

            <!-- Why Choose Us Section -->
            <section class="qual-why-choose section-shell">
                <div class="why-header">
                    <h2>Why Choose Epignosis Insights for<br />Qualitative Research</h2>
                </div>

                <div class="why-choose-grid">
                    <!-- Column 1 -->
                    <div class="why-col">
                        <div class="why-card">

                            <div class="why-icon">
                                <img src="{{ env('AWS_URL') }}/assets/images/qualitative/whychoose_image1.png"
                                    alt="Epignosis Insights Business Overview"  />
                            </div>
                            <p>Experienced Moderators Trained In Both Consumer And B2B/Stakeholder Interviewing Across
                                Multiple Industries And Geographies.</p>
                        </div>
                        <div class="why-card">

                            <div class="why-icon">
                              <img src="{{ env('AWS_URL') }}/assets/images/qualitative/whychoose_image4.png"
                                    alt="Epignosis Insights Business Overview"  />
                            </div>
                            <p>Rigorous Thematic Coding Frameworks That Make Findings Traceable, Auditable, And Easy To
                                Defend Internally.</p>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="why-col">
                        <div class="why-card">
                            <div class="why-icon">
                                <img src="{{ env('AWS_URL') }}/assets/images/qualitative/whychoose_image2.png"
                                    alt="Epignosis Insights Business Overview"  />
                            </div>
                            <p>End-To-End Delivery From Participant Recruitment To Final Reporting Managed By A Single
                                Accountable Research Team.</p>
                        </div>
                        <div class="why-card">

                            <div class="why-icon">
                                <img src="{{ env('AWS_URL') }}/assets/images/qualitative/whychoose_image5.png"
                                    alt="Epignosis Insights Business Overview"  />
                            </div>
                            <p>Flexible Formats: In-Person, Phone, And Secure Virtual Sessions, With Multilingual
                                Moderation For Multi-Market Studies.</p>
                        </div>
                    </div>

                    <!-- Column 3 -->
                    <div class="why-col why-col-large">
                        <div class="why-card why-card-tall">

                            <div class="why-icon why-icon-large">
                                  <img src="{{ env('AWS_URL') }}/assets/images/qualitative/whychoose_image3.png"
                                    alt="Epignosis Insights Business Overview"  />
                            </div>
                            <p>Reports Designed For Decision-Makers Concise Narratives Backed By Verbatim Evidence And
                                Clear Visual Synthesis, Not Raw Transcripts.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Get Started Section -->
            <section class="qual-get-started section-shell">
                <div class="get-started-box">
                    <h2>Get Started</h2>
                    <p>Whether you need a single round of exploratory interviews or an ongoing qualitative research program across markets, our team is ready to help you design a methodology that fits your objectives, timeline, and budget. Contact Epignosis Insights to discuss your next qualitative research project.</p>
                    <a href="/contact-us" class="get-started-btn">
                        Get in Touch
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 16 16 12 12 8"></polyline>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </a>
                </div>
            </section>

        </main>
        
        
    </div>


<style>
/* Scoped styles specifically for Qualitative Services */
.qual-hero {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 160px 20px 80px;
    text-align: center;
    min-height: 400px;
    display: flex;
    align-items: center;
}

.qual-hero-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.qual-title {
    font-size: 48px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 24px;
}

.qual-title .highlight-blue {
    color: #0783df;
}

.qual-subtitle {
    font-size: 18px;
    color: #0783df;
    font-weight: 600;
    max-width: 580px;
    margin: 0 auto 16px auto;
    line-height: 1.4;
}

.qual-desc {
    font-size: 15px;
    color: #4b5563;
    max-width: 750px;
    margin: 0 auto 40px auto;
    line-height: 1.6;
    padding: 0 40px;
    text-align: center;
}

.qual-hero-cta {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 16px;
    margin-top: 10px;
    width: 100%;
}

.qual-outline-btn {
    display: inline-block;
    padding: 12px 24px;
    border: 1px solid #cce4f7;
    border-radius: 9999px;
    background: #ffffff;
    color: #0783df;
    font-size: 13.5px;
    font-weight: 500;
    white-space: nowrap;
    transition: all 0.2s ease;
    cursor: default;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.qual-outline-btn:hover {
    border-color: #0783df;
    box-shadow: 0 4px 12px rgba(7, 131, 223, 0.15);
}

/* What is qualitative research section */
.qual-about-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    padding: 80px 20px;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.qual-text-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.qual-text-content h2 {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 24px;
    line-height: 1.3;
}

.qual-text-content p {
    font-size: 15px;
    color: #4b5563;
    line-height: 1.7;
    margin-bottom: 20px;
    text-align: justify;
}

.qual-image-content {
    display: flex;
    align-items: center;
    justify-content: center;
}

.qual-image {
    width: 80%;
    max-width: 600px;
    border-radius: 20px;
    border: 1px solid #0783df;
    box-shadow: 0 10px 30px rgba(7, 131, 223, 0.1);
    object-fit: cover;
}

/* Methodologies Section */
.qual-methodology-section {
    padding: 80px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.methodology-header {
    text-align: center;
    margin-bottom: 50px;
}

.methodology-header h2 {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 16px;
    line-height: 1.3;
}

.methodology-header p {
    font-size: 16px;
    color: #4b5563;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto;
}

.methodology-grid {
    display: grid;
    grid-template-columns: 45% 55%;
    gap: 40px;
    align-items: stretch;
}

.methodology-image-container {
    width: 100%;
    border-radius: 20px;
    border: 1px solid #cce4f7;
    overflow: hidden;
    background-color: #eff6ff; 
    display: flex;
    justify-content: center;
    align-items: center;
}

.qual-method-gif {
    width: 85%;
    height: 85%;
    object-fit: cover;
    display: block;
}

.methodology-cards {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.method-card {
    border: 1px solid #0783df;
    border-radius: 16px;
    padding: 15px 28px;
    background: #f4f9ff;
    box-shadow: 0 4px 12px rgba(7, 131, 223, 0.05);
}

.method-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.method-card-header h3 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.method-number {
    font-size: 56px;
    font-weight: 800;
    color: #0783df;
    line-height: 1;
}

.method-card-body p {
    font-size: 15px;
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 10px;
}

.method-card-body p:last-child {
    margin-bottom: 0;
}

.method-card-body strong {
    color: #374151;
    font-weight: 700;
}

/* Process Section */
.qual-process-section {
    padding: 0 20px 80px;
    max-width: 1200px;
    margin: 0 auto;
}

.process-header {
    margin-bottom: 50px;
    text-align: left;
}

.process-header h2 {
    font-size: 36px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 16px;
}

.process-header p {
    font-size: 16px;
    color: #4b5563;
    line-height: 1.6;
    max-width: 800px;
}

.process-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
}

.process-card {
    border: 1px solid #7cbbed;
    border-radius: 16px;
    padding: 32px 40px;
    background: #ffffff;
}

.process-number {
    position: relative;
    display: inline-flex;
    margin-bottom: 24px;
}

.num-text {
    font-size: 48px;
    font-weight: 800;
    color: #0783df;
    line-height: 1;
    z-index: 2;
    position: relative;
    margin-left: 8px;
}

.num-circle {
    position: absolute;
    width: 44px;
    height: 44px;
    background: #e6f2fd;
    border-radius: 50%;
    z-index: 1;
    top: 8px;
    left: 10px;
}

.process-card h3 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 12px 0;
}

.process-card p {
    font-size: 15px;
    color: #64748b;
    line-height: 1.7;
    margin: 0;
}

/* Decisions Section */
.qual-decisions-section {
    padding: 0 20px 80px;
    max-width: 1200px;
    margin: 0 auto;
}

.decisions-header {
    text-align: center;
    margin-bottom: 50px;
}

.decisions-header h2 {
    font-size: 36px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 16px;
}

.decisions-header p {
    font-size: 16px;
    color: #4b5563;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto;
}

.decisions-video-container {
    width: 100%;
    margin: 0 auto;
    border-radius: 20px;
    border: 1px solid #7cbbed;
    overflow: hidden;
    background-color: #eff6ff;
    display: flex;
    justify-content: center;
    align-items: center;
}

.qual-decision-video {
    width: 100%;
    height: auto;
    display: block;
    object-fit: cover;
}

/* Why Choose Us Section */
.qual-why-choose {
    padding: 40px 20px 80px;
    max-width: 1200px;
    margin: 0 auto;
}
.why-header {
    text-align: center;
    margin-bottom: 50px;
}
.why-header h2 {
    font-size: 36px;
    font-weight: 800;
    color: #111827;
    line-height: 1.4;
}
.why-choose-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
}
.why-col {
    display: flex;
    flex-direction: column;
    gap: 32px;
}
.why-card {
    position: relative;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid #7cbbed;
    border-radius: 16px;
    padding: 32px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.why-blob {
    position: absolute;
    background: #62a5f5;
    z-index: 0;
}
.blob-top-right {
    top: -30px;
    right: -30px;
    width: 180px;
    height: 110px;
    border-radius: 50% 30% 60% 40% / 40% 50% 60% 70%;
}
.blob-top-right-2 {
    top: -20px;
    right: -40px;
    width: 160px;
    height: 160px;
    border-radius: 40% 70% 30% 60% / 50% 40% 70% 50%;
}
.blob-bottom-right {
    bottom: -40px;
    right: -20px;
    width: 150px;
    height: 150px;
    border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%;
}
.blob-bottom-left {
    bottom: -40px;
    left: -40px;
    width: 200px;
    height: 150px;
    border-radius: 30% 70% 40% 60% / 40% 50% 60% 50%;
}
.blob-tall-right {
    bottom: -50px;
    right: -30px;
    width: 280px;
    height: 350px;
    border-radius: 60% 40% 70% 30% / 50% 30% 70% 40%;
}
.why-icon {
    position: relative;
    z-index: 1;
    margin-bottom: 40px;
}
.why-icon svg {
    width: 52px;
    height: 52px;
    color: #1a73e8;
}
.why-icon-large {
    margin-bottom: 24px;
}
.why-icon-large svg {
    width: 64px;
    height: 64px;
}
.why-card p {
    position: relative;
    z-index: 1;
    font-size: 15px;
    color: #1f2937;
    line-height: 1.6;
    margin: 0;
    font-weight: 500;
}
.why-card-tall {
    justify-content: flex-start;
}
.why-card-tall p {
    margin-top: auto; 
    font-size: 16px;
    line-height: 1.7;
}

/* Get Started Section */
.qual-get-started {
    padding: 20px 20px ;
    max-width: 1200px;
    margin: 0 auto;
}

.get-started-box {
    border: 1px solid #007bff;
    border-radius: 48px;
    padding: 80px 40px;
    text-align: center;
    background-color: #ffffff;
}

.get-started-box h2 {
    font-size: 56px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 24px;
}

.get-started-box p {
    font-size: 16px;
    color: #4b5563;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto 40px auto;
}

.get-started-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #0076ff;
    color: #ffffff;
    padding: 16px 32px;
    border-radius: 9999px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.2s;
}

.get-started-btn:hover {
    background-color: #005fcc;
    color: #ffffff;
}

.get-started-btn svg {
    width: 20px;
    height: 20px;
}

@media (max-width: 900px) {
    .qual-about-section {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .methodology-grid {
        grid-template-columns: 1fr;
    }

    .process-grid {
        grid-template-columns: 1fr;
    }

    .why-choose-grid {
        grid-template-columns: 1fr;
    }

    .qual-title {
        font-size: 36px;
    }
}

</style>
@endsection
