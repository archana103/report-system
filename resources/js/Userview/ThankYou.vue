<template>
  <div class="thankyou-page">
    <SiteHeader />

    <main class="thankyou-main">
      <div class="thankyou-container section-shell">
        <h1 class="thankyou-title">Thank You for Your Request!</h1>
        <p class="thankyou-message">
          We've received your inquiry successfully. Our team will review your request and get back to you shortly with the relevant details and next steps.
        </p>
        <div class="thankyou-actions">
          <router-link to="/reports" class="primary-button">Explore Reports</router-link>
          <router-link to="/" class="secondary-button">Back to Home</router-link>
        </div>
      </div>
    </main>

    <SiteFooter />
  </div>
</template>

<script setup>
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
</script>

<style src="./style.css"></style>
<style src="./thankYouStyle.css"></style>
