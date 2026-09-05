import { ref, onMounted } from 'vue'
import axios from 'axios'

export function useQualitative() {
    const insights = ref([])

    onMounted(async () => {
        try {
            const response = await axios.get('/api/blogs-public')
            if (response.data) {
                insights.value = response.data
            }
        } catch (error) {
            console.error('Failed to fetch blogs for qualitative page', error)
        }
    })

    return {
        insights
    }
}
