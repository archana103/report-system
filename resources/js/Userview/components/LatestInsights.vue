<template>
<section class="content-row-section insights-section">
        <div class="section-heading row-heading">
          <div>
            <h2>Latest Insights</h2>
            <p>Explore expert perspectives, industry trends, and data-driven stories shaping global markets.</p>
          </div>
          <div class="slider-controls">
            <button aria-label="Previous" @click="$emit('prev')"><ArrowLeft /></button>
            <button class="active" aria-label="Next" @click="$emit('next')"><ArrowRight /></button>
          </div>
        </div>
        <div class="insight-strip">
          <article v-for="item in insights" :key="item.title" class="insight-card">
            <img :src="item.image" :alt="item.title" />
            <h3>{{ item.title }}</h3>
            <p>{{ item.description }}</p>
          </article>
        </div>
        <div class="center-action">
          <router-link to="/blogs" class="primary-button small">Read More <CircleArrow /></router-link>
        </div>
      </section>
</template>

<script setup>
import { ArrowRight, ArrowLeft, CircleArrow } from '../icons'

defineProps(['insights'])
defineEmits(['next', 'prev'])
</script>

