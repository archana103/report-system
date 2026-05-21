import { computed, ref, watch, onMounted } from 'vue'
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
