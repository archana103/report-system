<template>
<section class="content-row-section">
        <div class="section-heading row-heading">
          <div>
            <h2>Press Releases</h2>
            <p>Latest announcements, research highlights, and industry updates from our analysts.</p>
          </div>
          <div class="slider-controls">
            <button aria-label="Previous" @click="$emit('prev')"><ArrowLeft /></button>
            <button class="active" aria-label="Next" @click="$emit('next')"><ArrowRight /></button>
          </div>
        </div>
        <div class="story-grid">
          <article v-for="item in pressReleases" :key="item.title" class="story-card">
            <img :src="item.image" :alt="item.title" />
            <p class="story-date">{{ item.date }}</p>
            <h3>{{ item.title }}</h3>
            <p>{{ item.description }}</p>
          </article>
        </div>
        <div class="center-action">
          <a href="#" class="primary-button small">Read More <CircleArrow /></a>
        </div>
      </section>
</template>

<script setup>
import { ArrowRight, ArrowLeft, CircleArrow } from '../icons'

defineProps(['pressReleases'])
defineEmits(['next', 'prev'])
</script>

