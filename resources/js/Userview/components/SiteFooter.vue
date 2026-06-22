<template>
<footer class="footer-section">
      <div class="footer-top">
        <div>
          <a class="brand footer-brand" href="#">
            <img :src="$assetUrl + '/assets/images/logo.png'" alt="Epignosis Insights Logo" class="brand-logo" />
          </a>
          <p>Delivering data-driven insights to support smarter business decisions.</p>
          <form class="footer-form">
            <input type="email" placeholder="Email Address" />
            <button type="submit">Show Now!</button>
          </form>
        </div>
        <div class="footer-contact">
          <p><span><IconPin /></span>123 Maple Street, Pune, India</p>
          <p><span><IconMail /></span>sale@Epignosisinsights.com</p>
          <p><span><PhoneMini /></span>+91 6292226351</p>
        </div>
      </div>
      <div class="footer-links">
        <nav>
          <router-link to="/">Home</router-link>
          <router-link to="/about">About Us</router-link>
          <router-link to="/reports">Reports</router-link>
          <router-link to="/blogs">Blogs</router-link>
          <router-link to="/press-releases">Press Release</router-link>
          <a href="#">Contact</a>
        </nav>
        <div class="social-links">
          <a href="#">f</a>
          <a href="#">in</a>
          <a href="#">x</a>
          <a href="#">ig</a>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2025 epignosisinsights. All rights reserved.</p>
        <div>
          <a href="#">Teams & Conditions</a>
          <a href="#">Privacy Policy</a>
        </div>
      </div>
    </footer>
</template>

<script setup>
import { IconPin, IconMail, PhoneMini } from '../icons'
</script>

