<template>
<section class="hero-section">
        <div class="hero-ring" aria-hidden="true"></div>
        <div class="hero-card hero-card-left-top">
          <p>Monthly Market Insights</p>
          <div class="mini-bars tall">
            <span v-for="n in 24" :key="`top-${n}`" :style="{ height: `${20 + ((n * 11) % 64)}px` }"></span>
          </div>
          <small>Global Market Trends - 2025</small>
        </div>
        <div class="hero-card hero-card-left-bottom">
          <small>Industry Analysis</small>
          <h3>Global Market Revenue</h3>
          <div class="mini-bars">
            <span v-for="n in 12" :key="`rev-${n}`" :style="{ height: `${30 + ((n * 17) % 76)}px` }"></span>
          </div>
          <div class="card-metrics">
            <small>Current Growth</small>
            <small>$920B</small>
            <small>$1.4T</small>
          </div>
        </div>
        <div class="hero-card hero-card-right-top">
          <div class="donut"><span>65%</span></div>
          <p>Market Growth Rate</p>
          <small>Projected CAGR 2025-2030</small>
        </div>
        <div class="hero-card hero-card-right-mid">
          <strong>65%</strong>
          <small>Increase in Demand</small>
          <div class="tiny-bars">
            <span v-for="n in 6" :key="`tiny-${n}`" :style="{ height: `${12 + ((n * 13) % 34)}px` }"></span>
          </div>
        </div>
        <div class="hero-card hero-card-right-bottom">
          <p>Market Activity Trends</p>
          <div class="mini-bars short">
            <span v-for="n in 7" :key="`activity-${n}`" :style="{ height: `${28 + ((n * 19) % 75)}px` }"></span>
          </div>
          <small>S M T W T F S</small>
        </div>

        <div class="hero-content">
          <h1>Data-Driven <span>Insights</span> for <span>Smarter Business</span> Decisions</h1>
          <p>Access in-depth market research reports, industry analysis, and future forecasts to stay ahead of the competition.</p>
          <div class="hero-buttons">
            <a href="#reports" class="primary-button">Explore Reports</a>
            <a href="#contact" class="secondary-button">Request Custom Research</a>
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

