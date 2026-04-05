<template>
  <div class="animate-in fade-in duration-300">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl text-gray-200 font-medium">Category List</h2>
      <div class="relative">
        <input type="text" placeholder="Search categories..." class="bg-gray-800/80 border border-gray-700 rounded-xl pl-10 pr-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all w-64" />
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-3.5 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-700/50 shadow-sm">
      <table class="w-full text-left text-sm text-gray-400">
        <thead class="text-xs text-gray-300 uppercase bg-gray-800/80 border-b border-gray-700/50">
          <tr>
            <th scope="col" class="px-6 py-4 font-semibold">Category Name</th>
            <th scope="col" class="px-6 py-4 font-semibold">Description</th>
            <th scope="col" class="px-6 py-4 font-semibold">Status</th>
            <th scope="col" class="px-6 py-4 text-right font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-700/50 bg-gray-800/30">
          <tr class="hover:bg-gray-800/60 transition-colors">
            <td class="px-6 py-4">
              <div class="font-medium text-gray-200">Financial Reports</div>
            </td>
            <td class="px-6 py-4">Monthly and annual financial statements</td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5"></span>
                Active
              </span>
            </td>
            <td class="px-6 py-4 text-right">
              <button class="text-teal-400 hover:text-teal-300 transition-colors p-1.5 rounded hover:bg-teal-400/10">Edit</button>
            </td>
          </tr>
          <tr class="hover:bg-gray-800/60 transition-colors">
            <td class="px-6 py-4">
              <div class="font-medium text-gray-200">User Activity</div>
            </td>
            <td class="px-6 py-4">Logs and analytics of user sessions</td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5"></span>
                Active
              </span>
            </td>
            <td class="px-6 py-4 text-right">
              <button class="text-teal-400 hover:text-teal-300 transition-colors p-1.5 rounded hover:bg-teal-400/10">Edit</button>
            </td>
          </tr>
          <tr class="hover:bg-gray-800/60 transition-colors">
            <td class="px-6 py-4">
              <div class="font-medium text-gray-200">System Logs</div>
            </td>
            <td class="px-6 py-4">Administrative actions and errors</td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-500/10 text-gray-400 border border-gray-500/20">
                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span>
                Inactive
              </span>
            </td>
            <td class="px-6 py-4 text-right">
              <button class="text-teal-400 hover:text-teal-300 transition-colors p-1.5 rounded hover:bg-teal-400/10">Edit</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
