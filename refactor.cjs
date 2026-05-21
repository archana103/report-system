const fs = require('fs');
const path = require('path');

const srcDir = path.join(__dirname, 'resources', 'js', 'Userview');
const componentsDir = path.join(srcDir, 'components');

if (!fs.existsSync(componentsDir)) {
    fs.mkdirSync(componentsDir, { recursive: true });
}

const indexVue = fs.readFileSync(path.join(srcDir, 'index.vue'), 'utf8');

// Helper to extract a tag
function extractTag(content, tag) {
    const regex = new RegExp(`<${tag}[^>]*>([\\s\\S]*?)<\\/${tag}>`);
    const match = content.match(regex);
    return match ? match[1].trim() : '';
}

const template = extractTag(indexVue, 'template');

// Split sections
const headerHtml = template.match(/<header class="site-header">[\s\S]*?<\/header>/)[0];
const heroHtml = template.match(/<section class="hero-section">[\s\S]*?<\/section>/)[0];
const reportsHtml = template.match(/<section id="reports" class="reports-section section-shell">[\s\S]*?<\/section>/)[0];
const pressHtml = template.match(/<section class="content-row-section">[\s\S]*?<div class="section-heading row-heading">[\s\S]*?<h2>Press Releases<\/h2>[\s\S]*?<\/section>/)[0];
const insightsHtml = template.match(/<section class="content-row-section insights-section">[\s\S]*?<\/section>/)[0];
const servicesHtml = template.match(/<section class="services-section">[\s\S]*?<\/section>/)[0];
const aboutHtml = template.match(/<section class="about-section section-shell">[\s\S]*?<\/section>/)[0];
const contactHtml = template.match(/<section id="contact" class="cta-section">[\s\S]*?<\/section>/)[0];
const footerHtml = template.match(/<footer class="footer-section">[\s\S]*?<\/footer>/)[0];

// Save components
const components = {
    'SiteHeader': { html: headerHtml, props: [] },
    'HeroSection': { html: heroHtml, props: [] },
    'TrendingReports': { html: reportsHtml, props: ['categories', 'activeCategory', 'reports'] },
    'PressReleases': { html: pressHtml, props: ['pressReleases'] },
    'LatestInsights': { html: insightsHtml, props: ['insights'] },
    'ServicesSection': { html: servicesHtml, props: [] },
    'AboutSection': { html: aboutHtml, props: [] },
    'ContactSection': { html: contactHtml, props: [] },
    'SiteFooter': { html: footerHtml, props: [] }
};

// Write icons to icons.js
const scriptContent = extractTag(indexVue, 'script');
const iconMatches = scriptContent.match(/(const iconBase = [\s\S]*?const PhoneMini = [^\n]*)/);
let iconsCode = '';
if (iconMatches) {
    iconsCode = `import { h } from 'vue'\n\n${iconMatches[1].replace(/const/g, 'export const')}`;
    fs.writeFileSync(path.join(srcDir, 'icons.js'), iconsCode);
}

// Generate useHomeData.js
const composableCode = `import { computed, ref, watch, onMounted } from 'vue'
import axios from 'axios'

export function useHomeData() {
    const activeCategory = ref('All')
    const categories = ref(['All'])
    const reports = ref([])
    const pressReleases = ref([])
    const insights = ref([])

    onMounted(async () => {
        try {
            const response = await axios.get('/admin/report-categories-dropdown')
            if (response.data && response.data.length > 0) {
                categories.value = ['All', ...response.data.map(cat => cat.name)]
            }
        } catch (error) {
            console.error('Failed to fetch categories', error)
        }
    })

    const fetchReports = async (category) => {
        try {
            const response = await axios.get('/api/reports-by-category', { params: { category } })
            reports.value = response.data
        } catch (error) {
            console.error('Failed to fetch reports', error)
        }

        try {
            const prRes = await axios.get('/api/press-releases-public')
            pressReleases.value = prRes.data
        } catch (error) {
            console.error('Failed to fetch press releases', error)
        }

        try {
            const blogRes = await axios.get('/api/blogs-public')
            insights.value = blogRes.data
        } catch (error) {
            console.error('Failed to fetch blogs', error)
        }
    }

    watch(activeCategory, (newVal) => {
        fetchReports(newVal)
    }, { immediate: true })

    const visiblePressReleases = computed(() => pressReleases.value.slice(0, 3))
    const nextPressRelease = () => {
        if (pressReleases.value.length > 0) {
            const first = pressReleases.value.shift()
            pressReleases.value.push(first)
        }
    }
    const prevPressRelease = () => {
        if (pressReleases.value.length > 0) {
            const last = pressReleases.value.pop()
            pressReleases.value.unshift(last)
        }
    }

    const visibleInsights = computed(() => insights.value.slice(0, 3))
    const nextInsight = () => {
        if (insights.value.length > 0) {
            const first = insights.value.shift()
            insights.value.push(first)
        }
    }
    const prevInsight = () => {
        if (insights.value.length > 0) {
            const last = insights.value.pop()
            insights.value.unshift(last)
        }
    }

    return {
        activeCategory,
        categories,
        reports,
        pressReleases,
        visiblePressReleases,
        nextPressRelease,
        prevPressRelease,
        insights,
        visibleInsights,
        nextInsight,
        prevInsight
    }
}
`;
fs.writeFileSync(path.join(srcDir, 'useHomeData.js'), composableCode);


// Write each component
for (const [name, data] of Object.entries(components)) {
    let scriptBlock = `<script setup>\n`;
    
    // Add props if needed
    if (data.props.length > 0) {
        // We will just define props or let the component do its own state if it makes sense.
        // Actually since we are passing events, let's keep it simple: emit events for rotation, 
        // OR pass functions as props (wait, emit is better).
    }
    
    // Add icon imports
    const usedIcons = [];
    ['IconChart', 'IconUsers', 'IconSliders', 'IconTarget', 'IconBrief', 'IconTrend', 'IconBulb', 'IconPin', 'IconMail', 'PhoneMini', 'ArrowRight', 'ArrowLeft', 'CircleArrow'].forEach(icon => {
        if (data.html.includes(icon)) {
            usedIcons.push(icon);
        }
    });

    if (usedIcons.length > 0) {
        scriptBlock += `import { ${usedIcons.join(', ')} } from '../icons'\n`;
    }

    if (name === 'TrendingReports') {
        scriptBlock += `\ndefineProps(['categories', 'activeCategory', 'reports'])\ndefineEmits(['update:activeCategory'])\n`;
    }
    if (name === 'PressReleases') {
        scriptBlock += `\ndefineProps(['pressReleases'])\ndefineEmits(['next', 'prev'])\n`;
    }
    if (name === 'LatestInsights') {
        scriptBlock += `\ndefineProps(['insights'])\ndefineEmits(['next', 'prev'])\n`;
    }
    if (name === 'ServicesSection') {
        // extract services array
        scriptBlock += `\nconst services = [\n  { title: 'Market Research Reports', description: 'Comprehensive reports covering market size, key trends, and future forecasts.', icon: IconBrief, position: 'top-left' },\n  { title: 'Custom Research Solutions', description: 'Tailored research designed to match your business goals and target markets.', icon: IconTarget, position: 'top-right' },\n  { title: 'Industry Analysis', description: 'Detailed insights into industry trends, growth drivers, and opportunities.', icon: IconTrend, position: 'bottom-left' },\n  { title: 'Consulting Services', description: 'Expert guidance to help you interpret data and make strategic decisions.', icon: IconBulb, position: 'bottom-right' }\n]\n`;
    }
    if (name === 'AboutSection') {
        // extract aboutStats array
        scriptBlock += `\nconst aboutStats = [\n  { value: '500+', label: 'Reports Published', icon: IconBrief },\n  { value: '100+', label: 'Global Clients', icon: IconUsers },\n  { value: '20+', label: 'Industries Covered', icon: IconSliders },\n  { value: '50+', label: 'Countries Analyzed', icon: IconPin }\n]\n`;
    }

    scriptBlock += `</script>\n\n`;

    // Modify HTML for emits
    let html = data.html;
    if (name === 'TrendingReports') {
        html = html.replace('@click="activeCategory = category"', `@click="$emit('update:activeCategory', category)"`);
    }
    if (name === 'PressReleases') {
        html = html.replace('v-for="item in visiblePressReleases"', 'v-for="item in pressReleases"');
        html = html.replace('@click="prevPressRelease"', `@click="$emit('prev')"`);
        html = html.replace('@click="nextPressRelease"', `@click="$emit('next')"`);
    }
    if (name === 'LatestInsights') {
        html = html.replace('v-for="item in visibleInsights"', 'v-for="item in insights"');
        html = html.replace('@click="prevInsight"', `@click="$emit('prev')"`);
        html = html.replace('@click="nextInsight"', `@click="$emit('next')"`);
    }

    let compContent = `<template>\n${html}\n</template>\n\n${scriptBlock}`;
    fs.writeFileSync(path.join(componentsDir, `${name}.vue`), compContent);
}

// Generate new index.vue
const newIndexVue = `<template>
  <div class="home-page">
    <SiteHeader />
    <main>
      <HeroSection />
      <TrendingReports 
        :categories="categories" 
        :activeCategory="activeCategory" 
        :reports="reports" 
        @update:activeCategory="activeCategory = $event" 
      />
      <PressReleases 
        :pressReleases="visiblePressReleases" 
        @next="nextPressRelease" 
        @prev="prevPressRelease" 
      />
      <LatestInsights 
        :insights="visibleInsights" 
        @next="nextInsight" 
        @prev="prevInsight" 
      />
      <ServicesSection />
      <AboutSection />
      <ContactSection />
    </main>
    <SiteFooter />
  </div>
</template>

<script setup>
import { useHomeData } from './useHomeData'
import SiteHeader from './components/SiteHeader.vue'
import HeroSection from './components/HeroSection.vue'
import TrendingReports from './components/TrendingReports.vue'
import PressReleases from './components/PressReleases.vue'
import LatestInsights from './components/LatestInsights.vue'
import ServicesSection from './components/ServicesSection.vue'
import AboutSection from './components/AboutSection.vue'
import ContactSection from './components/ContactSection.vue'
import SiteFooter from './components/SiteFooter.vue'

const {
  activeCategory,
  categories,
  reports,
  visiblePressReleases,
  nextPressRelease,
  prevPressRelease,
  visibleInsights,
  nextInsight,
  prevInsight
} = useHomeData()
</script>

<style src="./style.css"></style>
`;

fs.writeFileSync(path.join(srcDir, 'index.vue'), newIndexVue);
console.log('Refactoring complete!');
