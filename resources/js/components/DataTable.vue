<template>
  <div class="animate-in fade-in duration-300">
    <div class="flex flex-col md:flex-row justify-between items-start md:flex-wrap md:items-center mb-6 gap-4">
      <div class="flex items-center flex-wrap gap-4">
        <h2 class="text-xl text-gray-100 font-semibold tracking-wide mr-2 drop-shadow-sm">{{ title }}</h2>
        <!-- Export Toolbar -->
        <div v-if="exportable" class="flex flex-wrap p-1 bg-gray-800/60 backdrop-blur-md shadow-lg rounded-xl border border-gray-700/50 items-center justify-center space-x-1">
           <button @click="exportData('copy')" class="px-3.5 py-1.5 rounded-lg bg-transparent hover:bg-blue-500/20 text-blue-400 text-sm font-medium transition-colors">Copy</button>
           <button @click="exportData('csv')" class="px-3.5 py-1.5 rounded-lg bg-transparent hover:bg-emerald-500/20 text-emerald-400 text-sm font-medium transition-colors">CSV</button>
           <button @click="exportData('excel')" class="px-3.5 py-1.5 rounded-lg bg-transparent hover:bg-emerald-500/20 text-emerald-400 text-sm font-medium transition-colors">Excel</button>
           <button @click="exportData('pdf')" class="px-3.5 py-1.5 rounded-lg bg-transparent hover:bg-rose-500/20 text-rose-400 text-sm font-medium transition-colors">PDF</button>
           <button @click="exportData('print')" class="px-3.5 py-1.5 rounded-lg bg-transparent hover:bg-gray-500/50 text-gray-300 text-sm font-medium transition-colors">Print</button>
        </div>
      </div>

      <div v-if="searchable" class="relative group mt-2 md:mt-0">
        <input 
          type="text" 
          v-model="internalSearch"
          @input="handleSearch"
          placeholder="Search items..."
          class="bg-gray-800/80 border text-gray-100 placeholder-gray-500 border-gray-700/50 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all w-full md:w-64 shadow-inner backdrop-blur" 
        />
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 absolute left-3.5 top-2.5 group-focus-within:text-teal-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
    </div>

    <!-- The actual print block area that will be injected if needed -->
    <div id="printTableArea" class="hidden"></div>

    <div class="overflow-hidden rounded-xl border border-gray-700/50 shadow-2xl transition-all duration-300 bg-gray-800/40 backdrop-blur-lg" :class="{ 'opacity-50 pointer-events-none': loading }">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-300" ref="tableRef">
          <thead class="text-xs text-gray-400 uppercase bg-gray-900/50 border-b border-gray-700/50">
            <tr>
              <!-- Sortable Headers -->
              <th 
                 v-for="header in sortableHeaders" 
                 :key="header.key" 
                 @click="header.sortable !== false ? handleSort(header.key) : null"
                 scope="col" 
                 class="px-5 py-4 font-semibold select-none group border-r border-gray-800/50 last:border-r-0 whitespace-nowrap"
                 :class="{ 'cursor-pointer hover:bg-gray-800 transition-colors': header.sortable !== false }"
              >
                <div class="flex items-center justify-between">
                  <span>{{ header.label }}</span>
                  <span v-if="header.sortable !== false" class="ml-2 flex flex-col items-center justify-center opacity-30 group-hover:opacity-100 transition-opacity">
                    <svg class="w-2.5 h-2.5 -mb-0.5" :class="{'opacity-100 text-teal-400 drop-shadow': sortKey === header.key && sortOrder === 'asc'}" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"></path></svg>
                    <svg class="w-2.5 h-2.5 -mt-0.5" :class="{'opacity-100 text-teal-400 drop-shadow': sortKey === header.key && sortOrder === 'desc'}" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path></svg>
                  </span>
                </div>
              </th>
              <th v-if="hasActions" scope="col" class="px-5 py-4 text-center font-semibold text-gray-400">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-700/50">
            <tr v-if="items.length === 0" class="hover:bg-gray-800/20 transition-colors">
              <td :colspan="headers.length + (hasActions ? 2 : 1)" class="px-5 py-6 text-center text-gray-500 italic">
                 <div class="flex flex-col items-center justify-center opacity-70">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    <span>No data found</span>
                 </div>
              </td>
            </tr>
            <tr v-for="(item, index) in items" :key="index" class="hover:bg-gray-800/40 transition-colors group">
              <!-- Inject Sr Column logic based on pagination offset -->
              <td class="px-5 py-4 border-r border-gray-700/30 text-gray-400 font-medium whitespace-nowrap">
                 {{ pagination.from + index }}
              </td>
              
              <td v-for="header in headers" :key="header.key" class="px-5 py-4 border-r border-gray-700/30 last:border-r-0 text-gray-200">
                <slot :name="`item-${header.key}`" :item="item">
                  <div>{{ item[header.key] }}</div>
                </slot>
              </td>
              <td v-if="hasActions" class="px-5 py-4 text-center">
                <div class="flex justify-center space-x-2">
                  <button 
                    @click="$emit('edit', item)"
                    class="bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 p-2 rounded-lg transition-colors flex items-center justify-center border border-blue-500/20"
                    title="Edit"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                  </button>
                  <button 
                    @click="$emit('delete', item)"
                    class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 p-2 rounded-lg transition-colors flex items-center justify-center border border-rose-500/20"
                    title="Delete"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="pagination && pagination.total > pagination.per_page" class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
      <div class="text-sm text-gray-500 bg-gray-800/40 px-3 py-1.5 rounded-lg border border-gray-700/50">
        Showing <span class="font-medium text-gray-300">{{ pagination.from }}</span> to <span class="font-medium text-gray-300">{{ pagination.to }}</span> of <span class="font-medium text-gray-300">{{ pagination.total }}</span> entries
      </div>
      <div class="flex space-x-1.5 bg-gray-800/40 p-1 rounded-xl border border-gray-700/50 shadow-sm">
        <button 
          @click="$emit('page-change', pagination.current_page - 1)"
          :disabled="pagination.current_page === 1"
          class="px-3.5 py-1.5 text-sm transition-all duration-200 rounded-lg flex items-center justify-center font-medium"
          :class="pagination.current_page === 1 ? 'text-gray-600 bg-transparent cursor-not-allowed' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
        >
          Previous
        </button>
        
        <template v-for="page in pagination.last_page" :key="page">
           <button 
            v-if="page === 1 || page === pagination.last_page || (page >= pagination.current_page - 1 && page <= pagination.current_page + 1)"
            @click="$emit('page-change', page)"
            class="w-9 h-auto py-1.5 text-sm rounded-lg transition-all duration-200 font-medium flex items-center justify-center"
            :class="pagination.current_page === page ? 'bg-teal-500/20 text-teal-400 border border-teal-500/30' : 'bg-transparent text-gray-400 hover:bg-gray-700 hover:text-white'"
          >
            {{ page }}
          </button>
          <span v-else-if="page === pagination.current_page - 2 || page === pagination.current_page + 2" class="px-2 py-1.5 text-gray-600">...</span>
        </template>

        <button 
          @click="$emit('page-change', Math.min(pagination.last_page, pagination.current_page + 1))"
          :disabled="pagination.current_page === pagination.last_page"
          class="px-3.5 py-1.5 text-sm transition-all duration-200 rounded-lg flex items-center justify-center font-medium"
          :class="pagination.current_page === pagination.last_page ? 'text-gray-600 bg-transparent cursor-not-allowed' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import * as XLSX from 'xlsx'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'

const props = defineProps({
  title: { type: String, default: 'Data List' },
  headers: { type: Array, required: true },
  items: { type: Array, required: true },
  loading: { type: Boolean, default: false },
  searchable: { type: Boolean, default: true },
  hasActions: { type: Boolean, default: true },
  pagination: { 
    type: Object, 
    default: () => ({ current_page: 1, last_page: 1, per_page: 20, total: 0, from: 0, to: 0 })
  },
  exportDataFn: { type: Function, default: null }, // Async function returning full dataset for export
  exportable: { type: Boolean, default: true },
})

const emit = defineEmits(['edit', 'delete', 'page-change', 'search', 'sort'])

const internalSearch = ref('')
let searchTimeout = null

const sortKey = ref('')
const sortOrder = ref('asc')

const handleSearch = () => {
    if (searchTimeout) clearTimeout(searchTimeout)
    searchTimeout = setTimeout(() => {
        emit('search', internalSearch.value)
    }, 500)
}

// Ensure Sr. column is always first in headers
const sortableHeaders = computed(() => {
  return [
    { key: 'sr', label: 'Sr', sortable: false },
    ...props.headers 
  ]
})

const handleSort = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortKey.value = key
        sortOrder.value = 'asc'
    }
    emit('sort', { key: sortKey.value, order: sortOrder.value })
}

// EXPORT FUNCTIONALITY
const tableRef = ref(null)

const processExportData = async () => {
    let rawData = []
    if (props.exportDataFn) {
        try {
            rawData = await props.exportDataFn();
        } catch (e) {
            console.error("Export fetch failed", e);
            rawData = props.items;
        }
    } else {
        rawData = props.items;
    }

    // Format Data
    const formatted = rawData.map((item, index) => {
        let row = { 'Sr': index + 1 }
        props.headers.forEach(h => {
             // Basic resolution if data is nested or simple
             let val = item[h.key]
             if (h.key === 'report_category' && item.report_category) val = item.report_category.name
             if (h.key === 'report_list' && item.report_list) val = item.report_list.name
             if (h.key === 'created_at') val = new Intl.DateTimeFormat('en-US', { year: 'numeric', month: 'short', day: 'numeric' }).format(new Date(item.created_at))
             row[h.label] = val
        })
        return row
    })
    return formatted
}

const exportData = async (type) => {
    const data = await processExportData()
    if (!data.length) return alert('No data available to export.')

    const headersArray = Object.keys(data[0])
    const rowsArray = data.map(obj => Object.values(obj))

    if (type === 'copy') {
        const textToCopy = [headersArray.join('\t'), ...rowsArray.map(r => r.join('\t'))].join('\n')
        navigator.clipboard.writeText(textToCopy)
        alert('Copied to clipboard!')
    } 
    else if (type === 'csv') {
        const csvContent = [headersArray.map(h => `"${h}"`).join(','), ...rowsArray.map(r => r.map(v => `"${v ?? ''}"`).join(','))].join('\n')
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' })
        const url = URL.createObjectURL(blob)
        const link = document.createElement("a")
        link.href = url
        link.download = `${props.title.replace(/\s+/g, '_')}_Export.csv`
        link.click()
    }
    else if (type === 'excel') {
        const worksheet = XLSX.utils.json_to_sheet(data)
        const workbook = XLSX.utils.book_new()
        XLSX.utils.book_append_sheet(workbook, worksheet, props.title)
        XLSX.writeFile(workbook, `${props.title.replace(/\s+/g, '_')}_Export.xlsx`)
    }
    else if (type === 'pdf') {
        const doc = new jsPDF('landscape')
        doc.text(props.title, 14, 15)
        autoTable(doc, {
            head: [headersArray],
            body: rowsArray,
            startY: 20,
            styles: { fontSize: 8 },
            headStyles: { fillColor: [41, 128, 185] }
        })
        doc.save(`${props.title.replace(/\s+/g, '_')}_Export.pdf`)
    }
    else if (type === 'print') {
        const printContent = `
            <html>
                <head>
                    <title>Print - ${props.title}</title>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        h2 { text-align: center; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    <h2>${props.title}</h2>
                    <table>
                        <thead><tr>${headersArray.map(h => `<th>${h}</th>`).join('')}</tr></thead>
                        <tbody>${rowsArray.map(r => `<tr>${r.map(v => `<td>${v ?? ''}</td>`).join('')}</tr>`).join('')}</tbody>
                    </table>
                </body>
            </html>
        `
        const printWindow = window.open('', '_blank')
        printWindow.document.write(printContent)
        printWindow.document.close()
        printWindow.focus()
        setTimeout(() => { printWindow.print(); printWindow.close(); }, 250)
    }
}
</script>
