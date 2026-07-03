<template>
<section class="about-section section-shell">
        <div class="about-copy">
          <h2>About Us</h2>
          <p>We are a leading market research and consulting firm dedicated to delivering accurate, data-driven insights that empower businesses to make informed decisions. Our expertise spans across multiple industries, helping organizations understand evolving market dynamics, emerging trends, and competitive landscapes.</p>
          <p>Our research combines advanced analytics, industry expertise, and reliable data sources to provide actionable intelligence that drives growth and innovation. From comprehensive market reports to fully customized research solutions, we ensure every insight is tailored to meet specific business objectives.</p>
          <p>With a strong focus on quality, transparency, and precision, our team of experienced analysts works closely with clients to uncover opportunities, mitigate risks, and support long-term strategic planning.</p>
        </div>
        <img class="about-image" :src="$assetUrl + '/assets/images/aboutus.png'" alt="Analysts reviewing a market report" />
        <div class="about-stats">
          <div v-for="stat in aboutStats" :key="stat.label">
            <span class="icon-span">
              <img v-if="stat.image" :src="$assetUrl + stat.image" alt="Stat Icon" class="stat-img-icon" />
              <component v-else :is="stat.icon" />
            </span>
            <strong>{{ stat.value }}</strong>
            <p>{{ stat.label }}</p>
          </div>
        </div>
      </section>
</template>

<script setup>
import { IconBrief, IconUsers, IconSliders, IconPin } from '../icons'

const aboutStats = [
  { value: '500+', label: 'Reports Published', image: '/assets/images/about_icons/icon1.png' },
  { value: '100+', label: 'Global Clients', image: '/assets/images/about_icons/icon3.png' },
  { value: '20+', label: 'Industries Covered', image: '/assets/images/about_icons/icon2.png' },
  { value: '50+', label: 'Countries Analyzed', image: '/assets/images/about_icons/icon1.png' }
]
</script>

