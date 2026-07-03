<template>
<section class="hero-section">
        <img :src="'/assets/images/hero-cards/card5.png'" alt="Monthly Market Insights" class="hero-img-card hero-card-left-top" />
        <img :src="'/assets/images/hero-cards/card3.png'" alt="Global Market Revenue" class="hero-img-card hero-card-left-bottom" />
        <img :src="'/assets/images/hero-cards/card4.png'" alt="Market Growth Rate" class="hero-img-card hero-card-right-top" />
        <img :src="'/assets/images/hero-cards/card2.png'" alt="Increase in Demand" class="hero-img-card hero-card-right-mid" />
        <img :src="'/assets/images/hero-cards/card1.png'" alt="Market Activity Trends" class="hero-img-card hero-card-right-bottom" />

        <div class="hero-content">
          <h1>Data-Driven <span>Insights</span> for <span>Smarter Business</span> Decisions</h1>
          <p>Access in-depth market research reports, industry analysis, and future forecasts to stay ahead of the competition.</p>
          <div class="hero-buttons">
            <router-link to="/reports" class="primary-button">Explore Reports</router-link>
            <router-link to="/press-releases" class="secondary-button">Press Release</router-link>
          </div>
          <div class="feature-pills">
            <span><IconChart /> Data-Backed Insights</span>
            <span><IconUsers /> Expert Analysts</span>
            <span><IconSliders /> Custom Research</span>
          </div>
        </div>
      </section>
</template>

<script setup>
import { IconChart, IconUsers, IconSliders } from '../icons'
</script>

