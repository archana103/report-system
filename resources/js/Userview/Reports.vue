<template>
<div class="reports-page">
    <SiteHeader />

    <main class="reports-main">
        <ReportsHeroSection />

        <section class="reports-content section-shell reports-two-column-layout">
            <div class="reports-main-column">
                <ReportList :reports="reports" :loading="loading" />
                <ReportPagination :currentPage="currentPage" :totalPages="totalPages" :paginationRange="paginationRange" @page-change="fetchReports" />
            </div>
            
            <aside class="reports-sidebar-column">
                <ReportsFilterBar v-model:searchQuery="searchQuery" v-model:selectedCategory="selectedCategory" :categories="categories" @search="fetchReports(1)" class="sidebar-search-widget" />
                <TopSellingReportsWidget />
            </aside>
        </section>

        <CustomResearchCTA />
    </main>

    <SiteFooter />
</div>
</template>

<script setup>
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
import ReportsHeroSection from './components/ReportsHeroSection.vue'
import ReportsFilterBar from './components/ReportsFilterBar.vue'
import ReportList from './components/ReportList.vue'
import ReportPagination from './components/ReportPagination.vue'
import CustomResearchCTA from './components/CustomResearchCTA.vue'
import TopSellingReportsWidget from './components/TopSellingReportsWidget.vue'
import {
    useReportsData
} from './useReportsData'

const {
    categories,
    selectedCategory,
    searchQuery,
    reports,
    loading,
    currentPage,
    totalPages,
    fetchReports,
    paginationRange
} = useReportsData()
</script>

<style src="./style.css"></style>
<style src="./reportsStyle.css"></style>\n
