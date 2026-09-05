<template>
    <div class="qualitative-page">
        <SiteHeader />

        <main class="qualitative-main">
            <!-- Hero Section -->
            <section class="qual-hero"
                :style="{ backgroundImage: 'url(' + $assetUrl + '/assets/images/qualitative/Herosection_image.png)' }">
                <div class="qual-hero-content section-shell">
                    <h1 class="qual-title">
                        Qualitative <span class="highlight-blue">Research</span>
                    </h1>
                    <p class="qual-subtitle">In-Depth Interviews, Focus Groups & Surveys That Reveal the “Why” Behind
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
                    <img :src="$assetUrl + '/assets/images/qualitative/qualitativeimage1.png'"
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
                            <source :src="$assetUrl + '/assets/images/qualitative/qualitative_image2.mp4'"
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
                                <p><strong>What it is:</strong> One-on-one, semi-structured interviews (30–60 minutes).
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
                                <p><strong>What it is:</strong> Moderated discussions with 6–9 participants.</p>
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
                        <source :src="$assetUrl + '/assets/images/qualitative/qualitative_image1.mp4'"
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
                                <img :src="$assetUrl + '/assets/images/qualitative/whychoose_image1.png'"
                                    alt="Epignosis Insights Business Overview"  />
                            </div>
                            <p>Experienced Moderators Trained In Both Consumer And B2B/Stakeholder Interviewing Across
                                Multiple Industries And Geographies.</p>
                        </div>
                        <div class="why-card">

                            <div class="why-icon">
                              <img :src="$assetUrl + '/assets/images/qualitative/whychoose_image4.png'"
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
                                <img :src="$assetUrl + '/assets/images/qualitative/whychoose_image2.png'"
                                    alt="Epignosis Insights Business Overview"  />
                            </div>
                            <p>End-To-End Delivery From Participant Recruitment To Final Reporting Managed By A Single
                                Accountable Research Team.</p>
                        </div>
                        <div class="why-card">

                            <div class="why-icon">
                                <img :src="$assetUrl + '/assets/images/qualitative/whychoose_image5.png'"
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
                                  <img :src="$assetUrl + '/assets/images/qualitative/whychoose_image3.png'"
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
        <div style="height:150px"></div>
        <SiteFooter />
    </div>
</template>

<script setup>
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
import { useQualitative } from './qualitative.js'

const { insights } = useQualitative()
</script>

<style src="./style.css"></style>
<style scoped src="./qualitativeStyle.css"></style>
